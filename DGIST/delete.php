<?php
$gameID = $_GET['id'];

// Create connection
$conn = new mysqli("localhost", "openvpnas", "", "DGIST");
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE Games SET valid = 0 WHERE gameID = $gameID;";

if ($conn->query($sql) === TRUE) {
	echo "<script>
	alert('삭제되었습니다.');
	window.location.href='games.php';
	</script>";
} else {
	die("Error: " . $sql . "<br>" . $conn->error);
}

$conn->close();
?>