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
				<h1>이번 달 순위</h1>
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

		$players = array();
		$results = $conn->query("SELECT * FROM Month_ranking_".date("Ym")." ORDER BY `score` DESC;");

		$conn->close();
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
				while($rowitem = $results->fetch_array()) {
					echo '<tr>';
					echo '<td nowrap>'.$i++.'</td>';
					echo '<td nowrap>'.$rowitem['name'].'</td>';
					echo '<td nowrap>'.$rowitem['score'].'</td>';
					echo '<td nowrap>'.$rowitem['score'] / $rowitem['total'].'</td>';
					echo '<td nowrap>'.$rowitem['total'].'</td>';
					echo '<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>';
					echo '<td nowrap>'.$rowitem['first'].'</td>';
					echo '<td nowrap>'.$rowitem['second'].'</td>';
					echo '<td nowrap>'.$rowitem['third'].'</td>';
					echo '<td nowrap>'.$rowitem['fourth'].'</td>';
					$avg = ($rowitem['first'] + 2 * $rowitem['second'] + 3 * $rowitem['third'] + 4 * $rowitem['fourth']) / $rowitem['total'];
					echo '<td nowrap>'.$avg.'</td>';
					echo '<td nowrap style="border-left: 1px solid black; margin-right: 5px;"></td>';
					echo '<td nowrap>'.$rowitem['first'] * 100 / $rowitem['total'].'%</td>';
					echo '<td nowrap>'.$rowitem['second'] * 100 / $rowitem['total'].'%</td>';
					echo '<td nowrap>'.$rowitem['third'] * 100 / $rowitem['total'].'%</td>';
					echo '<td nowrap>'.$rowitem['fourth'] * 100 / $rowitem['total'].'%</td>';
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