<?php
// Create connection
$conn = new mysqli("localhost", "ubuntu", "", "pmzero");
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

$eastName = $_GET["eastName"];
$eastScore = $_GET["eastScore"];
$southName = $_GET["southName"];
$southScore = $_GET["southScore"];
$westName = $_GET["westName"];
$westScore = $_GET["westScore"];
$northName = $_GET["northName"];
$northScore = $_GET["northScore"];
$leftover = $_GET["leftover"];

$sql = "INSERT INTO Cache SET
	eastName = '$eastName', eastScore = $eastScore,
	southName = '$southName', southScore = $southScore,
	westName = '$westName', westScore = $westScore,
	northName = '$northName', northScore = $northScore, leftover = $leftover;";

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