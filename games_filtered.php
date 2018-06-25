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
				<h1>기간 중 기록</h1>
			</div>
		</div>

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
					<th nowrap></th>
					<th nowrap></th>
				</tr>

				<?php
				// Create connection
				$conn = new mysqli("localhost", "openvpnas", "", "pmzero_test");
				// Check connection
				if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
				}
				$conn->set_charset("utf8");

				$type = $_GET['filter_type'];
		
				if (strcmp($type, "date") == 0) {
					$start = $_GET['start'];
					$end = $_GET['end'];
					$query = "SELECT * FROM Games WHERE valid = true AND gameTime <= (SELECT DATE_ADD('$end', INTERVAL 1 DAY)) AND gameTime >= '$start' ORDER BY gameTime DESC;";
				}
				else {
					$start = $_GET['startID'];
					$end = $_GET['endID'];
					$query = "SELECT * FROM Games WHERE valid = true AND gameID <= $end AND gameID >= $start ORDER BY gameTime DESC;";
				}
				$games = $conn->query($query);
				$num = $games->num_rows;

				$player_name = array();
				$windName = array ("동", "남", "서", "북");

				while ($rowitem = $games->fetch_array()) {
					$playerID = array($rowitem['eastID'], $rowitem['southID'], $rowitem['westID'], $rowitem['northID']);
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
					if ($sum == 100000) { echo '<tr>'; }
					else { echo '<tr style="color: red">'; }
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
					echo '<td nowrap><a href="edit_form.php?id=' . $rowitem['gameID'] . '">수정</a></td>';
					echo '<td nowrap style="color: red" onclick="delete_game(' . $rowitem['gameID'] . ')"><a href="#">삭제</a></td>';
					echo '</tr>';
				}
				$conn->close();
				?>
			</table>
			<br><div style="text-align:center;"> 결과 총 <?=$num?>개 </div>
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
		
		function delete_game (gameID) {
			if (confirm (gameID + "번 경기 기록을 삭제합니다.\n계속하시겠습니까?")) {
				window.location.href = 'delete.php?id=' + gameID;
			}
		}
	</script>
	</body>
</html>
