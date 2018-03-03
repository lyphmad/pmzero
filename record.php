<?php
// Create connection
$conn = new mysqli("localhost", "ubuntu", "", "pmzero");
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

$gameID = $_GET["gameID"];
$eastName = $_GET["eastName"];
$southName = $_GET["southName"];
$westName = $_GET["westName"];
$northName = $_GET["northName"];

if (empty($_GET["eastScore"])) {
	$eastScore = 0;
}
else {
	$eastScore = $_GET["eastScore"];
}
if (empty($_GET["southScore"])) {
	$southScore = 0;
}
else {
	$southScore = $_GET["southScore"];
}
if (empty($_GET["westScore"])) {
	$westScore = 0;
}
else {
	$westScore = $_GET["westScore"];
}
if (empty($_GET["northScore"])) {
	$northScore = 0;
}
else {
	$northScore = $_GET["northScore"];
}
if (empty($_GET["leftover"])) {
	$leftover = 0;
}
else {
	$leftover = $_GET["leftover"];
}

$sql = "INSERT INTO Cache SET
	eastName = '$eastName', eastScore = $eastScore,
	southName = '$southName', southScore = $southScore,
	westName = '$westName', westScore = $westScore,
	northName = '$northName', northScore = $northScore,
	leftover = $leftover, new = 1, edited = 0, deleted = 0";

if ($conn->query($sql) === TRUE) {
	echo "<script>
	alert('등록되었습니다.');
	window.location.href='score_this_month.php';
	</script>";
} else {
	die("Error: " . $sql . "<br>" . $conn->error);
}

$conn->close();
?> 