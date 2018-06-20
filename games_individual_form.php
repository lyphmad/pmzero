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
			<div class="w3-card" style="background-color: #001c54; color: white" scrolling="NO">
				<button class="w3-button w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
				<div class="w3-container">
					<h1>개인 전적</h1>
				</div>
			</div>

			<form method="get" action="games_individual.php">
				<div style="margin-left:10px; margin-top:10px;">
					<span style="font-size:20px; font-weight:bold;">이름</span>
					<select name="memberID" style="margin-left:10px; width:100px;">
						<option disabled selected> --- </option>
						<?php
						foreach ($members as $ID => $name) {
							echo '<option value=' . $ID . '>' . $name . '</option>';
						}
						?>
					</select>
					<input type="submit" value="보기" style="margin-left:10px;">
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
		</script>
	</body>
</html>
