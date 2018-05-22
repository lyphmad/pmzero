<?php
// Create connection
$conn = new mysqli("localhost", "openvpnas", "", "pmzero");
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

$result = $conn->query("SELECT * FROM Members ORDER BY `name`;");

$members = array();
while ($rowitem = $result->fetch_array()) {
  $members[$rowitem['memberID']] = $rowitem['name'];
}
?>

<!DOCTYPE html>
<html>
	<title>UNIST 마작 소모임 ±0</title>
	<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="w3.css">

	<body>
		<div w3-include-html="menubar.html"></div>

		<div class="w3-main" style="margin-left:200px">
			<div style="background-color: #001c54; color: white" scrolling="NO">
				<button class="w3-button w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
				<div class="w3-container" style="padding-left: 10px;">
					<h1>역만 입력</h1>
				</div>
			</div>
			
			<form method="POST" action="chicken.php" enctype="multipart/form-data">
				<div class="row">
					<div class="w3-container w3-cell">
						<select name="maker">
							<?php
							foreach ($members as $ID => $name) {
								echo '<option value=' . $ID . '>'.$name.'</option>';
							}
							?>
						</select><br>
						<input type="radio" name="ron" value="0" onclick="disable_loser()">쯔모
						<input type="radio" name="ron" value="1" onclick="enable_loser()">론
					</div>
				</div>

				<div class="row" id="loser">
					<div class="w3-container w3-cell">
						<select name="loser">
							<?php
							foreach ($members as $ID => $name) {
								echo '<option value=' . $ID . '>'.$name.'</option>';
							}
							?>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="w3-container w3-cell w3-mobile">
						<input name="type" class="w3-input" type="text" placeholder="화료역" list="type_list" required autocomplete="off">
						<datalist id="type_list">
							<option value="구련보등">
							<option value="순정구련보등">
							<option value="국사무쌍">
							<option value="국사무쌍 13면대기">
							<option value="녹일색">
							<option value="대삼원">
							<option value="대칠성">
							<option value="소사희">
							<option value="대사희">
							<option value="소차륜">
							<option value="대차륜">
							<option value="스깡쯔">
							<option value="스안커">
							<option value="십삼불탑">
							<option value="인화">
							<option value="자일색">
							<option value="지화">
							<option value="천화">
							<option value="청노두">
							<option value="팔연장">
							<option value="헤아림 역만">
						</datalist>
					</div>
				</div>

				<div class="row">
					<div class="w3-container w3-cell">
						<select name="gyoku" autocomplete="off" required>
							<option value="1">동1국</option>
							<option value="2">동2국</option>
							<option value="3">동3국</option>
							<option value="4">동4국</option>
							<option value="5">남1국</option>
							<option value="6">남2국</option>
							<option value="7">남3국</option>
							<option value="8">남4국</option>
							<option value="0">서1국 이후</option>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="w3-container w3-cell" style="padding-right: 50px;"><h3>비고</h3></div>
					<div class="w3-container w3-mobile">
						<input name="remarks" class="w3-border" placeholder="비고 예) 헤아림 역만 상세, 관전자">
					</div>
				</div>

				<div class="row">
					<div class="w3-container w3-cell" style="padding-right: 50px;"><h3>첨부파일</h3></div>
					<div class="w3-container w3-cell w3-mobile">
						<input name="uploads[]" type="file" multiple>
					</div>
				</div>

				<div class="row">
					<div class="w3-container w3-row-padding">
						<input name="bought" class="w3-check" type="checkbox"><label style="padding-left:5px;">정산 완료</label>
					</div>
				</div>

				<div class="row" style="height: 200px;">
					<div class="w3-container w3-row-padding">
						<input id="submit" class="w3-button w3-border" type="submit" value="입력">
					</div>
				</div>
			</form>
		</div>

		<style>
			.w3-container {
				vertical-align: middle;
			}

			.row {
				padding-top: 20px;
				padding-left: 20px;
				padding-right: 20px;
			}
		</style>

		<script src="https://www.w3schools.com/lib/w3.js"></script>
		<script>
			w3.includeHTML();
			function w3_open() {
					document.getElementById("mySidebar").style.display = "block";
			}
			function w3_close() {
					document.getElementById("mySidebar").style.display = "none";
			}

			function disable_loser() {
				document.getElementById("loser").style.display = 'none';
			}
			function enable_loser() {
				document.getElementById("loser").style.display = 'block';
			}

		</script>
	</body>
</html>