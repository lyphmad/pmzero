<?php
$chickenID = $_GET['id'];

// Create connection
$conn = new mysqli("localhost", "openvpnas", "", "pmzero");
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE Chicken SET valid = 0 WHERE chickenID = $chickenID;";

if ($conn->query($sql) === TRUE) {
	echo "<script>
	alert('삭제되었습니다.');
	window.location.href='chicken_list.php';
	</script>";
} else {
	die("Error: " . $sql . "<br>" . $conn->error);
}

$conn->close();
?>