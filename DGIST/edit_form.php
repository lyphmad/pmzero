<?php
$gameID = $_GET["id"];
// Create connection
$conn = new mysqli("localhost", "openvpnas", "", "DGIST");
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

$results = $conn->query("SELECT * FROM Games WHERE gameID = $gameID;");
$rowitem = $results->fetch_array();
$conn->close();
?>

<!DOCTYPE html>
<html>
	<title>UNIST 마작 소모임 ±0</title>
	<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="w3.css">

	<body onload="getTotal()">    
		<div w3-include-html="menubar.html"></div>

		<div class="w3-main" style="margin-left:200px">
			<div class="w3-card" style="background-color: #001c54; color: white;">
				<button class="w3-button w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
				<div class="w3-container" style="margin-left:10px;">
					<h1>기록 수정</h1>
				</div>
			</div>

			<form method="get" action="edit.php" onsubmit="return validate()">
				<input name="gameID" type="text" value="<?=$gameID?>" hidden>
				
				<div class="row">
					<div class="w3-container w3-cell wind"><h3>동</h3></div>
					<div class="w3-container w3-cell" style="width:130px;">
						<select id="eastID" name="eastID" style="width:100%;" autocomplete="off" required>
							<option disabled>이름</option>
							<?php
							foreach ($members as $id => $name) {
								if ($id == $rowitem['eastID']) {
									echo '<option value="'.$id.'" selected>'.$name.'</option>';
								}
								else {
									echo '<option value="'.$id.'">'.$name.'</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="w3-container w3-cell w3-mobile">
						<input id="eastScore" name="eastScore" class="w3-input" type="text" onblur="getTotal()" value="<?=$rowitem['eastScore']?>" autocomplete="off">
					</div>
				</div>
				
				<div class="row">
					<div class="w3-container w3-cell wind"><h3>남</h3></div>
					<div class="w3-container w3-cell" style="width:130px;">
						<select id="southID" name="southID" style="width:100%;" autocomplete="off" required>
							<?php
							foreach ($members as $id => $name) {
								if ($id == $rowitem['southID']) {
									echo '<option value="'.$id.'" selected>'.$name.'</option>';
								}
								else {
									echo '<option value="'.$id.'">'.$name.'</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="w3-container w3-cell w3-mobile">
						<input id="southScore" name="southScore" class="w3-input" type="text" onblur="getTotal()" value="<?=$rowitem['southScore']?>" autocomplete="off">
					</div>
				</div>
				
				<div class="row">
					<div class="w3-container w3-cell wind"><h3>서</h3></div>
					<div class="w3-container w3-cell" style="width:130px;">
						<select id="westID" name="westID" style="width:100%;" autocomplete="off" required>
							<?php
							foreach ($members as $id => $name) {
								if ($id == $rowitem['westID']) {
									echo '<option value="'.$id.'" selected>'.$name.'</option>';
								}
								else {
									echo '<option value="'.$id.'">'.$name.'</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="w3-container w3-cell w3-mobile">
						<input id="westScore" name="westScore" class="w3-input" type="text" onblur="getTotal()" value="<?=$rowitem['westScore']?>" autocomplete="off">
					</div>
				</div>
				
				<div class="row">
					<div class="w3-container w3-cell wind"><h3>북</h3></div>
					<div class="w3-container w3-cell" style="width:130px;">
						<select id="northID" name="northID" style="width:100%;" autocomplete="off" required>
							<?php
							foreach ($members as $id => $name) {
								if ($id == $rowitem['northID']) {
									echo '<option value="'.$id.'" selected>'.$name.'</option>';
								}
								else {
									echo '<option value="'.$id.'">'.$name.'</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="w3-container w3-cell w3-mobile">
						<input id="northScore" name="northScore" class="w3-input" type="text" onblur="getTotal()" value="<?=$rowitem['northScore']?>" autocomplete="off">
					</div>
				</div>

				<div class="row">
					<div class="w3-container w3-cell" style="padding-right: 155px;"><h3>공탁</h3></div>
					<div class="w3-container w3-cell w3-mobile">
						<input id="leftover" name="leftover" class="w3-input" type="text" onblur="getTotal()" value="<?=$rowitem['leftover']?>" autocomplete="off">
					</div>
				</div>

				<div class="row">
					<div class="w3-container w3-cell" style="padding-right: 155px;"><h3>합계</h3></div>
					<div class="w3-container w3-cell w3-mobile">
						<output id="total" type="text" style="width:100%;" value="0">
					</div>
				</div>
				
				<div class="row" style="height: 200px;">
					<div class="w3-container w3-row-padding">
						<input id="submit" class="w3-button w3-border" type="submit" value="기록 입력">
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

		.wind {
			padding-right: 50px;
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

		function getTotal() {
			var east = parseInt(document.getElementById('eastScore').value);
			var south = parseInt(document.getElementById('southScore').value);
			var west = parseInt(document.getElementById('westScore').value);
			var north = parseInt(document.getElementById('northScore').value);
			var left = parseInt(document.getElementById('leftover').value);

			var tot = 0;
			if (east) { tot += east; }
			if (south) { tot += south; }
			if (west) { tot += west; }
			if (north) { tot += north; }
			if (left) { tot += left; }
			document.getElementById('total').value = tot;

			if (tot == 100000) {
				document.getElementById("submit").disabled = false;
				document.getElementById('total').value = tot;
			}
			else {
				var diff = tot - 100000;
				if (diff > 0) {
					diff = "+" + diff;
				}
				var minus = "(" + diff + ")";
				var str = tot + " " + minus.fontcolor ("red");
				document.getElementById('total').innerHTML = str;
				document.getElementById("submit").disabled = true;
			}

			return tot;
		}

		function validate() {
			if (getTotal() != 100000) {
				alert("점수 합계를 확인하세요");
				return false;
			}
		}
		</script>
	</body>
</html>