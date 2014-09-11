<?
/**
 * @file
 * @version 1.0
 * @date 07/09/2014
 * @author Keiron-Teilo O'Shea <keo7@aber.ac.uk>
 *
 */

require_once ("lib.php");
require_once ("questions-funcs.php");
$token = $_GET["token"];
$is_welsh = isset($_GET["welsh"]);

?>

<!DOCTYPE HTML>
<html>
<head>
<title>Questionnaire | Aberystwyth University</title>
<link rel="icon" type="image/png" href="../../assets/favicon.png">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="../img/favicon.png">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/prettyCheckable.css" rel="stylesheet">
<link href="css/qcss.css" rel="stylesheet">
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/prettyCheckable.min.js" type="text/javascript"></script>
<link href='http://fonts.googleapis.com/css?family=Lato:300,400,900'
	rel='stylesheet' type='text/css'>

<script type="text/javascript">
		$(function() {
			$(".ratetable input[type=radio]").each(function(e) {
				$(this).prettyCheckable({
					"customClass": "prettyrate",
					"labelPosition": "left"
				});
			});
		})
	</script>

<style>
textarea {
	resize: vertical;
}
</style>
</head>


<body>


	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target=".navbar-collapse">
					<span class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"> <img src="./img/logo.png">
				</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
<?  if ($is_welsh): ?>
				<li><a href="questions.php?token=<?=$token?>">Saesneg</a></li>
					<li><a href="questions.php?token=<?=$token?>&welsh">Cymraeg</a></li>
<?	else: ?>
				<li><a href="questions.php?token=<?=$token?>">English</a></li>
					<li><a href="questions.php?token=<?=$token?>&welsh">Welsh</a></li>
<?  endif; ?>
			</ul>
			</div>
		</div>
	</div>

	<div class="questionnaire">
		<div class="container">

<? if ($is_welsh): ?>
	<p>Mae'r arolwg hon wedi ei anelu atoch chi.</p>
			<p>Unwaith i chi wasgu 'Cyflwyno', bydd eich atebion yn dychwelyd
				atom yn gyfrinachol a bydd eich cysylltiad unigryw yn dod i ben.</p>
			<p></p>
			Mae'r canlyniadau yn hollol ddienw felly byddwch yn gwbl onest!
			</p>
<? else: ?>
	<p>This is a survey that's aimed at you.</p>
			<p>Once you press submit, your answers come back to us with no
				identifying information, and your unique link will stop working.</p>
			<p>The results are completely anonymous, so be as honest as you can!</p>
<? endif; ?>




<?

