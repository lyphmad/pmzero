<?php
$dir_name = date(YmdHis);
$target_dir = 'uploads/'.$dir_name.'/';
mkdir($target_dir);

if($_FILES["uploads"]["error"] != 4) { // if file is uploaded
	$fileCount = count($_FILES["uploads"]["name"]);
	for ($i=0; $i < $fileCount; $i++) {
		$target_file = $target_dir . basename($_FILES["uploads"]["name"][$i]);

		if(!move_uploaded_file($_FILES["uploads"]["tmp_name"][$i], $target_file)) {
			exit("File not uploaded.");
		}
	}
}


// Create connection
$conn = new mysqli("localhost", "openvpnas", "", "pmzero");
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

$maker = $_POST['maker'];
$type = $_POST['type'];
$gyoku = $_POST['gyoku'];
$ron = $_POST['ron'];
$loser = $_POST['loser'];
$remarks = $_POST['remarks'];

if ($_POST['bought'] === "on") {
	$bought = 1;
}
else {
	$bought = 0;
}

if ($ron == 1) {
	$query = "INSERT INTO Chicken SET
	maker = '$maker', `type` = '$type',
	gyoku = $gyoku, ron = 1, loser = '$loser',
	remarks = '$remarks', attach_dir = '$dir_name', bought = $bought;";
}
else {
	$query = "INSERT INTO Chicken SET
	maker = '$maker', `type` = '$type',
	gyoku = $gyoku, ron = 0,
	remarks = '$remarks', attach_dir = '$dir_name', bought = $bought;";
}

if ($conn->query($query) === TRUE) { ?>
	<script>
		alert('등록되었습니다.');
		window.location.href='chicken_list.php';
	</script>
	<?php
} else {
	die("Error: " . $sql . "<br>" . $conn->error);
}

$conn->close();
?>

