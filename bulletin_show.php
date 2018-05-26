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
				<h1>게시판</h1>
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

		$articleID = $_GET['id'];

		$article = $conn->query("SELECT title, content FROM Bulletin WHERE articleID = $articleID;")->fetch_array();
		$title = $article['title'];
		$content = $article['content'];
		$conn->close();
		?>
		<div class="w3-container">
			<h3><?=$title?></h3>
			<?php
				$dir = 'uploads/' . $articleID . '/';
				$files = array_diff (scandir ($dir), array('..', '.'));
				foreach ($files as $file) {
					$filename = $dir . $file;
					echo '<div><img src="' . $filename . '" style="max-width: 1000px;" class="w3-mobile"/></div>';
				}
			?>
			<?=$content?>
		</div>
		<div style="height: 100px;"></div>
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