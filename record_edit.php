<?php
if (!empty($_GET["eastName"]) &&
	!empty($_GET["southName"]) &&
	!empty($_GET["westName"]) &&
	!empty($_GET["northName"])) {
	// Create connection
		$conn = new mysqli("localhost", "ubuntu", "", "pmzero");
	// Check connection
	if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
	}

	$conn->set_charset("utf8");

	$eastName = $_GET["eastName"];
	$southName = $_GET["southName"];
	$westName = $_GET["westName"];
	$northName = $_GET["northName"];
	$gameID = $_GET["gameID"];
	
	if (empty($_GET["eastScore"])) {
		$eastScore = 0;
	}
	else {
		$eastScore = $_GET["eastScore"];
	}
	if (empty($_GET["southScore"])) {
		$southScore = 0;
	}
	else {
		$southScore = $_GET["southScore"];
	}
	if (empty($_GET["westScore"])) {
		$westScore = 0;
	}
	else {
		$westScore = $_GET["westScore"];
	}
	if (empty($_GET["northScore"])) {
		$northScore = 0;
	}
	else {
		$northScore = $_GET["northScore"];
	}
	if (empty($_GET["leftover"])) {
		$leftover = 0;
	}
	else {
		$leftover = $_GET["leftover"];
	}

	$sum = $eastScore + $southScore + $westScore + $northScore + $leftover;

	if ($sum != 100000) {
		die("Invalid input: sum not 100000\n");
	}
	
	$name_wind = array(
		$eastName => '동',
		$southName => '남',
		$westName => '서',
		$northName => '북'
	);

	$sql = "UPDATE Cache SET
		eastName = '$eastName', eastScore = $eastScore,
		southName = '$southName', southScore = $southScore,
		westName = '$westName', westScore = $westScore,
		northName = '$northName', northScore = $northScore, leftover = $leftover
		WHERE gameID = $gameID;";

	if ($conn->query($sql) === FALSE) {
		die("Error: " . $sql . "<br>" . $conn->error);
	}

	$temp = array(
		array(0, $eastName, $eastScore),
		array(1, $southName, $southScore),
		array(2, $westName, $westScore),
		array(3, $northName, $northScore)
	);

	uasort($temp, function($a, $b) {
			return $a[2] == $b[2] ? ($a[0] - $b[0]) : ($a[2] < $b[2] ? 1 : -1);
		});

	$arr = array();
	foreach ($temp as $val) {
		$arr[$val[1]] = $val[2];
	}

	$names = array_keys($arr);
	$score = array_values($arr);
	for ($i=0; $i < 4; $i++) { 
		$winds[$i] = $name_wind[$names[$i]];
	}

	$sql = "UPDATE Games SET
		1stWind = '$winds[0]', 1stName = '$names[0]', 1stScore = $score[0],
		2ndWind = '$winds[1]', 2ndName = '$names[1]', 2ndScore = $score[1],
		3rdWind = '$winds[2]', 3rdName = '$names[2]', 3rdScore = $score[2],
		4thWind = '$winds[3]', 4thName = '$names[3]', 4thScore = $score[3],
		leftover = $leftover WHERE gameID = $gameID;";

	if ($conn->query($sql) === TRUE) {
			echo "<script>
			alert('수정되었습니다.');
			window.location.href='score_this_month.php';
			</script>";
	} else {
			die("Error: " . $sql . "<br>" . $conn->error);
	}

$conn->close();
}
else {
	echo "<script>
	alert('empty field exists');
	window.history.back();
	</script>";
}
?> 