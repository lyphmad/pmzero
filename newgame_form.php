<?php
// Create connection
$conn = new mysqli("localhost", "openvpnas", "", "pmzero");
$conn->set_charset("utf8");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get members
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
	<head>
		<script src="math.js" type="text/javascript"></script>
	</head>

	<body>    
		<div w3-include-html="menubar.html"></div>

		<div class="w3-main" style="margin-left:200px">
			<div class="w3-card" style="background-color: #001c54; color: white;">
				<button class="w3-button w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
				<div class="w3-container">
					<h1>기록 입력</h1>
				</div>
			</div>

			<form method="get" action="newgame.php" onsubmit="return validate()">
				<div class="row">
					<div class="w3-container w3-cell wind"><h3>동</h3></div>
					<div class="w3-container w3-cell" style="width:130px;">
					<select name="eastID" style="width:100%;" autocomplete="off">
						<option disabled selected> --- </option>
						<?php
						foreach ($members as $ID => $name) {
							echo '<option value=' . $ID . '>'.$name.'</option>';
						}
						?>
					</select>
					</div>
					<div class="w3-container w3-cell w3-mobile">
						<input id="eastScore" name="eastScore" class="w3-input" type="text" onblur="getTotal()" placeholder="점수" autocomplete="off">
					</div>
				</div>
				<div class="row">
					<div class="w3-container w3-cell wind"><h3>남</h3></div>
					<div class="w3-container w3-cell" style="width:130px;">
					<select name="southID" style="width:100%;" autocomplete="off">
						<option disabled selected> --- </option>
						<?php
						foreach ($members as $ID => $name) {
							echo '<option value=' . $ID . '>' . $name . '</option>';
						}
						?>
					</select>
					</div>
					<div class="w3-container w3-cell w3-mobile">
						<input id="southScore" name="southScore" class="w3-input" type="text" onblur="getTotal()" placeholder="점수" autocomplete="off">
					</div>
				</div>
				<div class="row">
					<div class="w3-container w3-cell wind"><h3>서</h3></div>
					<div class="w3-container w3-cell" style="width:130px;">
					<select name="westID" style="width:100%;" autocomplete="off">
						<option disabled selected> --- </option>
						<?php
						foreach ($members as $ID => $name) {
							echo '<option value=' . $ID . '>'.$name.'</option>';
						}
						?>
					</select>
					</div>
					<div class="w3-container w3-cell w3-mobile">
						<input id="westScore" name="westScore" class="w3-input" type="text" onblur="getTotal()" placeholder="점수" autocomplete="off">
					</div>
				</div>
				<div class="row">
					<div class="w3-container w3-cell wind"><h3>북</h3></div>
					<div class="w3-container w3-cell" style="width:130px;">
					<select name="northID" style="width:100%;" autocomplete="off">
						<option disabled selected> --- </option>
						<?php
						foreach ($members as $ID => $name) {
							echo '<option value=' . $ID . '>'.$name.'</option>';
						}
						?>
					</select>
					</div>
					<div class="w3-container w3-cell w3-mobile">
						<input id="northScore" name="northScore" class="w3-input" type="text" onblur="getTotal()" placeholder="점수" autocomplete="off">
					</div>
				</div>

				<div class="row">
					<div class="w3-container w3-cell" style="padding-right: 155px;"><h3>공탁</h3></div>
					<div class="w3-container w3-cell w3-mobile">
						<input id="leftover" name="leftover" class="w3-input" type="text" onblur="getTotal()" placeholder="0" autocomplete="off">
					</div>
				</div>

				<div class="row">
					<div class="w3-container w3-cell"><h3>적도라 갯수</h3></div>
					<div class="w3-container w3-cell w3-mobile">
						<input type="radio" id="0" name="dora" value="0" /> 0
						<input type="radio" id="4" name="dora" value="4" checked /> 4
						<input type="radio" id="6" name="dora" value="6" /> 6
						<input type="radio" id="8" name="dora" value="8" /> 8
						<input type="radio" id="10" name="dora" value="10" /> 10
					</div>
				</div>

				<div class="row">
					<div class="w3-container w3-cell" style="padding-right: 155px;"><h3>합계</h3></div>
					<div class="w3-container w3-cell w3-mobile">
						<output id="total" type="text" style="width:100%;" value="0">
					</div>
				</div>
				
				<div class="row">
					<div class="w3-container w3-cell" style="padding-right: 155px;">
						<input type="checkbox" name="no_ranking"> 랭킹 계산에서 제외
					</div>
				</div>
				
				<div class="row">
					<div class="w3-container w3-cell" style="padding-right: 155px;"><h3>비고</h3></div>
					<div class="w3-container w3-cell w3-mobile">
						<textarea name="etc" class="w3-mobile" maxlength="10"></textarea>
					</div>					
				</div>
				
				<div class="row">
					<div class="w3-container w3-row-padding">
						<input id="submit" class="w3-button w3-border" type="submit" value="기록 입력" disabled>
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
				var east = math.eval(document.getElementById('eastScore').value);
				var south = math.eval(document.getElementById('southScore').value);
				var west = math.eval(document.getElementById('westScore').value);
				var north = math.eval(document.getElementById('northScore').value);
				var left = math.eval(document.getElementById('leftover').value);

				var tot = 0;

				if (east) {
					tot += east;
					document.getElementById('eastScore').value = east;
				}
				if (south) {
					tot += south;
					document.getElementById('southScore').value = south;
				}
				if (west) {
					tot += west;
					document.getElementById('westScore').value = west;
				}
				if (north) {
					tot += north;
					document.getElementById('northScore').value = north;
				}
				if (left) {
					tot += left;
					document.getElementById('leftover').value = left;
				}

				if (tot == 100000) {
					document.getElementById("submit").disabled = false;
					document.getElementById('total').value = tot;
				}
				else {
					var minus = "(" + (tot - 100000) + ")";
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
				else { return true; }
			}
		</script>
	</body>
</html>