function print_question($question, $warn = false) {
	global $is_welsh;
	echo "<hr> <div";
	if ($warn == true && !answer_filled($question)) {
		echo " style=\"border: 5px solid red;\"";
	}
	echo ">";
	
	if ($is_welsh) {
		echo "<h4>{$question["QuestionText_welsh"]}</h4>";
	}
	else {
		echo "<h4>{$question["QuestionText"]}</h4>";
	}
	
	if ($question["Type"] == "rate") {
		echo "
		<table class=\"ratetable\">
			<thead>
				<th></th>
				<th><label for=\"{$question["Identifier"]}_1\">1</label></th>
				<th><label for=\"{$question["Identifier"]}_2\">2</label></th>
				<th><label for=\"{$question["Identifier"]}_3\">3</label></th>
				<th><label for=\"{$question["Identifier"]}_4\">4</label></th>
				<th><label for=\"{$question["Identifier"]}_5\">5</label></t1h>
				<th></th>
			</thead>
			<tr>";
		
		if ($is_welsh) {
			echo "
				<td>Anghytuno'n Gryf</td>
				<td><input type=\"radio\" name=\"{$question["Identifier"]}\" id=\"{$question["Identifier"]}_1\" value=\"1\" " . ($question["Answer"] == 1 ? "checked=\"true\"" : "") . "></td>
				<td><input type=\"radio\" name=\"{$question["Identifier"]}\" id=\"{$question["Identifier"]}_2\" value=\"2\" " . ($question["Answer"] == 2 ? "checked=\"true\"" : "") . "></td>
				<td><input type=\"radio\" name=\"{$question["Identifier"]}\" id=\"{$question["Identifier"]}_3\" value=\"3\" " . ($question["Answer"] == 3 ? "checked=\"true\"" : "") . "></td>
				<td><input type=\"radio\" name=\"{$question["Identifier"]}\" id=\"{$question["Identifier"]}_4\" value=\"4\" " . ($question["Answer"] == 4 ? "checked=\"true\"" : "") . "></td>
				<td><input type=\"radio\" name=\"{$question["Identifier"]}\" id=\"{$question["Identifier"]}_5\" value=\"5\" " . ($question["Answer"] == 5 ? "checked=\"true\"" : "") . "></td>
				<td>Cytuno'n Gryf</td>

				";
		}
		
		else {
			echo "
				<td>Strongly Disagree</td>
				<td><input type=\"radio\" name=\"{$question["Identifier"]}\" id=\"{$question["Identifier"]}_1\" value=\"1\" " . ($question["Answer"] == 1 ? "checked=\"true\"" : "") . "></td>
				<td><input type=\"radio\" name=\"{$question["Identifier"]}\" id=\"{$question["Identifier"]}_2\" value=\"2\" " . ($question["Answer"] == 2 ? "checked=\"true\"" : "") . "></td>
				<td><input type=\"radio\" name=\"{$question["Identifier"]}\" id=\"{$question["Identifier"]}_3\" value=\"3\" " . ($question["Answer"] == 3 ? "checked=\"true\"" : "") . "></td>
				<td><input type=\"radio\" name=\"{$question["Identifier"]}\" id=\"{$question["Identifier"]}_4\" value=\"4\" " . ($question["Answer"] == 4 ? "checked=\"true\"" : "") . "></td>
				<td><input type=\"radio\" name=\"{$question["Identifier"]}\" id=\"{$question["Identifier"]}_5\" value=\"5\" " . ($question["Answer"] == 5 ? "checked=\"true\"" : "") . "></td>
				<td>Strongly Agree</td>";
		}
		echo "</tr>
		</table>
		";
	}
	elseif ($question["Type"] == "text") {
		echo "<textarea name=\"{$question["Identifier"]}\" rows=\"5\" class=\"form-control\" placeholder=\"(Optional)\" >{$question["Answer"]}</textarea>

		";
	}
	echo "</div>";
}

function print_form($modules, $warn = false) {
	echo "<form method=\"POST\">";
	foreach ($modules as $module) {
		echo "<h3>{$module["ModuleID"]}: {$module["ModuleTitle"]}</h3>";
		foreach ($module["Questions"] as $question) {
			print_question($question, $warn);
		}
	}
	global $is_welsh;
	
	if ($is_welsh) {
		echo "<br><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-lg btn-success\" id=\"submit\"\">Cyflwyno'r arolwg</button></div>";
	}
	
	else {
		echo "<br><div class=\"pull-right\"><button type=\"submit\" class=\"btn btn-lg btn-success\" id=\"submit\"\">Submit Survey</button></div>";
	
	}
}

$details = getStudentDetails($token);

if ($details["Done"]) {
	?>
	<h1>You have already done this questionnaire.</h1>
<?
}
else {
	$user = $details["UserID"];
	$modules = getPreparedQuestions($details, $_POST);
	
	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
		print_form($modules);
	}
	elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// validate that everything is filled in
		if (!answers_filled($modules)) { // form is not filled :(
			print_form($modules, true);
			return;
		}
		else {
			answers_submit($details, $modules);
			
			$stmt = new tidy_sql($db, "UPDATE Students SET Done=1 WHERE UserID=? AND QuestionaireID=?", "si");
			$stmt->query($details["UserID"], $details["QuestionaireID"]);
			?>
			<h1>Thank you for completing this questionnaire!</h1>
			<?
		}
	
	}
}

?>
</div>
		<br> <br>

		<div id="addedfooter">
			<div class="container">
				<a href="http://www.aberawesome.co.uk"><p>&copy; The AWESOME Project
						2014</p></a>
			</div>
		</div>

	</div>

	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="../js/bootstrap.js"></script>
</body>

</html>
