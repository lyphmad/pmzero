<?php
// Create connection
$conn = new mysqli("localhost", "openvpnas", "", "pmzero");
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");

$articleID = $_GET['id'];

$sql = "SELECT title, content FROM Bulletin WHERE articleID = $articleID";
$article = $conn->query ($sql)->fetch_array ();
?>

<!DOCTYPE html>
<html>
	<title>UNIST 마작 소모임 ±0</title>
	<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="w3.css">

	<body onload="loadValue()">
		<div w3-include-html="menubar.html"></div>

		<div class="w3-main" style="margin-left:200px">
			<div class="w3-card" style="background-color: #001c54; color: white" scrolling="NO">
				<button class="w3-button w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
				<div class="w3-container" style="padding-left: 10px;">
					<h1>글 쓰기</h1>
				</div>
			</div>
			
			<form id="uploadForm" method="POST" action="bulletin_edit_upload.php" enctype="multipart/form-data">
				<input name="articleID" value=<?=$articleID?> hidden>
				<div class="w3-container" style="margin-top: 10px;">
					<h3>제목</h3>
					<input name="title" style="width: 500px;" class="w3-input w3-mobile" type="text" autocomplete="off" value="<?=$article['title']?>" required>

					<h3 style="margin-top: 50px">사진 업로드</h3>
					선택하지 않으면 변경하지 않습니다.<br>
					<input type="file" name="uploadFile" id="uploadFile" style="margin-top: 10px">
					<input type="checkbox" name="deleteFile"> 사진 삭제하기 </br>

					<div style="margin-top: 50px">
						화료 기록 시 적을 만한 것들: 화료자, 론 화료면 방총자, 역 이름, 시점(동1국, etc.), (역만이면) 그래서 치킨은 사셨는지?
						HTML 문법 일단 안 막았습니다. Youtube embed 같은 거 다 됩니다.
					</div>
					<div><textarea id="content" name="content" cols="100" rows="5" class="w3-mobile" form="uploadForm"></textarea></div>
					<input type="submit" value="수정" name="submit">
				</div>
			</form>
		</div>

		<script src="https://www.w3schools.com/lib/w3.js"></script>
		<script>
			w3.includeHTML();

			function w3_open() {
					document.getElementById("mySidebar").style.display = "block";
			}

			function w3_close() {
					document.getElementById("mySidebar").style.display = "none";
			}

			function loadValue() {
				document.getElementById("content").value = "<?=$article['content']?>";
			}
		</script>
	</body>
</html>