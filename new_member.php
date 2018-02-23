<?php
$name = $_GET['name'];

// Create connection
$conn = new mysqli("localhost", "ubuntu", "", "pmzero");
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO Players (name) VALUES ('$name');";

if ($conn->query($sql) === TRUE) {
	echo "<script>
	alert('등록되었습니다.');
	window.location.href='record.html';
	</script>";
} else {
	die("Error: " . $sql . "<br>" . $conn->error);
}

$conn->close();
?>