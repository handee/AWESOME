<?

global $db;

require "db.php";
if ($db->connect_errno)
	throw "Failed to connect";

function getRows($stmt) { //PHP prepared statements are shit
    $meta = $stmt->result_metadata();
    while ($field = $meta->fetch_field())
    {
        $params[] = &$row[$field->name];
    }

    call_user_func_array(array($stmt, 'bind_result'), $params);

    while ($stmt->fetch()) {
        foreach($row as $key => $val)
        {
            $c[$key] = $val;
        }
        $result[] = $c;
    }
    return $result;
}

function getStudentDetails($student) {
	if ($stmt = $db->prepare("SELECT * FROM Students WHERE `StudentID`=?"))
	{
		$stmt->bind_param("s", $student);
		$stmt->execute();
		return getRow($stmt);
	}
}

function getStudentModules($student) {
	global $db;

	$stmt = $db->prepare("
		SELECT StudentsToModules.ModuleID AS ModuleID, Modules.ModuleTitle as ModuleTitle
		FROM Modules

		JOIN StudentsToModules ON StudentsToModules.ModuleID = Modules.ModuleID
		WHERE StudentsToModules.UserID=?");

	$stmt->bind_param("s", $student);
	$stmt->execute();

	$rows = getRows($stmt);

	$lecturers = getStudentModuleLecturers($student);
	foreach ($rows as &$row) {
		if (array_key_exists($row["ModuleID"], $lecturers)) {
			$row["Staff"] = $lecturers[$row["ModuleID"]];
		}
		else {
			$row["Staff"] = Array();
		}
	}

	return $rows;
}

function getStudentModuleLecturers($student) {
	global $db;

	$stmt = $db->prepare("
		SELECT StaffToModules.ModuleID AS ModuleID, StaffToModules.UserID AS StaffID, Staff.Name as StaffName
		FROM Staff
		RIGHT JOIN StaffToModules ON StaffToModules.UserID = Staff.UserID");


	//$stmt->bind_param("s", $student);
	$stmt->execute();
	$rows = getRows($stmt);

	$lecturers = array();
	foreach($rows as $row) {
		$lecturers[$row["ModuleID"]][] = $row;
	}
	return $lecturers;
}

function getQuestions() {
	global $db;

	$stmt = $db->prepare("SELECT * from Questions");

	$stmt->execute();
	$rows = getRows($stmt);

	return $rows;
}

function getPreparedQuestions($student, $answers = array()) {
	$questions = getQuestions();
	$modules = getStudentModules($student);

	foreach($modules as $mkey => &$module) {

		$module["Questions"] = array();

		foreach($questions as $question) {
			$identifier = "{$module["ModuleID"]}_{$question["QuestionID"]}";
			if ($question["Staff"] == 0) {
				$question["Identifier"] = $identifier;

				$module["Questions"][] = $question;
			}
			else {
				foreach($module["Staff"] as $staff) {
					$mquestion = $question; //copy question
					$staff_identifier = "{$identifier}_{$staff["StaffID"]}";

					$mquestion["Identifier"] = $staff_identifier;
					$mquestion["QuestionText"] = sprintf($question["QuestionText"], $staff["StaffName"]);
					$mquestion["StaffID"] = $staff["StaffID"];
					$module["Questions"][] = $mquestion;
				}
			}
		}
		foreach($module["Questions"] as $key => $question) {
			if (array_key_exists($question["Identifier"], $answers)) {
				$module["Questions"][$key]["Answer"] = $answers[$question["Identifier"]];
			}
			else {
				$module["Questions"][$key]["Answer"] = "";
			}
		}
	}
	return $modules;
}

function answers_filled($modules) {
	foreach($modules as $module) {
		foreach($module["Questions"] as $question) {
			if ($question["Answer"] == "") {
				return false;
			}
		}
	}
	return true;
}

function answers_submit($modules) {
	global $db;
	$db->autocommit(false);

	$stmt = $db->prepare("INSERT INTO AnswerGroup VALUES ()");
	$stmt->execute();
	$stmt->close();

	$answerID = $db->insert_id;

	$stmt = $db->prepare("INSERT INTO Answers (AnswerID, QuestionID, ModuleID, StaffID, NumValue, TextValue) VALUES (?,?,?,?,?,?)");
	foreach($modules as $module) {
		foreach($module["Questions"] as $question) {
			$StaffID = "";
			$NumValue = null;
			$TextValue = null;
			if ($question["Staff"] == 1)
				$StaffID = $question["StaffID"];
			if ($question["Type"] == "rate") {
				$NumValue = $question["Answer"];
			}
			elseif ($question["Type"] == "text") {
				$TextValue = $question["Answer"];
			}

			$stmt->bind_param("iissis", $answerID, $question["QuestionID"], $module["ModuleID"], $StaffID, $NumValue, $TextValue);
			$stmt->execute();
		}
	}
	if (!$db->commit()) {
		$db->rollback();
	}
}
