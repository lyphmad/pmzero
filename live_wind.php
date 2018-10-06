<?php
// Create connection
$conn = new mysqli("localhost", "openvpnas", "", "pmzero");
$conn->set_charset("utf8");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// send query
$result = $conn->query("SELECT * FROM Members ORDER BY `name`;");

$members = array();
while ($rowitem = $result->fetch_array()) {
  $members[$rowitem['memberID']] = $rowitem['name'];
}

$wind = set_wind();

for ($i = 0; $i < 4; $i++) {
	$name[$i] = $members[$wind[$i]];
}	

function set_wind() {
	// Get players
	$wait = array_unique($_GET['wait']);
	sort($wait);
	if($wait[0] == 0) { array_shift($wait); }
	
	$nowait = array_unique($_GET['nowait']);
	sort($nowait);	
	if($nowait[0] == 0) { array_shift($nowait); }

	// No waiting players
	if(count($wait) == 0) {
		shuffle($nowait);
		return $nowait;
	}
	
	// Waiting players
	sort($wait);

	shuffle($nowait);
	for ($i = count($wait); $i < 4; $i++) {
		$wait[$i] = array_pop($nowait);
	}

	shuffle($wait);

	return $wait;
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
				<h1>자리 배치</h1>
			</div>
		</div>
		
		<p>가동이 아닌 진동입니다. 바로 배패를 시작해 주세요.</p>
		
		<p>동 <?=$name[0]?></p>
		<p>남 <?=$name[1]?></p>
		<p>서 <?=$name[2]?></p>
		<p>북 <?=$name[3]?></p>
		
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