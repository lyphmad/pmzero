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
					<h1>기간 중 기록</h1>
				</div>
			</div>

			<form method="GET" action="games_filtered_date.php">
				<div class="w3-container" style="margin-top: 10px;">
					일자를 입력해 주세요.<br>
					<input id="start" name="start" type="date" style="margin-top: 3px;"> ~ <input id="end" name="end" type="date">
					<input type="submit" value="제출"><br>
					<button type="button" onclick="firstgame()" style="margin-top: 10px;">첫 경기부터</button>
					<button type="button" onclick="yesterday()" style="margin-left: 30px;">어제부터</button>
					<button type="button" onclick="week()" style="margin-top: 10px;">1주</button>
					<button type="button" onclick="month()" style="margin-top: 10px;">1개월</button>
					<button type="button" onclick="this_semester()" style="margin-top: 10px;">이번 학기</button>
					<button type="button" onclick="last_semester()" style="margin-top: 10px;">지난 학기</button>
				</div>
			</form>

			<form method="GET" action="games_filtered_id.php">
				<div class="w3-container" style="margin-top: 50px;">
					대국 번호를 입력하여 주세요.<br>
					양 끝 대국을 포함합니다.<br>
					<input name="startID" type="number" style="margin-top: 3px;"> ~ <input name="endID" type="number">
					<input type="submit" value="제출">
				</div>
			</form>
		</div>

		<script src="https://www.w3schools.com/lib/w3.js"></script>
		<script>
			w3.includeHTML();

			document.getElementById('start').value = "<?=date("Y-m-d")?>";
			document.getElementById('end').value = "<?=date("Y-m-d")?>";

			function w3_open() {
					document.getElementById("mySidebar").style.display = "block";
			}

			function w3_close() {
					document.getElementById("mySidebar").style.display = "none";
			}

			function firstgame() {
				document.getElementById("start").value = "2014-04-05";
			}

			function yesterday() {
				document.getElementById("start").value = "<?=date("Y-m-d", strtotime("-1 day"))?>";
				document.getElementById('end').value = "<?=date("Y-m-d")?>";
			}

			function week() {
				document.getElementById("start").value = "<?=date("Y-m-d", strtotime("-6 day"))?>";
				document.getElementById('end').value = "<?=date("Y-m-d")?>";
			}

			function month() {
				document.getElementById("start").value = "<?=date("Y-m-d", strtotime("-1 month"))?>";
				document.getElementById('end').value = "<?=date("Y-m-d")?>";
			}

			function this_semester() {
				document.getElementById("start").value = "2018-06-18";
				document.getElementById('end').value = "<?=date("Y-m-d")?>";
			}

			function last_semester() {
				document.getElementById("start").value = "2018-02-26";
				document.getElementById("end").value = "2018-06-17";
			} // better need an algorithm for these two... or maybe not
		</script>
	</body>
</html>


