<?php
$articleID = $_GET['id'];

// Create connection
$conn = new mysqli("localhost", "openvpnas", "", "pmzero");
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE Bulletin SET valid = false WHERE articleID = $articleID;";

if ($conn->query($sql) === TRUE) {
	echo "<script>
	alert('삭제되었습니다.');
	window.location.href='bulletin.php';
	</script>";
} else {
	die("Error: " . $sql . "<br>" . $conn->error);
}

$conn->close();
?>