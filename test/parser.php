<?php
// Create connection
$conn = new mysqli("localhost", "openvpnas", "", "pmzero");
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

$members = array();
$query = $conn->query ("SELECT * FROM Members");
while ($rowitem = $query->fetch_array()) {
	$members[$rowitem['memberID']] = $rowitem['name'];
}

$infile = fopen ("record.txt", "r") or die ("Unable to open file!");
while (!feof ($infile)) {
	if (fgetc($infile) === false) break;

	$wind = array();
	$name = array();
	$score = array();

	$line = fgets ($infile);
	$words = explode (">", $line);

	$gameID = explode ("<", $words[3])[0] + 1;
	$gameTime = explode ("<", $words[7])[0];

	$temp = explode ("]", $words[12]);
	$wind[1] = explode ("[", $temp[0])[1];
	$temp = explode (" ", $temp[1]);
	$name[1] = explode (":", $temp[0])[0];
	$score[1] = explode ("<", $temp[1])[0] + 10000;

	$temp = explode ("]", $words[14]);
	$wind[2] = explode ("[", $temp[0])[1];
	$temp = explode (" ", $temp[1]);
	$name[2] = explode (":", $temp[0])[0];
	$score[2] = explode ("<", $temp[1])[0] + 30000;

	$temp = explode ("]", $words[16]);
	$wind[3] = explode ("[", $temp[0])[1];
	$temp = explode (" ", $temp[1]);
	$name[3] = explode (":", $temp[0])[0];
	$score[3] = explode ("<", $temp[1])[0] + 30000;

	$temp = explode ("]", $words[18]);
	$wind[4] = explode ("[", $temp[0])[1];
	$temp = explode (" ", $temp[1]);
	$name[4] = explode (":", $temp[0])[0];
	$score[4] = explode ("<", $temp[1])[0] + 30000;

	$leftover = explode ("<", $words[20])[0];

	for ($i = 1; $i < 5; $i++) {
		if ($wind[$i] == '동') {
			$eastID = array_search ($name[$i], $members);
			$eastScore = $score[$i];
		}
		elseif ($wind[$i] == '남') {
			$southID = array_search ($name[$i], $members);
			$southScore = $score[$i];
		}
		elseif ($wind[$i] == '서') {
			$westID = array_search ($name[$i], $members);
			$westScore = $score[$i];
		}
		elseif ($wind[$i] == '북') {
			$northID = array_search ($name[$i], $members);
			$northScore = $score[$i];
		}
	}
	$sql = "INSERT INTO Games SET
	gameID = $gameID, gameTime = '$gameTime',
	eastID = $eastID, eastScore = $eastScore,
	southID = $southID, southScore = $southScore,
	westID = $westID, westScore = $westScore,
	northID = $northID, northScore = $northScore,
	leftover = $leftover";
	if ($conn->query ($sql) === FALSE) {
		die("query failed\n");
	}
}

$conn->close();