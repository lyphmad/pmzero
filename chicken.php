<?php
$gameID = $_POST['id'];
$target_dir = "photo/";

if( $_FILES['photo']['error'] == 0 ) {
	$fileCount = count($_FILES["photo"]["name"]);

	for ($i=0; $i < $fileCount; $i++) {        
		$ext = pathinfo($_FILES["photo"]["name"][$i], PATHINFO_EXTENSION);
		$target_file = $target_dir . "chicken" . sprintf("%04d", $gameID) . sprintf("-%04d.", $i) . $ext;
		echo $_FILES["photo"]["tmp_name"][$i]."\n";

		if($check === false) {
			exit("File is not an image.");
		} 
		else {
			if(move_uploaded_file($_FILES["photo"]["tmp_name"][$i], $target_file)) {
				echo "<script>
				alert('등록되었습니다.');    
				window.location.href='score_this_month.php';
				</script>";
			}
			else {
				exit("File not uploaded.");
			}
		}
	}
}

// Create connection
$conn = new mysqli("localhost", "ubuntu", "", "pmzero");
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
	gameID = $gameID, maker = '$maker', `type` = '$type',
	gyoku = $gyoku, ron = 1, loser = '$loser',
	remarks = '$remarks', bought = $bought;";
}
else {
	$query = "INSERT INTO Chicken SET
	gameID = $gameID, maker = '$maker', `type` = '$type',
	gyoku = $gyoku, ron = 0,
	remarks = '$remarks', bought = $bought;";
}

if ($conn->query($query) === TRUE) {
	echo "<script>
	alert('등록되었습니다.');    
	window.location.href='score_this_month.php';
	</script>";
} else {
	die("Error: " . $sql . "<br>" . $conn->error);
}

$conn->close();
?>
