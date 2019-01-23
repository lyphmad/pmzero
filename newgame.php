<?php
// Create connection
$conn = new mysqli("localhost", "pmzero", "", "pmzero");
$conn->set_charset("utf8");

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$gameID = $_GET["gameID"];
$eastID = $_GET["eastID"];
$southID = $_GET["southID"];
$westID = $_GET["westID"];
$northID = $_GET["northID"];

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

if ($_GET['no_ranking'] === "on") {
	$no_ranking = 1;
}
else { $no_ranking = 0; }

$dora = $_GET['dora'];
$etc = $_GET['etc'];

$sql = "INSERT INTO Games SET
	eastID = $eastID, eastScore = $eastScore,
	southID = $southID, southScore = $southScore,
	westID = $westID, westScore = $westScore,
	northID = $northID, northScore = $northScore,
	leftover = $leftover, no_ranking = $no_ranking,
	dora = $dora, etc = '$etc';";

if ($conn->query($sql) === TRUE) {
	echo "<script>
	alert('등록되었습니다.');
	window.location.href='games.php';
	</script>";
} else {
	die("Error: " . $sql . "<br>" . $conn->error);
}

$conn->close();
?> 