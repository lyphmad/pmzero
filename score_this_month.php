<!DOCTYPE html>
<html>
<title>UNIST 마작 소모임 ±0</title>
<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<body>
	
<div class="w3-sidebar w3-bar-block w3-collapse w3-card w3-animate-left" style="width:200px; background-color: #001c54; color: white;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">Close &times;</button>
  <a href="score_this_month.php" class="w3-bar-item w3-button">이번 달 기록</a>
  <a href="record.html" class="w3-bar-item w3-button">기록 입력</a>
  <a href="https://github.com/lyphmad/pmzero" class="w3-bar-item w3-button"> GitHub </a>
</div>

<div class="w3-main" style="margin-left:200px">
<div style="background-color: #001c54; color: white">
  <button class="w3-button w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
  <div class="w3-container" style="background-color: #001c54;">
    <h1>이번 달 기록</h1>
  </div>
</div>

<?php
$conn = new mysqli("localhost", "ubuntu", "", "pmzero");
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error());
}

$conn->set_charset("utf8");

$results = $conn->query(
	"SELECT * FROM Games
	WHERE valid = 1
	ORDER BY gameTime DESC;"
);
?>

<table class="w3-table-all" style="align-left;">

	<tr style="background-color: #43c1c3; color: white;">
		<th nowrap>일시</th>
		<th nowrap>1위</th>
		<th nowrap>2위</th>
		<th nowrap>3위</th>
		<th nowrap>4위</th>
		<th nowrap>공탁</th>
		<th nowrap></th>
		<th nowrap></th>
	</tr>

<?php while ($rowitem = $results->fetch_array()) { ?>
	<tr>
		<td nowrap> <?=$rowitem['gameTime']?> </td>
		<td nowrap> [<?=$rowitem['1stWind']?>] <?=$rowitem['1stName']?>: <?=$rowitem['1stScore']?> </td>
		<td nowrap> [<?=$rowitem['2ndWind']?>] <?=$rowitem['2ndName']?>: <?=$rowitem['2ndScore']?> </td>
		<td nowrap> [<?=$rowitem['3rdWind']?>] <?=$rowitem['3rdName']?>: <?=$rowitem['3rdScore']?> </td>
		<td nowrap> [<?=$rowitem['4thWind']?>] <?=$rowitem['4thName']?>: <?=$rowitem['4thScore']?> </td>
		<td nowrap> <?=$rowitem['leftover']?> </td>
		<td nowrap style='color:blue;'> <ins> <a href='edit.php?id=<?=$rowitem['gameID']?>'>수정</a> </ins> </td>
		<td nowrap style='color:blue;'> <ins> <a href='#' onclick="delete_button(<?=$rowitem['gameID']?>)">삭제</a> </ins> </td>
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
function delete_button(gameID) {
	if (confirm("삭제된 기록은 복구할 수 없습니다.\n 정말 삭제하시겠습니까?")) {
		window.location.href='delete.php?id=' + gameID;
	}
}
</script>
</body>
</html>
