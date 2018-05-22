<!DOCTYPE html>
<html>
<title>UNIST 마작 소모임 ±0</title>
<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<body>
  <div w3-include-html="menubar.html"></div>

	<div class="w3-main" style="margin-left:200px">
		<div style="background-color: #001c54; color: white" scrolling="NO">
			<button class="w3-button w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
			<div class="w3-container">
				<h1>통산 랭킹</h1>
			</div>
		</div>

		<?php
		// Create connection
		$conn = new mysqli("localhost", "openvpnas", "", "pmzero");
		// Check connection
		if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
		}
		$conn->set_charset("utf8");
		$games = $conn->query("SELECT * FROM Games;");

		$player_score = array();
		$player_info = array();

		while ($rowitem = $games->fetch_array()) {
			$playerID = array($rowitem['eastID'], $rowitem['southID'], $rowitem['westID'], $rowitem['northID']);
			$score = array($rowitem['eastScore'], $rowitem['southScore'], $rowitem['westScore'], $rowitem['northScore']);

			for ($i = 0; $i < 4; $i++) {
				if (!array_key_exists ($playerID[$i], $player_info)) {
					$name = $conn->query ("SELECT `name` FROM Members WHERE `memberID` = " . $playerID[$i] . ";")->fetch_array()['name'];
					$player_score[$playerID[$i]] = 0;
					$player_info[$playerID[$i]] = array('name' => $name, 'rank' => array (NULL, 0, 0, 0, 0));
				}
			}

			$rank = array(1, 1, 1, 1);
			if ($score[0] < $score[1]) { $rank[0]++; } else { $rank[1]++; }
			if ($score[0] < $score[2]) { $rank[0]++; } else { $rank[2]++; }
			if ($score[0] < $score[3]) { $rank[0]++; } else { $rank[3]++; }
			if ($score[1] < $score[2]) { $rank[1]++; } else { $rank[2]++; }
			if ($score[1] < $score[3]) { $rank[1]++; } else { $rank[3]++; }
			if ($score[2] < $score[3]) { $rank[2]++; } else { $rank[3]++; }

			for ($i = 0; $i < 4; $i++) {
				if ($rank[$i] == 1) {
					$player_score[$playerID[$i]] += ($score[$i] + 10000) / 1000;
					$player_info[$playerID[$i]]['rank'][1]++;
				}
				elseif ($rank[$i] == 2) {
					$player_score[$playerID[$i]] += ($score[$i] - 20000) / 1000;
					$player_info[$playerID[$i]]['rank'][2]++;
				}
				elseif ($rank[$i] == 3) {
					$player_score[$playerID[$i]] += ($score[$i] - 40000) / 1000;
					$player_info[$playerID[$i]]['rank'][3]++;
				}
				elseif ($rank[$i] == 4) {
					$player_score[$playerID[$i]] += ($score[$i] - 50000) / 1000;
					$player_info[$playerID[$i]]['rank'][4]++;
				}
			} //우마: 10-30
		}

		arsort ($player_score);
		?>

		<div style="overflow-x:auto;">
			<table class="w3-table-all">
				<tr style="background-color: #43c1c3; color: white;">
					<th nowrap>순위</th>
					<th nowrap>이름</th>
					<th nowrap>승점</th>
					<th nowrap>평균 승점</th>
					<th nowrap>대국수</th>
					<th nowrap style="border-left: 1px solid black; margin-right: 5px;"></th>
					<th nowrap>1위</th>
					<th nowrap>2위</th>
					<th nowrap>3위</th>
					<th nowrap>4위</th> 
					<th nowrap>평균 순위</th>   
					<th nowrap style="border-left: 1px solid black; margin-right: 5px;"></th>
					<th nowrap>1위율</th>
					<th nowrap>2위율</th>
					<th nowrap>3위율</th>
					<th nowrap>4위율</th>
				</tr>
				<?php
				$i = 1;
				foreach ($player_score as $playerID => $score) {
					$name = $player_info[$playerID]['name'];
					$rank = $player_info[$playerID]['rank'];
					$total = $rank[1] + $rank[2] + $rank[3] + $rank[4];
					$average = round(($rank[1] + 2 * $rank[2] + 3 * $rank[3] + 4 * $rank[4]) / $total, 2);

					echo '<tr>';
					echo '<td nowrap>' . $i++ . '</td>';
					echo '<td nowrap>' . $player_info[$playerID]['name'] . '</td>';
					echo '<td nowrap>' . round($score, 1) . '</td>';
					echo '<td nowrap>' . round($score / $total, 2) . '</td>';
					echo '<td nowrap>' . $total . '</td>';
					echo '<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>';
					echo '<td nowrap>' . $rank[1] . '</td>';
					echo '<td nowrap>' . $rank[2] . '</td>';
					echo '<td nowrap>' . $rank[3] . '</td>';
					echo '<td nowrap>' . $rank[4] . '</td>';
					echo '<td nowrap>' . $average . '</td>';
					echo '<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>';
					echo '<td nowrap>' . round($rank[1] * 100 / $total) . '</td>';
					echo '<td nowrap>' . round($rank[2] * 100 / $total) . '</td>';
					echo '<td nowrap>' . round($rank[3] * 100 / $total) . '</td>';
					echo '<td nowrap>' . round($rank[4] * 100 / $total) . '</td>';
					echo '</tr>';
				}
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
	</script>
	</body>
</html>