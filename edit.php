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
  <a href="#" class="w3-bar-item w3-button">Link 3</a>
</div>

<div class="w3-main" style="margin-left:200px">
<div style="background-color: #001c54; color: white">
  <button class="w3-button w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
  <div class="w3-container" style="background-color: #001c54;">
    <h1>기록 수정</h1>
  </div>
</div>

<?php
    // Create connection
    $conn = new mysqli("localhost", "ubuntu", "", "pmzero");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->set_charset("utf8");

    $gameID = $_GET["id"];

    $results = $conn->query("SELECT * FROM Cache WHERE gameID = $gameID;");
    $rowitem = $results->fetch_array();
?>

<form method="get" action="record_edit.php">
  <input name="gameID" type="text" value="<?=$gameID?>" hidden>
<div class="w3-container w3-row-padding">
	<div class="w3-col"><h3>1위</h3></div>
  	<div class="w3-quarter">
  	  <input name="eastName" class="w3-input" type="text" value="<?=$rowitem['eastName']?>" required>
    </div>
    <div class="w3-quarter">
      <input id="eastScore" name="eastScore" class="w3-input" type="text" onblur="getTotal()" value="<?=$rowitem['eastScore']?>">
    </div>
</div>

<div class="w3-container w3-row-padding">
	<div class="w3-col"><h3>남</h3></div>
  	<div class="w3-quarter">
  	  <input name="southName" class="w3-input" type="text" value="<?=$rowitem['southName']?>" required>
    </div>
    <div class="w3-quarter">
      <input id="southScore" name="southScore" class="w3-input" type="text" onblur="getTotal()" value="<?=$rowitem['southScore']?>">
    </div>
</div>

<div class="w3-container w3-row-padding">
	<div class="w3-col"><h3>서</h3></div>
  	<div class="w3-quarter">
  	  <input name="westName" class="w3-input" type="text" value="<?=$rowitem['westName']?>" required>
    </div>
    <div class="w3-quarter">
      <input id="westScore" name="westScore" class="w3-input" type="text" onblur="getTotal()" value="<?=$rowitem['westScore']?>">
    </div>
</div>

<div class="w3-container w3-row-padding">
	<div class="w3-col"><h3>북</h3></div>
  	<div class="w3-quarter">
  	  <input name="northName" class="w3-input" type="text" value="<?=$rowitem['northName']?>" required>
    </div>
    <div class="w3-quarter">
      <input id="northScore" name="northScore" class="w3-input" type="text" onblur="getTotal()" value="<?=$rowitem['northScore']?>">
    </div>
</div>

<div class="w3-container w3-row-padding">
	<div class="w3-col"><h3>공탁</h3></div>
  	<div class="w3-quarter">
    </div>
    <div class="w3-quarter">
      <input id="leftover" name="leftover" class="w3-input" type="text" onblur="getTotal()" value="<?=$rowitem['leftover']?>">
    </div>
</div>

<div class="w3-container w3-row-padding">
	<div class="w3-col"><h3>합계</h3></div>
  	<div class="w3-quarter">
    </div>
    <div class="w3-quarter">
      <input id="total" name="total" class="w3-input" type="text" disabled value="0">
    </div>
</div>

<div class="w3-container w3-row-padding" style="margin-top: 10px; margin-left: 8px;">
<input id="submit" class="w3-button w3-border" type="submit" value="기록 입력">
</div>
   
</div>
</form>

<script>
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
}
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
}
function getTotal() {
	var east = parseInt(document.getElementById('eastScore').value);
	var south = parseInt(document.getElementById('southScore').value);
	var west = parseInt(document.getElementById('westScore').value);
	var north = parseInt(document.getElementById('northScore').value);
	var left = parseInt(document.getElementById('leftover').value);

	var tot = 0;
	if (east) { tot += east; }
	if (south) { tot += south; }
	if (west) { tot += west; }
	if (north) { tot += north; }
	if (left) { tot += left; }
	document.getElementById('total').value = tot;
	if (tot == 100000) { document.getElementById("submit").disabled = false; }
  else { document.getElementById("submit").disabled = true; }
}

</script>
</body>
</html>
