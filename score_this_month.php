<!DOCTYPE html>
<html>
	<title>UNIST 마작 소모임 ±0</title>
	<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="w3.css">

	<body>    
		<div w3-include-html="menubar.html"></div>

		<div class="w3-main" style="margin-left:200px">
			<div style="background-color: #001c54; color: white">
				<button class="w3-button w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
				<div class="w3-container">
					<h1>이번 달 기록</h1>
				</div>
			</div>

			<div class="w3-col w3-container">
				<p style="color:red;"><b>변경사항을 적용하는 데 시간이 조금 걸릴 수 있으니 잠시 기다린 후 새로고침 해주세요!</b></p>
			</div>

			<?php
			$conn = new mysqli("localhost", "ubuntu", "", "pmzero");
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error());
			}

			$conn->set_charset("utf8");

			$results = $conn->query(
				"SELECT * FROM Games
				WHERE MONTH(gameTime) = MONTH(NOW())
				AND YEAR(gameTime) = YEAR(NOW())
				AND valid = 1
				ORDER BY gameTime DESC;"
			);
			?>

			<div class="w3-container" style="overflow-x:auto;">
				<table class="w3-table-all">
					<tr style="background-color: #43c1c3; color: white;">
						<th nowrap>일시</th>
						<th nowrap>1위</th>
						<th nowrap>2위</th>
						<th nowrap>3위</th>
						<th nowrap>4위</th>
						<th nowrap>공탁</th>
						<th nowrap></th>
						<th nowrap></th>
						<th nowrap></th>
					</tr>

				<?php 
				while ($rowitem = $results->fetch_array()) {
				?>
					<tr>
						<td nowrap> <?=$rowitem['gameTime']?> </td>
						<td nowrap> [<?=$rowitem['1stWind']?>] <?=$rowitem['1stName']?>: <?=$rowitem['1stScore']?> </td>
						<td nowrap> [<?=$rowitem['2ndWind']?>] <?=$rowitem['2ndName']?>: <?=$rowitem['2ndScore']?> </td>
						<td nowrap> [<?=$rowitem['3rdWind']?>] <?=$rowitem['3rdName']?>: <?=$rowitem['3rdScore']?> </td>
						<td nowrap> [<?=$rowitem['4thWind']?>] <?=$rowitem['4thName']?>: <?=$rowitem['4thScore']?> </td>
						<td nowrap> <?=$rowitem['leftover']?> </td>
						<td nowrap style='color:blue;'> <ins> <a href='edit_form.php?id=<?=$rowitem['gameID']?>'>수정</a> </ins> </td>
						<td nowrap style='color:blue;'> <ins> <a href='#' onclick="delete_button(<?=$rowitem['gameID']?>)">삭제</a> </ins> </td>
						<td nowrap style='color:blue;'> <ins> <a href='chicken_form.php?id=<?=$rowitem['gameID']?>'>역만</a> </ins> </td>
					</tr>
				<?php 
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
			function delete_button(gameID) {
				if (confirm("삭제된 기록은 복구할 수 없습니다.\n정말 삭제하시겠습니까?")) {
					window.location.href='delete.php?id=' + gameID;
				}
			}
		</script>
	</body>
</html>
