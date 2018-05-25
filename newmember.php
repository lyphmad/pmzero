<?php
// Create connection
$conn = new mysqli("localhost", "openvpnas", "", "pmzero");
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

$newName = $_GET["newName"];

$sql = "INSERT INTO Members (`name`) VALUES ('" . $newName . "');";

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