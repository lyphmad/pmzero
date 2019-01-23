<?php
// Create connection
$conn = new mysqli("localhost", "pmzero", "", "pmzero");
$conn->set_charset("utf8");

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$type = $_GET['filter_type'];
$individual = $_GET['ind'];
if ($individual === "on") {
	$memberID = $_GET['memberID'];
	$opponent = $_GET['opponent'];
	if ($opponent === "on") { $opponentID = $_GET['opponentID']; }
}

if ($type === "date") {
	$start = $_GET['start'];
	$end = $_GET['end'];
	$query = "SELECT * FROM Games WHERE valid = true AND gameTime <= (SELECT DATE_ADD('$end', INTERVAL 1 DAY)) AND gameTime >= '$start' ORDER BY gameID DESC;";
}
elseif ($type === "ID") {
	$start = $_GET['startID'];
	$end = $_GET['endID'];
	$query = "SELECT * FROM Games WHERE valid = true AND gameID <= $end AND gameID >= $start ORDER BY gameID DESC;";
}
else { //none
	$query = "SELECT * FROM Games WHERE valid = true ORDER BY gameID DESC;";
}
$games = $conn->query($query);
$num = 0;

$player_name = array();
$windName = array ("동", "남", "서", "북");

if ($individual === "on" && $opponent === "on") { //전적 (등수) 출력
	$member_rank = array(0, 0, 0, 0);
	$opponent_rank = array(0, 0, 0, 0);
	$num = 0;
	$member_score = 0;
	$opponent_score = 0;
	$win = 0;
	$lose = 0;
	
	while ($rowitem = $games->fetch_array()) {
		$score = array($rowitem['eastScore'], $rowitem['southScore'], $rowitem['westScore'], $rowitem['northScore']);
		$sum = $score[0] + $score[1] + $score[2] + $score[3] + $rowitem['leftover'];
		if ($sum != 100000) { continue; }

		$playerID = array($rowitem['eastID'], $rowitem['southID'], $rowitem['westID'], $rowitem['northID']); //[eastID, southID, westID, northID]

		$member_wind = -1;
		for ($i = 0; $i < 4; $i++) {
			if ($playerID[$i] == $memberID) {
				$member_wind = $i;
				break;
			}
		}
		if ($member_wind == -1) { continue; }

		$opponent_wind = -1;
		for ($i = 0; $i < 4; $i++) {
			if ($playerID[$i] == $opponentID) {
				$opponent_wind = $i;
				break;
			}
		}
		if ($opponent_wind == -1) { continue; }

		$rank = array(1, 1, 1, 1);
		if ($score[0] < $score[1]) { $rank[0]++; } else { $rank[1]++; }
		if ($score[0] < $score[2]) { $rank[0]++; } else { $rank[2]++; }
		if ($score[0] < $score[3]) { $rank[0]++; } else { $rank[3]++; }
		if ($score[1] < $score[2]) { $rank[1]++; } else { $rank[2]++; }
		if ($score[1] < $score[3]) { $rank[1]++; } else { $rank[3]++; }
		if ($score[2] < $score[3]) { $rank[2]++; } else { $rank[3]++; }
		
		if ($rank[$member_wind] == 1) {
			$member_score += ($score[$member_wind] + 10000);
		}
		else if ($rank[$member_wind] == 2) {
			$member_score += ($score[$member_wind] - 20000);
		}
		else if ($rank[$member_wind] == 3) {
			$member_score += ($score[$member_wind] - 40000);
		}
		else if ($rank[$member_wind] == 4) {
			$member_score += ($score[$member_wind] - 50000);
		}
		
		if ($rank[$opponent_wind] == 1) {
			$opponent_score += ($score[$opponent_wind] + 10000);
		}
		else if ($rank[$opponent_wind] == 2) {
			$opponent_score += ($score[$opponent_wind] - 20000);
		}
		else if ($rank[$opponent_wind] == 3) {
			$opponent_score += ($score[$opponent_wind] - 40000);
		}
		else if ($rank[$opponent_wind] == 4) {
			$opponent_score += ($score[$opponent_wind] - 50000);
		}
		
		if ($rank[$member_wind] < $rank[$opponent_wind]) { $win++; }
		else { $lose++; }

		$member_rank[$rank[$member_wind]]++;
		$opponent_rank[$rank[$opponent_wind]]++;
		$num++;
	}
	
	$member_score = round($member_score / 1000, 1);
	$opponent_score = round($opponent_score / 1000, 1);
	
	$member_avgscore = round($member_score / $num, 2);
	$opponent_avgscore = round($opponent_score / $num, 2);
	
	$player_name[$memberID] = $conn->query ("SELECT `name` FROM Members WHERE `memberID` = " . $memberID . ";")->fetch_array()['name'];
	$player_name[$opponentID] = $conn->query ("SELECT `name` FROM Members WHERE `memberID` = " . $opponentID . ";")->fetch_array()['name'];
	$member_avg = round(($member_rank[1] + 2 * $member_rank[2] + 3 * $member_rank[3] + 4 * $member_rank[4]) / $num, 2);
	$opponent_avg = round(($opponent_rank[1] + 2 * $opponent_rank[2] + 3 * $opponent_rank[3] + 4 * $opponent_rank[4]) / $num, 2);
	$games = $conn->query($query);
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
					<h1>경기 기록</h1>
				</div>
			</div>
			<?php if ($individual === "on" && $opponent === "on") {?>
			<table class="w3-table-all" style="width:fit-content; margin-bottom: 10px;">
				<tr style="background-color: #43c1c3; color: white;">
					<th nowrap></th>
					<th nowrap style="border-left: 1px solid black; margin-right: 5px;"></th>
					<th nowrap><?=$player_name[$memberID]?></th>
					<th nowrap style="border-left: 1px solid black; margin-right: 5px;"></th>
					<th nowrap><?=$player_name[$opponentID]?></th>
				</tr>
				<tr>
					<td nowrap>상대 전적</td>
					<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>
					<td nowrap><?=$win?></td>
					<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>
					<td nowrap><?=$lose?></td>
				</tr>
				<tr>
					<td nowrap>1위</td>
					<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>
					<td nowrap><?=$member_rank[1]?></td>
					<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>
					<td nowrap><?=$opponent_rank[1]?></td>
				</tr>
				<tr>
					<td nowrap>2위</td>
					<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>
					<td nowrap><?=$member_rank[2]?></td>
					<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>
					<td nowrap><?=$opponent_rank[2]?></td>
				</tr>
				<tr>
					<td nowrap>3위</td>
					<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>
					<td nowrap><?=$member_rank[3]?></td>
					<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>
					<td nowrap><?=$opponent_rank[3]?></td>
				</tr>
				<tr>
					<td nowrap>4위</td>
					<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>
					<td nowrap><?=$member_rank[4]?></td>
					<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>
					<td nowrap><?=$opponent_rank[4]?></td>
				</tr>
				<tr>
					<td nowrap>평균 순위</td>
					<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>
					<td nowrap><?=$member_avg?></td>
					<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>
					<td nowrap><?=$opponent_avg?></td>
				</tr>
				<tr>
					<td nowrap>승점</td>
					<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>
					<td nowrap><?=$member_score?></td>
					<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>
					<td nowrap><?=$opponent_score?></td>
				</tr>
				<tr>
					<td nowrap>평균 승점</td>
					<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>
					<td nowrap><?=$member_avgscore?></td>
					<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>
					<td nowrap><?=$opponent_avgscore?></td>
				</tr>
			</table>
			<?php } ?>

			<div style="overflow-x:auto;">
				<table class="w3-table-all">
					<tr style="background-color: #43c1c3; color: white;">
						<th nowrap></th>
						<th nowrap>일시</th>
						<th nowrap style="border-left: 1px solid black; margin-right: 5px;"></th>
						<th nowrap>1위</th>
						<th nowrap>2위</th>
						<th nowrap>3위</th>
						<th nowrap>4위</th>
						<th nowrap style="border-left: 1px solid black; margin-right: 5px;"></th>
						<th nowrap>공탁점</th>
						<th nowrap style="border-left: 1px solid black; margin-right: 5px;"></th>
						<th nowrap>도라 갯수</th>
						<th nowrap style="border-left: 1px solid black; margin-right: 5px;"></th>
						<th nowrap>비고</th>
					</tr>

					<?php
					$games_no = 0;
					while ($rowitem = $games->fetch_array()) {
						$games_no++;
						$playerID = array($rowitem['eastID'], $rowitem['southID'], $rowitem['westID'], $rowitem['northID']);
						if ($individual === "on") {
							if ($playerID[0] != $memberID && $playerID[1] != $memberID && $playerID[2] != $memberID && $playerID[3] != $memberID) { continue; }
							if ($opponent === "on" && $playerID[0] != $opponentID && $playerID[1] != $opponentID && $playerID[2] != $opponentID && $playerID[3] != $opponentID) { continue;	}
						}
						$score = array($rowitem['eastScore'], $rowitem['southScore'], $rowitem['westScore'], $rowitem['northScore']);
						$sum = $score[0] + $score[1] + $score[2] + $score[3] + $rowitem['leftover'];

						for ($i = 0; $i < 4; $i++) {
							if (!array_key_exists ($playerID[$i], $player_name)) {
								$player_name[$playerID[$i]] = $conn->query ("SELECT `name` FROM Members WHERE `memberID` = " . $playerID[$i] . ";")->fetch_array()['name'];
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
								$firstWind = $i;
							}
							elseif ($rank[$i] == 2) {
								$secondWind = $i;
							}
							elseif ($rank[$i] == 3) {
								$thirdWind = $i;
							}
							elseif ($rank[$i] == 4) {
								$fourthWind = $i;
							}
						}
						if ($sum != 100000 && $sum != 120000) { echo '<tr style="color: red">'; }
						else if ($rowitem['no_ranking']) { echo '<tr style="color: lightgray">'; }
						else { echo '<tr>'; }
						echo '<td nowrap>' . $rowitem['gameID'] . '</td>';
						echo '<td nowrap>' . $rowitem['gameTime'] . '</td>';
						echo '<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>';
						echo '<td nowrap>[' . $windName[$firstWind] . '] ' . $player_name[$playerID[$firstWind]] . ': ' . $score[$firstWind]  . '</td>';
						echo '<td nowrap>[' . $windName[$secondWind] . '] ' . $player_name[$playerID[$secondWind]] . ': ' . $score[$secondWind]  . '</td>';
						echo '<td nowrap>[' . $windName[$thirdWind] . '] ' . $player_name[$playerID[$thirdWind]] . ': ' . $score[$thirdWind]  . '</td>';
						echo '<td nowrap>[' . $windName[$fourthWind] . '] ' . $player_name[$playerID[$fourthWind]] . ': ' . $score[$fourthWind]  . '</td>';
						echo '<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>';
						echo '<td nowrap>' . $rowitem['leftover']  . '</td>';
						echo '<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>';
						echo '<td nowrap>' . $rowitem['dora']  . '</td>';
						echo '<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>';
						echo '<td nowrap>' . $rowitem['etc']  . '</td>';
						echo '</tr>';
					}
					$conn->close();
					?>
				</table>
				<br><div style="text-align:center;"> 결과 총 <?=$games_no?>개 </div>
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
