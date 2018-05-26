<?php
// Create connection
$conn = new mysqli("localhost", "openvpnas", "", "pmzero");
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");

$articleID = $_POST['articleID'];

$uploads_dir = 'uploads/' . $articleID . '/';
mkdir ($uploads_dir);
$target_file = $uploads_dir . basename($_FILES["uploadFile"]["name"]);
$error_no = $_FILES['uploadFile']['error'];
if ($error_no == 0) {
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
		die ("JPG, JPEG, PNG, GIF 파일만 업로드 가능합니다. 동영상은 youtube embed를 이용하세요. 다른 확장자는 관리자에게 요청하세요.");
	}
	elseif (!move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_file)) {
		die ("파일 업로드에 실패했습니다. 관리자에게 알려주세요.");
	}
}
elseif ($error_no == 1 || $error_no == 2) {
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
		die ("JPG, JPEG, PNG, GIF 파일만 업로드 가능합니다. 동영상은 youtube embed를 이용하세요. 다른 확장자는 관리자에게 요청하세요.");
	}
	else {
		die ("(에이 설마 사진 한 장이 1기가를 넘겠어?)");
		//1기가를 넘는 게 필요하다고? /etc/php/7.0/apache2/php.ini에서 upload_max_filesize 수정해
	}
}
elseif ($error_no == 3) {
	die ("전송에 실패하였습니다. 잠시 후 다시 시도해 주세요.");
}
elseif ($error_no == 6 || $error_no == 7 || $error_no == 8) {
	die ("서버 기기에 오류가 발생했습니다. 잠시 후 다시 시도해 주세요. 계속된다면, 관리자에게 알려주세요.");
}

$title = $_POST['title'];
$content = $_POST['content'];

//die (print_r ($_POST, TRUE));

if ($_POST['deleteFile'] == "on") {
	$files = array_diff (scandir ($uploads_dir), array('.','..')); 
	foreach ($files as $file) { 
		unlink("$uploads_dir/$file"); 
	} 
	rmdir($uploads_dir); 
}

$sql = "UPDATE Bulletin SET title = '$title', content = '$content' WHERE articleID = $articleID;";

if ($conn->query($sql) === TRUE) { ?>
	<script>
		alert('등록되었습니다.');
		window.location.href='bulletin.php';
	</script>
	<?php
} else {
	die("Error: " . $sql . "<br>" . $conn->error);
}

$conn->close();
?>

