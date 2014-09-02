<?
require "../../../lib.php";
require_once "{$root}/lib/Twig/Autoloader.php";

Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem("{$root}/admin/tpl/");
$twig = new Twig_Environment($loader, array());

$template = $twig->loadTemplate('questionaire/publish/students.html');

$questionaireID = $_GET["questionaireID"];
$alerts = array();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$data = parseStudentsCSV($_POST["csvdata"]);
	insertStudents($data, $questionaireID);
	$alerts[] = array("type"=>"success", "message"=>"Students inserted");
}

$stmt = new tidy_sql($db, "
	SELECT Students.UserID, Students.Department, Students.Token, GROUP_CONCAT(DISTINCT ModuleID ORDER BY ModuleID ASC SEPARATOR ' ') AS Modules, Students.Done
	FROM Students
	JOIN StudentsToModules ON StudentsToModules.UserID=Students.UserID AND StudentsToModules.QuestionaireID=Students.QuestionaireID 
	WHERE Students.QuestionaireID=?
	GROUP BY Students.UserID
	ORDER BY Students.Done DESC
", "i");

$rows = $stmt->query($questionaireID);
echo $template->render(array("url"=>$url, "students"=>$rows, "questionaireID"=> $questionaireID, "alerts"=>$alerts));
