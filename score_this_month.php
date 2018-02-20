<!DOCTYPE html>
<html>
<title>UNIST 마작 소모임 ±0</title>
<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<body>
	
<div class="w3-sidebar w3-bar-block w3-collapse w3-card w3-animate-left" style="width:200px; background-color: #001c54; color: white;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">Close &times;</button>
  <a href="score_this_month.php" class="w3-bar-item w3-button">이번달 기록</a>
  <a href="record.html" class="w3-bar-item w3-button">기록 입력</a>
  <a href="#" class="w3-bar-item w3-button">Link 3</a>
</div>

<div class="w3-main" style="margin-left:200px">
<div style="background-color: #001c54; color: white">
  <button class="w3-button w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
  <div class="w3-container" style="background-color: #001c54;">
    <h1>이번달 기록</h1>
  </div>
</div>

<?php
$servername = "localhost";
$username = "ubuntu";
$password = "";
$dbname = "pmzero";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error());
}

$conn->set_charset("utf8");

$results = $conn->query(
	"SELECT * FROM Games
	WHERE gameTime >= DATE_SUB(NOW(), INTERVAL 30 MINUTE)
	AND valid = 1
	ORDER BY gameTime DESC;"
);
?>

<table class="w3-table-all" style="align-left;">

	<tr style="background-color: #43c1c3; color: white;">
		<th>ID</th>
		<th>일시</th>
		<th>1위</th>
		<th>2위</th>
		<th>3위</th>
		<th>4위</th>
		<th>공탁</th>
		<th></th>
		<th></th>
	</tr>

<?php while ($rowitem = $results->fetch_array()) { ?>
	<tr>
		<td> <?=$rowitem['gameID']?> </td>
		<td style="width: 200px;"> <?=$rowitem['gameTime']?> </td>
		<td style="width: 200px;"> <?=$rowitem['1stName']?>: <?=$rowitem['1stScore']?> </td>
		<td style="width: 200px;"> <?=$rowitem['2ndName']?>: <?=$rowitem['2ndScore']?> </td>
		<td style="width: 200px;"> <?=$rowitem['3rdName']?>: <?=$rowitem['3rdScore']?> </td>
		<td style="width: 200px;"> <?=$rowitem['4thName']?>: <?=$rowitem['4thScore']?> </td>
		<td style="width: 100px;"> <?=$rowitem['leftover']?> </td>
		<td style="width: 75px;"> <a href='edit.html'>수정</a> </td>
		<td style="width: 75px;"> <a href='delete.php'>삭제</a> </td>
	</tr>

<?php
}

$results = $conn->query(
	"SELECT * FROM Games
	WHERE gameTime < DATE_SUB(NOW(), INTERVAL 30 MINUTE)
	AND valid = 1
	ORDER BY gameTime DESC;"
);

while ($rowitem = $results->fetch_array()) {
	?>
	<tr>
		<td> <?=$rowitem['gameID']?> </td>
		<td> <?=$rowitem['gameTime']?> </td>
		<td> <?=$rowitem['1stName']?>: <?=$rowitem['1stScore']?> </td>
		<td> <?=$rowitem['2ndName']?>: <?=$rowitem['2ndScore']?> </td>
		<td> <?=$rowitem['3rdName']?>: <?=$rowitem['3rdScore']?> </td>
		<td> <?=$rowitem['4thName']?>: <?=$rowitem['4thScore']?> </td>
		<td> <?=$rowitem['leftover']?> </td>
		<td> </td>
		<td> </td>
	</tr>
<?php } ?>

</table>
</div>

<script>
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
}
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
}
</script>
</body>
</html>
