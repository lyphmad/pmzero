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

			<?php
			$conn = new mysqli("localhost", "openvpnas", "", "pmzero");
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error());
			}

			$conn->set_charset("utf8");

			$results = $conn->query(
				"SELECT * FROM Chicken WHERE valid = 1 ORDER BY chickenTime DESC;"
			);
			?>

			<div style="overflow-x:auto;">
				<table class="w3-table-all">
					<tr style="background-color: #43c1c3; color: white;">
						<th nowrap>일시</th>
						<th nowrap>화료자</th>
						<th nowrap>화료역</th>
						<th nowrap>화료국</th>
						<th nowrap>방총자</th>
						<th nowrap></th>
						<th nowrap></th>
						<th nowrap></th>
					</tr>

				<?php 
				while ($rowitem = $results->fetch_array()) {

					if ($rowitem['bought'] == 1) {
						echo "<tr>";
					}
					else {
						echo "<tr style='color:red;'>";
					}
					?>
						<td nowrap> <?=$rowitem['chickenTime']?> </td>
						<td nowrap> <?=$rowitem['maker']?> </td>
						<td nowrap> <?=$rowitem['type']?> </td>
						<?php
						if ($rowitem['gyoku'] == 1) {
							echo "<td nowrap>동1국</td>";
						}
						else if ($rowitem['gyoku'] == 2) {
							echo "<td nowrap>동2국</td>";
						}
						else if ($rowitem['gyoku'] == 3) {
							echo "<td nowrap>동3국</td>";
						}
						else if ($rowitem['gyoku'] == 4) {
							echo "<td nowrap>동4국</td>";
						}
						else if ($rowitem['gyoku'] == 5) {
							echo "<td nowrap>남1국</td>";
						}
						else if ($rowitem['gyoku'] == 6) {
							echo "<td nowrap>남2국</td>";
						}
						else if ($rowitem['gyoku'] == 7) {
							echo "<td nowrap>남3국</td>";
						}
						else if ($rowitem['gyoku'] == 8) {
							echo "<td nowrap>남4국</td>";
						}
						else if ($rowitem['gyoku'] == 0) {
							echo "<td nowrap>서1국 이후</td>";
						}

						if ($rowitem['ron'] == 1) {
							echo "<td nowrap>".$rowitem['loser']."</td>";
						}
						else {							
							echo "<td nowrap>쯔모</td>";
						}
						?>
						<td nowrap style='color:blue;'> <ins> <a href="chicken_edit_form?id=<?=$rowitem['chickenID']?>">수정</a> </ins> </td>
						<td nowrap style='color:blue;'> <ins> <a href='#' onclick="delete_button(<?=$rowitem['chickenID']?>)">삭제</a> </ins> </td>
						<td nowrap style='color:blue;'> <ins> <a href='#' onclick="chicken_detail?id=<?=$rowitem['chickenID']?>">상세</a> </ins> </td>
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
			function delete_button(id) {
				if (confirm("삭제된 기록은 복구할 수 없습니다.\n정말 삭제하시겠습니까?")) {
					window.location.href='delete_chicken.php?id=' + id;
				}
			}
		</script>
	</body>
</html>
