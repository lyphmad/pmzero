 <?php
	$servername = "localhost";
	$username = "ubuntu";
	$password = "";
	$dbname = "pmzero";

	if (!empty($_GET["eastName"]) &&
		!empty($_GET["southName"]) &&
		!empty($_GET["westName"]) &&
		!empty($_GET["northName"])) {

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		$conn->set_charset("utf8");

		$eastName = $_GET["eastName"];
		$southName = $_GET["southName"];
		$westName = $_GET["westName"];
		$northName = $_GET["northName"];
		
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

		$sql =
			"INSERT INTO Games (
				1stWind, 1stName, 1stScore,
				2ndWind, 2ndName, 2ndScore,
				3rdWind, 3rdName, 3rdScore,
				4thWind, 4thName, 4thScore, leftover)
			VALUES (
				'$winds[0]', '$names[0]', $score[0],
				'$winds[1]', '$names[1]', $score[1],
				'$winds[2]', '$names[2]', $score[2],
				'$winds[3]', '$names[3]', $score[3], $leftover)";

		if ($conn->query($sql) === TRUE) {
		    echo "<script>
		    alert('등록되었습니다.');
		    window.location.href='score_this_month.php';
		    </script>";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
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