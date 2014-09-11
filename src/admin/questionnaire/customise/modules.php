<?
/**
 * @file
 * @version 1.0
 * @date 07/09/2014
 * @author Keiron-Teilo O'Shea <keo7@aber.ac.uk> 
 * 	
 */

require "../../../lib.php";
require_once "{$root}/lib/Twig/Autoloader.php";

Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem("{$root}/admin/tpl/");
$twig = new Twig_Environment($loader, array());

$template = $twig->loadTemplate('questionnaire/customise/modules.html');

$questionnaireID = $_GET["questionnaireID"];
$alerts = array();

/**
 * Add a new question group
 * 
 * @param array $details Group details (QuestionnaireID, ModuleID, ModuleTitle)
 */
function insertGroup($details) {
	global $questionnaireID, $alerts, $db;
	try {
		$stmt = new tidy_sql($db, "INSERT INTO Modules (QuestionaireID, ModuleID, ModuleTitle, Fake) VALUES (?,?,?,1)", "iss");
		$stmt->query($questionnaireID, $details["ModuleID"], $details["ModuleTitle"]);
		
		$alerts[] = array(
			"type" => "success",
			"message" => "Sucessfully added question group" 
		);
	}
	catch (Exception $e) {
		$alerts[] = array(
			"type" => "danger",
			"message" => "Sorry, an error occurred adding question group ({$e->getMessage()})" 
		);
	}
}

/**
 * delete question group
 * 
 * @param String $moduleID The moduleID to delete.
 */
function deleteGroup($moduleID) {
	global $questionnaireID, $alerts, $db;
	try {
		$stmt = new tidy_sql($db, "DELETE FROM Questions WHERE QuestionaireID=? AND ModuleID=?", "is");
		$stmt->query($questionnaireID, $moduleID);
		
		$alerts[] = array(
			"type" => "success",
			"message" => "Sucessfully deleted modules questions" 
		);
		
		try {
			$stmt = new tidy_sql($db, "DELETE FROM Modules WHERE QuestionaireID=? AND ModuleID=?", "is");
			$stmt->query($questionnaireID, $moduleID);
			
			$alerts[] = array(
				"type" => "success",
				"message" => "Sucessfully deleted the module" 
			);
		}
		catch (Exception $e) {
			$alerts[] = array(
				"type" => "danger",
				"message" => "Sorry, an error occurred deleting the module ({$e->getMessage()})" 
			);
		}
	}
	catch (Exception $e) {
		$alerts[] = array(
			"type" => "danger",
			"message" => "Sorry, an error occurred deleting the modules questions ({$e->getMessage()})" 
		);
	}
}

/**
 * Lists questiongroups from db
 * 
 * @param int $questionnaireID The questionnaire ID to select modules from.
 */
function getModules($questionnaireID) {
	global $db;
	$stmt = new tidy_sql($db, "
		SELECT ModuleID, ModuleTitle, Fake FROM Modules WHERE QuestionaireID=? AND Fake=?
	", "ii");
	$groups = $stmt->query($questionnaireID, 1);
	$modules = $stmt->query($questionnaireID, 0);
	
	return array(
		$groups,
		$modules 
	);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["action"])) {
	$action = $_POST["action"];
	if ($action == "add_group") {
		insertGroup($_POST);
	}
	if ($action == "table") { // a button within table was clicked
		if (isset($_POST["delete"])) {
			deleteGroup($_POST["delete"]);
		}
	}
}

list($groups, $modules) = getModules($questionnaireID);

echo $template->render(array(
	"url" => $url,
	"questionnaireID" => $questionnaireID,
	"alerts" => $alerts,
	"groups" => $groups,
	"modules" => $modules 
));


