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
					<h1>기록 수정</h1>
				</div>
			</div>

			<?php
			$gameID = $_GET["id"];

			/*
			// Create connection
			$conn = new mysqli("localhost", "ubuntu", "", "pmzero");
			// Check connection
			if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
			}

			$conn->set_charset("utf8");

			$result = $conn->query("SELECT * FROM Members ORDER BY `name`;");
			$names = array();
			while ($rowitem = $result->fetch_array()) {
				array_push($names, $rowitem['name']);
			}
			$conn->close();*/

			// Create connection
			$conn = new mysqli("localhost", "ubuntu", "", "pmzero");
			// Check connection
			if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
			}

			$conn->set_charset("utf8");

			$result = $conn->query("SELECT * FROM Members ORDER BY `name`;");
			$names = array();
			while ($rowitem = $result->fetch_array()) {
				array_push($names, $rowitem['name']);
			}

			$results = $conn->query("SELECT * FROM Cache WHERE gameID = $gameID;");
			$rowitem = $results->fetch_array();
			$conn->close();
			?>

			<form method="get" action="record_edit.php">
				<input name="gameID" type="text" value="<?=$gameID?>" hidden>
				
				<div class="row">
					<div class="w3-container w3-cell wind"><h3>동</h3></div>
					<div class="w3-container w3-cell" style="width:130px;">
						<select id="eastName" name="eastName" style="width:100%;" autocomplete="off" required>
							<option disabled>이름</option>
							<?php
							foreach ($names as $name) {
								if ($name === $rowitem['eastName']) {
									echo '<option value="'.$name.'" selected>'.$name.'</option>';
								}
								else {
									echo '<option value="'.$name.'">'.$name.'</option>';
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
						<select id="southName" name="southName" style="width:100%;" autocomplete="off" required>
							<?php
							foreach ($names as $name) {
								if ($name === $rowitem['southName']) {
									echo '<option value="'.$name.'" selected>'.$name.'</option>';
								}
								else {
									echo '<option value="'.$name.'">'.$name.'</option>';
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
						<select id="westName" name="westName" style="width:100%;" autocomplete="off" required>
							<?php
							foreach ($names as $name) {
								if ($name === $rowitem['westName']) {
									echo '<option value="'.$name.'" selected>'.$name.'</option>';
								}
								else {
									echo '<option value="'.$name.'">'.$name.'</option>';
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
						<select id="northName" name="northName" style="width:100%;" autocomplete="off" required>
							<?php
							foreach ($names as $name) {
								if ($name === $rowitem['northName']) {
									echo '<option value="'.$name.'" selected>'.$name.'</option>';
								}
								else {
									echo '<option value="'.$name.'">'.$name.'</option>';
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
						<input id="total" name="total" class="w3-input" type="text" disabled value="0" autocomplete="off">
					</div>
				</div>
				
				<div class="row" style="height: 200px;">
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
				if (tot == 100000) { document.getElementById("submit").disabled = false; }
				else { document.getElementById("submit").disabled = true; }
			}
			getTotal();
		</script>
	</body>
</html>
