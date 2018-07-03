<!DOCTYPE html>
<html>
<title>UNIST 마작 소모임 ±0</title>
<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">

<body>
  <div w3-include-html="menubar.html"></div>

	<div class="w3-main" style="margin-left:200px">
		<div class="w3-card" style="background-color: #001c54; color: white" scrolling="NO">
			<button class="w3-button w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
			<div class="w3-container">
				<h1>게시판</h1>
			</div>
		</div>

		<div style="width:fit-content; overflow-x:auto;">
			<table class="w3-table-all">
				<tr style="background-color: #43c1c3; color: white;">
					<th nowrap></th>
					<th nowrap>작성 일시</th>
					<th nowrap style="border-left: 1px solid black; margin-right: 5px;">
					<th nowrap>제목</th>
					<th nowrap style="border-left: 1px solid black; margin-right: 5px;">
					<th nowrap></th>
					<th nowrap></th>
				</tr>

				<?php
				// Create connection
				$conn = new mysqli("localhost", "openvpnas", "", "pmzero");
				// Check connection
				if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
				}
				$conn->set_charset("utf8");

				$articles = $conn->query("SELECT articleID, title, uploadTime FROM Bulletin WHERE valid = true ORDER BY articleID DESC;");
				while ($rowitem = $articles->fetch_array()) {
					echo '<tr>';
					echo '<td nowrap>' . $rowitem['articleID'] . '</td>';
					echo '<td nowrap>' . $rowitem['uploadTime'] . '</td>';
					echo '<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>';
					echo '<td nowrap><a href="bulletin_show.php?id=' . $rowitem['articleID'] . '">' . $rowitem['title'] . '</td>';
					echo '<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>';
					echo '<td nowrap><a href="bulletin_edit_form.php?id=' . $rowitem['articleID'] . '">수정</a></td>';
					echo '<td nowrap style="color: red" onclick="delete_article(' . $rowitem['articleID'] . ')"><a href="#">삭제</a></td>';
					echo '</tr>';
				}
				$conn->close();
				?>
			</table>
		</div>
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
		
		function delete_article (articleID) {
			if (confirm (articleID + "번 게시물을 삭제합니다.\n계속하시겠습니까?")) {
				window.location.href = 'bulletin_delete_article.php?id=' + articleID;
			}
		}
	</script>
	</body>
</html>