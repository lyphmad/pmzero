<!DOCTYPE html>
<html>
	<title>UNIST 마작 소모임 ±0</title>
	<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="w3.css">

	<body onload="date_checked()">
		<div w3-include-html="menubar.html"></div>

		<div class="w3-main" style="margin-left:200px">
			<div class="w3-card" style="background-color: #001c54; color: white" scrolling="NO">
				<button class="w3-button w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
				<div class="w3-container">
					<h1> 조건 지정 </h1>
				</div>
			</div>

			<form method="GET" action="ranking.php">
				<div style="margin-top:10px; margin-left:10px; margin-right:10px;">
					<b> 최소 경기: </b><input type="text" name="minimum" placeholder="0"> <br> <br>
					기간 내의 총 대국 수가 설정값 이상인 회원간의 경기만 표시합니다.<br>
					<div style="color:red;"> 검색 후에 표시되는 회원 간의 경기 수는 설정값보다 작을 수 있습니다. </div> <br>

					<b> 반영 기간 </b><br><br>
					<input type="radio" name="filter_type" value="date" onclick="date_checked()" checked> 날짜로 <br>
					<input id="start" name="start" type="date" style="margin-top: 3px;"> ~ <input id="end" name="end" type="date"> <br>

					<button type="button" onclick="yesterday()" style="margin-top: 10px;">어제부터</button>
					<button type="button" onclick="week()" style="margin-top: 10px;">1주</button>
					<button type="button" onclick="month()" style="margin-top: 10px;">1개월</button>
					<button type="button" onclick="year()" style="margin-top: 10px;">1년</button>
					<button type="button" onclick="firstgame()" style="margin-top: 10px;">첫 경기부터</button> <br>

					<button type="button" onclick="last_semester()" style="margin-top: 10px;">지난 학기</button>
					<button type="button" onclick="this_semester()" style="margin-top: 10px;">이번 학기</button><br><br><br>

					<input type="radio" name="filter_type" value="ID" onclick="ID_checked()"> 대국 번호로 <br>
					양 끝 대국을 포함합니다.<br>
					<input id="startID" name="startID" type="number" style="margin-top: 3px;"> ~ <input id="endID" name="endID" type="number"> <br>
					<input type="submit" value="제출" style="margin-top: 20px;">
				</div>
			</form>
		</div>

		<script src="https://www.w3schools.com/lib/w3.js"></script>
		<script>
			w3.includeHTML();

			document.getElementById('start').value = "2014-04-05";
			document.getElementById('end').value = "<?=date("Y-m-d")?>";

			function ID_checked() {
				document.getElementById("start").disabled = true;
				document.getElementById("end").disabled = true;

				document.getElementById("startID").disabled = false;
				document.getElementById("endID").disabled = false;
			}

			function date_checked() {
				document.getElementById("start").disabled = false;
				document.getElementById("end").disabled = false;

				document.getElementById("startID").disabled = true;
				document.getElementById("endID").disabled = true;
			}

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

			function year() {
				document.getElementById("start").value = "<?=date("Y-m-d", strtotime("-1 year"))?>";
				document.getElementById('end').value = "<?=date("Y-m-d")?>";
			}

			/* this_semester, last_semester
			 * We need to update these value manually at the start of each semester.
			 * This dates are determined by university policy,
			 * so these cannot (?) be implemented with automated algorithm. */

			function this_semester() {
				document.getElementById("start").value = "2019-09-01";
				document.getElementById('end').value = "2020-02-29";
			}

			function last_semester() {
				document.getElementById("start").value = "2019-02-25";
				document.getElementById("end").value = "2019-08-31";
			}
		</script>
	</body>
</html>


