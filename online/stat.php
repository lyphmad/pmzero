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
				<h1>통계</h1>
			</div>
		</div>

		<?php
		// Create connection
		$conn = new mysqli("localhost", "openvpnas", "", "online");
		// Check connection
		if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
		}
		$conn->set_charset("utf8");

		$minus = $conn->query ("SELECT COUNT(*) FROM Games WHERE eastScore < 0 OR southScore < 0 OR westScore < 0 OR northScore < 0;")->fetch_array()[0];
		$total = $conn->query ("SELECT COUNT(*) FROM Games;")->fetch_array()[0];
		
		$east_highest = $conn->query ("SELECT gameID, eastScore, eastID FROM Games ORDER BY eastScore DESC LIMIT 1;")->fetch_array();
		$south_highest = $conn->query ("SELECT gameID, southScore, southID FROM Games ORDER BY southScore DESC LIMIT 1;")->fetch_array();
		$west_highest = $conn->query ("SELECT gameID, westScore, westID FROM Games ORDER BY westScore DESC LIMIT 1;")->fetch_array();
		$north_highest = $conn->query ("SELECT gameID, northScore, northID FROM Games ORDER BY northScore DESC LIMIT 1;")->fetch_array();

		if ($east_highest['eastScore'] > $south_highest['southScore']) {
			$highest['gameID'] = $east_highest['gameID'];
			$highest['ID'] = $east_highest['eastID'];
			$highest['Score'] = $east_highest['eastScore'];
		}
		else {
			$highest['gameID'] = $south_highest['gameID'];
			$highest['ID'] = $south_highest['southID'];
			$highest['Score'] = $south_highest['southScore'];
		}

		if ($west_highest['eastScore'] > $highest['southScore']) {
			$highest['gameID'] = $west_highest['gameID'];
			$highest['ID'] = $west_highest['westScore'];
			$highest['Score'] = $west_highest['westScore'];
		}

		if ($north_highest['eastScore'] > $highest['southScore']) {
			$highest['gameID'] = $north_highest['gameID'];
			$highest['ID'] = $north_highest['northID'];
			$highest['Score'] = $north_highest['northScore'];
		}

		$name = $conn->query ("SELECT `name` FROM Members WHERE memberID = " . $highest['ID'] . ";")->fetch_array()['name'];
		?>

		<div class="w3-container" style="width: fit-content; margin-top: 10px;">
			<table id="myTable" class="w3-table-all">
				<tr style="background-color: #43c1c3; color: white;">
					<th nowrap>들통</th>
					<th nowrap style="border-left: 1px solid black;"></th>
					<th nowrap>최고 점수</th>

				</tr>
				<tr>
					<td nowrap><?=$minus?> (<?=round($minus * 100 / $total, 1)?>%)</td>
					<th nowrap style="border-left: 1px solid black;"></th>
					<td nowrap><?=$name?> - <?=$highest['Score']?> (<?=$highest['gameID']?>번째 경기)</td>
				</tr>
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
	</script>
	</body>
</html>