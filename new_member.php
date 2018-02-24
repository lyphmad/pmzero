<!DOCTYPE html>
<?php
$name = $_GET['name'];

// Create connection
$conn = new mysqli("localhost", "ubuntu", "", "pmzero");
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO Members (name) VALUES ('$name');";

if ($conn->query($sql) === TRUE) {
	echo "<script>
	alert('등록되었습니다.');
	window.location.href='record.html';
	</script>";
} else {
	echo "<script>
	alert('등록에 실패하였습니다. 이미 등록된 이름이 아닌지 다시 확인해 주세요.');
	window.location.href='new_member.html';
	</script>";
}

$conn->close();
?>