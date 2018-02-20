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
	AND valid = 1;"
)

echo "<table>";
while ($rowitem = $conn->fetch_array($results)) {
	echo "<tr>";
	echo "<td>" . $rowitem['gameID'] . "</td>";
	echo "<td>" . $rowitem['gameTime'] . "</td>";
	echo "<td>" . $rowitem['1stName'] . "</td>";
	echo "<td>" . $rowitem['1stScore'] . "</td>";
	echo "<td>" . $rowitem['2ndName'] . "</td>";
	echo "<td>" . $rowitem['2ndScore'] . "</td>";
	echo "<td>" . $rowitem['3rdName'] . "</td>";
	echo "<td>" . $rowitem['3rdScore'] . "</td>";
	echo "<td>" . $rowitem['4thName'] . "</td>";
	echo "<td>" . $rowitem['4thScore'] . "</td>";
	echo "<td>" . $rowitem['leftover'] . "</td>";
	echo "<td> <a href='edit.html'>수정</a> </td>";
	echo "<td> <a href='delete.php'>삭제</a> </td>";
	echo "</tr>";
}

$results = $conn->query(
	"SELECT * FROM Games
	WHERE gameTime < DATE_SUB(NOW(), INTERVAL 30 MINUTE)
	AND valid = 1;"
)

while ($rowitem = $conn->fetch_array($results)) {
	echo "<tr>";
	echo "<td>" . $rowitem['gameID'] . "</td>";
	echo "<td>" . $rowitem['gameTime'] . "</td>";
	echo "<td>" . $rowitem['1stName'] . "</td>";
	echo "<td>" . $rowitem['1stScore'] . "</td>";
	echo "<td>" . $rowitem['2ndName'] . "</td>";
	echo "<td>" . $rowitem['2ndScore'] . "</td>";
	echo "<td>" . $rowitem['3rdName'] . "</td>";
	echo "<td>" . $rowitem['3rdScore'] . "</td>";
	echo "<td>" . $rowitem['4thName'] . "</td>";
	echo "<td>" . $rowitem['4thScore'] . "</td>";
	echo "<td>" . $rowitem['leftover'] . "</td>";
	echo "<td> </td>";
	echo "<td> </td>";
	echo "</tr>";
}
echo "</table>";