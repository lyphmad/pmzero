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
				<h1>순위</h1>
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

		$player_score = array();
		$player_info = array();

		$filter_type = $_GET['filter_type'];
		$minimum = $_GET['minimum'];

		if ($filter_type === "ID") {
			$start = $_GET['startID'];
			$end = $_GET['endID'];
			$query = "SELECT * FROM Games WHERE valid = true AND gameID <= $end AND gameID >= $start ORDER BY gameTime DESC;";
		}
		elseif ($filter_type === "date") { //none
			$start = $_GET['start'];
			$end = $_GET['end'];
			$query = "SELECT * FROM Games WHERE valid = true AND gameTime <= (SELECT DATE_ADD('$end', INTERVAL 1 DAY)) AND gameTime >= '$start' ORDER BY gameTime DESC;";
		}
		else { //none
			$query = "SELECT * FROM Games WHERE valid = true;";
		}
		$games = $conn->query($query);

		if ($minimum != 0) {
			$player_total = array();

			while ($rowitem = $games->fetch_array()) {
				if (!array_key_exists ($rowitem['eastID'], $player_total)) {
					$player_total[$rowitem['eastID']] = 1;
				}
				else {
					$player_total[$rowitem['eastID']]++;
				}
				
				if (!array_key_exists ($rowitem['southID'], $player_total)) {
					$player_total[$rowitem['southID']] = 1;
				}
				else {
					$player_total[$rowitem['southID']]++;
				}
				
				if (!array_key_exists ($rowitem['westID'], $player_total)) {
					$player_total[$rowitem['westID']] = 1;
				}
				else {
					$player_total[$rowitem['westID']]++;
				}
				
				if (!array_key_exists ($rowitem['northID'], $player_total)) {
					$player_total[$rowitem['northID']] = 1;
				}
				else {
					$player_total[$rowitem['northID']]++;
				}
			}
			$games = $conn->query($query);
		}

		while ($rowitem = $games->fetch_array()) {
			if ($minimum != 0) {
				if ($player_total[$rowitem['eastID']] < $minimum) { continue; }
				if ($player_total[$rowitem['southID']] < $minimum) { continue; }
				if ($player_total[$rowitem['westID']] < $minimum) { continue; }
				if ($player_total[$rowitem['northID']] < $minimum) { continue; }
			}

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

		<div style="minimumflow-x:auto;">
			<table id="myTable" class="w3-table-all">
				<tr style="background-color: #43c1c3; color: white;">
					<th nowrap onclick="sortTable(0)">순위</th>
					<th nowrap onclick="sortTable(1)">이름</th>
					<th nowrap onclick="sortTable(2)">승점</th>
					<th nowrap onclick="sortTable(3)">평균 승점</th>
					<th nowrap onclick="sortTable(4)">대국수</th>
					<th nowrap style="border-left: 1px solid black; margin-right: 5px;"></th>
					<th nowrap onclick="sortTable(6)">1위</th>
					<th nowrap onclick="sortTable(7)">2위</th>
					<th nowrap onclick="sortTable(8)">3위</th>
					<th nowrap onclick="sortTable(9)">4위</th> 
					<th nowrap onclick="sortTable(10)">평균 순위</th>   
					<th nowrap style="border-left: 1px solid black; margin-right: 5px;"></th>
					<th nowrap onclick="sortTable(12)">1위율</th>
					<th nowrap onclick="sortTable(13)">2위율</th>
					<th nowrap onclick="sortTable(14)">3위율</th>
					<th nowrap onclick="sortTable(15)">4위율</th>
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
					echo '<td nowrap>' . round($rank[1] * 100 / $total, 1) . '</td>';
					echo '<td nowrap>' . round($rank[2] * 100 / $total, 1) . '</td>';
					echo '<td nowrap>' . round($rank[3] * 100 / $total, 1) . '</td>';
					echo '<td nowrap>' . round($rank[4] * 100 / $total, 1) . '</td>';
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

		function sortTable(elem) { //from https://www.w3schools.com/howto/howto_js_sort_table.asp
			var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
			table = document.getElementById("myTable");
			switching = true;
			// Set the sorting direction to ascending:
			dir = "asc"; 
			/* Make a loop that will continue until
			no switching has been done: */
			while (switching) {
				// Start by saying: no switching is done:
				switching = false;
				rows = table.getElementsByTagName("TR");
				/* Loop through all table rows (except the
				first, which contains table headers): */
				for (i = 1; i < (rows.length - 1); i++) {
					// Start by saying there should be no switching:
					shouldSwitch = false;
					/* Get the two elements you want to compare,
					one from current row and one from the next: */
					x = rows[i].getElementsByTagName("TD")[elem];
					y = rows[i + 1].getElementsByTagName("TD")[elem];
					/* Check if the two rows should switch place,
					based on the direction, asc or desc: */
					if (elem == 0 || elem == 10) {
						if (dir == "asc") {
							if (Number(x.innerHTML) > Number(y.innerHTML)) {
								// If so, mark as a switch and break the loop:
								shouldSwitch = true;
								break;
							}
						} else if (dir == "desc") {
							if (Number(x.innerHTML) < Number(y.innerHTML)) {
								// If so, mark as a switch and break the loop:
								shouldSwitch = true;
								break;
							}
						}
					}
					else if (elem == 1) {
						if (dir == "asc") {
							if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
								// If so, mark as a switch and break the loop:
								shouldSwitch = true;
								break;
							}
						} else if (dir == "desc") {
							if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
								// If so, mark as a switch and break the loop:
								shouldSwitch = true;
								break;
							}
						}
					}
					else {
						if (dir == "asc") {
							if (Number(x.innerHTML) < Number(y.innerHTML)) {
								// If so, mark as a switch and break the loop:
								shouldSwitch = true;
								break;
							}
						} else if (dir == "desc") {
							if (Number(x.innerHTML) > Number(y.innerHTML)) {
								// If so, mark as a switch and break the loop:
								shouldSwitch = true;
								break;
							}
						}
					}
				}
				if (shouldSwitch) {
					/* If a switch has been marked, make the switch
					and mark that a switch has been done: */
					rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
					switching = true;
					// Each time a switch is done, increase this count by 1:
					switchcount ++; 
				} else {
					/* If no switching has been done AND the direction is "asc",
					set the direction to "desc" and run the while loop again. */
					if (switchcount == 0 && dir == "asc") {
						dir = "desc";
						switching = true;
					}
				}
			}
		}
	</script>
	</body>
</html>