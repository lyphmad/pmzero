<!DOCTYPE html>
<html>
	<title>UNIST 마작 소모임 ±0</title>
	<meta name="viewport" charset="utf-8" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="w3.css">

	<body>
		<div w3-include-html="menubar.html"></div>

		<div class="w3-main" style="margin-left:200px">
			<div style="background-color: #001c54; color: white" scrolling="NO">
				<button class="w3-button w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
				<div class="w3-container" style="padding-left: 10px;">
					<h1>역만 입력</h1>
				</div>
			</div>

            <?php
            // Create connection
            $conn = new mysqli("localhost", "ubuntu", "", "pmzero");
            // Check connection
            if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
            }

            $gameID = $_GET['id'];
            
            $results = $conn->query("SELECT 1stName, 2ndName, 3rdName, 4thName FROM Games WHERE gameID = $gameID;");
            if($rowitem = $results->fetch_array()) {
                $names = array($rowitem['1stName'], $rowitem['2ndName'], $rowitem['3rdName'], $rowitem['4thName']);
            }

            $conn->close();
            ?>
            <form method="POST" action="chicken.php" enctype="multipart/form-data">
                <input name="id" value="<?=$gameID?>" hidden>

                <div class="row">
                    <div class="w3-container w3-cell" style="padding-right: 50px;"><h3>화료자</h3></div>
                    <div class="w3-container w3-cell">
                        <select name="maker" autocomplete="off" required>
                            <option selected value="<?=$names[0]?>">1위: <?=$names[0]?></option>
                            <option value="<?=$names[1]?>">2위: <?=$names[1]?></option>
                            <option value="<?=$names[2]?>">3위: <?=$names[2]?></option>
                            <option value="<?=$names[3]?>">4위: <?=$names[3]?></option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="w3-container w3-cell" style="padding-right: 50px;"><h3>화료 역</h3></div>
                    <div class="w3-container w3-cell w3-mobile">
                        <input name="type" class="w3-input" type="text" placeholder="종류" list="type_list" required autocomplete="off">
                        <datalist id="type_list">
                            <option value="구련보등">
                            <option value="순정구련보등">
                            <option value="국사무쌍">
                            <option value="국사무쌍 13면대기">
                            <option value="녹일색">
                            <option value="대삼원">
                            <option value="대칠성">
                            <option value="소사희">
                            <option value="대사희">
                            <option value="소차륜">
                            <option value="대차륜">
                            <option value="스깡쯔">
                            <option value="스안커">
                            <option value="십삼불탑">
                            <option value="인화">
                            <option value="자일색">
                            <option value="지화">
                            <option value="천화">
                            <option value="청노두">
                            <option value="팔연장">
                            <option value="헤아림 역만">
                        </datalist>
                    </div>
                </div>

                <div class="row">
                    <div class="w3-container w3-cell" style="padding-right: 50px;"><h3>비고</h3></div>
                    <div class="w3-container w3-cell w3-mobile">
                        <input name="remarks" class="w3-input" placeholder="헤아림 역만 상세, 관전자, 방총자 등 특기사항">
                    </div>
                </div>
                
                <div class="row">
                    <div class="w3-container w3-cell" style="padding-right: 50px;"><h3>사진 업로드</h3></div>
                    <div class="w3-container w3-cell w3-mobile">
                        <input name="photo[]" type="file" multiple>
                    </div>
                </div>

                <div class="row">
                    <div class="w3-container w3-row-padding">
                        <input name="bought" class="w3-check" type="checkbox"><label style="padding-left:5px;">정산 완료</label>
                    </div>
                </div>
				
				<div class="row" style="height: 200px;">
					<div class="w3-container w3-row-padding">
						<input id="submit" class="w3-button w3-border" type="submit" value="입력">
					</div>
				</div>
            </form>
        </div>

        <style>			
            .w3-container {
                vertical-align: middle;
            }

            .row {
                padding-top: 20px;
                padding-left: 20px;
                padding-right: 20px;
            }
        </style>

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