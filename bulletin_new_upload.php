<?php
// Create connection
$conn = new mysqli("localhost", "openvpnas", "", "pmzero");
$conn->set_charset("utf8");

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// Get articleID
$sql = "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'pmzero' AND TABLE_NAME = 'Bulletin';";
$entry_no = $conn->query ($sql)->fetch_array ()['AUTO_INCREMENT'];

// Try to upload file
$uploads_dir = 'uploads/' . $entry_no . '/';
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
		die ("용량 초과입니다. 업로드 파일의 최대 크기는 1GB입니다.");
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

$sql = "INSERT INTO Bulletin (title, content) VALUES ('" . $title. "', '" . $content . "');";

if ($conn->query($sql) === TRUE) {
	echo '<script>'
		echo "alert('등록되었습니다.');"
		echo "window.location.href='bulletin.php';"
	echo "</script>"
} else {
	die("Error: " . $sql . "<br>" . $conn->error);
}

$conn->close();
?>

