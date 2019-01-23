<?php
// Create connection
$conn = new mysqli("localhost", "pmzero", "", "pmzero");
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

$conn->close();
?>

<!DOCTYPE html>	
<html>
	<title>UNIST 마작 소모임 ±0</title>
	<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="w3.css">

	<body>    
		<div w3-include-html="menubar.html"></div>

		<div class="w3-main" style="margin-left:200px">
			<div class="w3-card" style="background-color: #001c54; color: white;">
				<button class="w3-button w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
				<div class="w3-container">
					<h1>자리 배치</h1>
				</div>
			</div>

			<form method="GET" action="live_wind.php">
				<div style="margin-top:20px; margin-left:20px; margin-right:20px; margin-bottom:20px">
					<div id="wait">
						<b>선대기</b><br><br>
						<div id="wait_content">
							<select name="wait[]" style="width:100px;">
								<option value=0 disabled selected> --- </option>
								<?php
								foreach ($members as $ID => $name) {
									echo '<option value=' . $ID . '>' . $name . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					
					<button type="button" name="add_wait">추가</button>
					
					<hr>
					
					<div id="nowait">
						<div id="nowait_content">
							<select name="nowait[]" style="width:100px;">
								<option value=0 selected> --- </option>
								<?php
								foreach ($members as $ID => $name) {
									echo '<option value=' . $ID . '>' . $name . '</option>';
								}
								?>
							</select>
						</div>
						<div>
							<select name="nowait[]" style="width:100px;">
								<option value=0 selected> --- </option>
								<?php
								foreach ($members as $ID => $name) {
									echo '<option value=' . $ID . '>' . $name . '</option>';
								}
								?>
							</select>
						</div>
						<div>
							<select name="nowait[]" style="width:100px;">
								<option value=0 selected> --- </option>
								<?php
								foreach ($members as $ID => $name) {
									echo '<option value=' . $ID . '>' . $name . '</option>';
								}
								?>
							</select>
						</div>
						<div>
							<select name="nowait[]" style="width:100px;">
								<option value=0 selected> --- </option>
								<?php
								foreach ($members as $ID => $name) {
									echo '<option value=' . $ID . '>' . $name . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					
					<button type="button" name="add_nowait">추가</button><br>

					<input type="submit" value="자리 정하기!" style="margin-top: 20px;">
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

		<script src="w3.js"></script>
		<script src="jquery.js"></script>
		<script>
			w3.includeHTML();
			function w3_open() {
				document.getElementById("mySidebar").style.display = "block";
			}

			function w3_close() {
				document.getElementById("mySidebar").style.display = "none";
			}
			
			$( "button[name='add_wait']" ).click(function() {
				$('#wait_content').clone().appendTo('#wait');
			});
			
			$( "button[name='add_nowait']" ).click(function() {
				$('#nowait_content').clone().appendTo('#nowait');
			});
		</script>
	</body>
</html>
