<!DOCTYPE HTML>
<!--
	Solid State by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
--> 
<?php
function userauth($ID, $PWD, $db_conn) {
    $sqlcmd = "SELECT * FROM muserLP WHERE loginid='$ID' AND valid='Y'";
    $rs = querydb($sqlcmd, $db_conn);
    $retcode = 0;
    if (count($rs) > 0) {
        $Password = sha1($PWD);
		if ($Password == $rs[0]['password']) $retcode = 1;
		else $retcode = -1;
    }
	
    return $retcode;
}
session_start();
require_once("include/gpsvars.php");
$ErrMsg = '';
if (!isset($ID)) $ID = "";
//if (isset($PWD) && !isset($ReGen)) $PWD = "";
if(isset($Submit) && isset($vCode)){
	$VerifyCode = $_SESSION['VerifyCode'];
	if($vCode<>$VerifyCode){
		$ErrMsg = '驗證碼錯誤!';
	}
}
session_unset();
if (isset($Submit) && empty($ErrMsg)) {
	require ("include/configure.php");
	require ("include/db_func.php");
	$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
	if (strlen($ID) > 0 && strlen($ID)<=50 && $ID==addslashes($ID)) {
		$Authorized = userauth($ID,$PWD,$db_conn);
		if ($Authorized == 1) {
			$sqlcmd = "SELECT * FROM muserLP WHERE loginid='$ID' AND valid='Y'";
			$rs = querydb($sqlcmd, $db_conn);
			if(count($rs) != 0){
				$LoginID = $rs[0]['loginid'];
				$_SESSION['MLoginID'] = $LoginID;
				
				header ("Location: index.php");
			}
			exit();
		}else if($Authorized == -1)
			$ErrMsg .= '密碼錯誤請重新輸入 ';
		else 
			$ErrMsg .=  '查無此帳號 '.$Authorized;
	} else {
		$ErrMsg =  'ID錯誤，您並非合法使用者或是使用權已被停止'.$ID;
	}
	if (empty($ErrMsg)) $ErrMsg = '登入錯誤';
}
$vCode ='';
$_SESSION['VerifyCode'] = mt_rand(1000,9999);
?>

<html>
	<head>
		<title> 運動館 </title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="css1/reset.css" /> 
		<link rel="stylesheet" href="css/all.css" /> 
        <link rel="stylesheet" href="css1/base.css" /> 
        <link rel="stylesheet" href="css1/login.css" /> 
        <link rel="stylesheet" href="css1/logincss.css" /> 
        
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<style>
    
		</style>
	</head>
	<body class="cbody">
		<div id="header" class="alt">
			<div class="logo"><a href="index.php"><img src="image/LOGO.png"></a></div>
		</div>

	<div calss="nva-top">
		<ul class="top-nva">
			
			<li>
				<a class="a" href="video.php">推薦影片</a>
			</li>
			<li>
				<a class="a" href="index.php">租借</a>
			</li>
			<li>
				<a class="a" href="allsportsearch.php">全台運動館</a>
			</li>
			<li>
				<a class="a" href="loginorsign.php">登入和註冊</a>
			</li>
		</ul>
	</div> 

		<div class="navbar">
			<input type="checkbox"  id="checkbox" checked="checked">
			<label for="checkbox">
				<i class="fa fa-outdent"></i></label>
			<ul>
				<li>
					<img src="image/LOGO.png" alt="">
				</li>
				
				<li><a href="video.php">
					<i class="fab fa-youtube"></i>
					<span>推薦影片</span>
					</a>
				</li>
				<li><a href="index.php">
					<i class="fa fa-home"></i>
                
					<span>租借</span>
					</a>
				</li>
				<li><a href="allsportsearch.php">
					<i class="fa fa-running"></i>
					<span>全台運動館</span>
					</a>
				</li>
				<li><a href="loginorsign.php">
		
					<i class="fa fa-user"></i>
					<span>登入和註冊</span>
					</a>
				</li>
				
			</ul>
		</div>
		<form method="post" action="">
        <div class="sbody">
            <div class="login">
                <h2>管理員登入</h2>
                <div class="login_box">
                    <input type="email" name="ID" id="demo-email" value="<?php echo $ID?>" >
                    <label>帳號</label>
                </div>
                <div class="login_box">
                    <input type="password" name="PWD" id="demo-email" value="<?php echo $PWD?>" >
                    <label>密碼</label>
                </div>
				<div class="login_box">
					<input type="text" name="vCode" size="4" maxlength="4" placeholder="四個數字" onkeypress="if (event.keyCode == 13) {return false;}">
					<label>驗證碼</label>
					
				</div>
				
					<img src="images/chapcha.php" style="vertical-align:text-bottom" width ="150" height="60";>
					<input type="submit" name="ReGen"  class="button" value="重新產生" onkeypress="if (event.keyCode == 13) {return false;}">	
				
					<!-- <input type="submit" name="Submit" value="登入" class="primary" /> -->
                <!-- <a >
				
                    登入
                </a>-->
				<div>
					<input type="submit" name="Submit" value="登入" class="primary" />
                <a href="msignup.php">
                    註冊
                </a>
				<a href="mforget.php">
                    忘記密碼
                </a>
			</div>
				
            </div>
        </div>
		</form>	
        <?php 
	if (isset($ErrMsg) && !empty($ErrMsg)) { ?>
	<script type="text/javascript">
		alert('<?php echo $ErrMsg; ?>');
	</script>
	<?php } 
	//require_once ('../include/footer.php');
	?>
		<!-- Page Wrapper -->
			<div id="page">

				<!-- Header -->

				<!-- Menu -->
					<!-- <nav id="menu">
						<div class="inner">
							<h2>Menu</h2>
							<ul class="links">
								<li><a href="index.php">首頁</a></li>
								<li><a href="temp.php">會員專區</a></li>
								<li><a href="memberlogin.php">會員登入</a></li>
								<li><a href="membersignup.php">會員註冊</a></li>
                                <li><a href="managerlogin.php">管理員登入</a></li>
								<li><a href="managersignup.php">管理員註冊</a></li>
								<li><a href="logout.php">登出</a></li>
							</ul>
						</div>
					</nav> -->

				
				
			</div>

		<!-- Scripts -->
			<!-- <script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script> -->

	</body>
</html>