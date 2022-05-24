<!DOCTYPE HTML>
<!--
	Solid State by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
--> 
<?php
require_once("include/gpsvars.php");
require_once("include/configure.php");
require_once("include/db_func.php");
require_once("htmlpurifier/library/HTMLPurifier.auto.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$db_conn->exec("SET CHARACTER SET utf8");
$db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
session_start();
$ErrMsg = '';
if(!isset($_SESSION['mforgetID']))echo "<script> {window.alert('請重新寄送郵件');location.href='mforget.php'} </script>";
$forgetID=$_SESSION['mforgetID'];
//if (isset($PWD) && !isset($ReGen)) $PWD = "";
if(isset($Submit) && isset($vCode)){
	$VerifyCode = $_SESSION['VerifyCode'];
	if($vCode<>$VerifyCode){
		$ErrMsg = '驗證碼錯誤!';
	}
}

	if($PWD<>$REPWD)
	{
		$ErrMsg = '密碼錯誤!';
	}
	if (!preg_match("/^[A-Za-z0-9]*$/",$PWD)) {
        $ErrMsg .= "密碼有不合法輸入"; 
    }
	if(isset($Submit) && empty($ErrMsg))
	{
		$PWD=sha1($PWD);
		$sqlcmd="UPDATE muserLP SET password='$PWD' WHERE loginid='$forgetID'";
		$result = updatedb($sqlcmd, $db_conn);
		unset($_SESSION['mforgetID']);
		echo "<script> {window.alert('修改成功');location.href='mlogin.php'} </script>";
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
				<a class="a" href="#">租借</a>
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
				<li><a href="javascript:;">
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
                <h2>重新輸入密碼</h2>
                
				<div class="login_box">
                    <input type="password" name="PWD" id="demo-email" value="<?php echo $PWD?>" >
                    <label>請輸入新密碼</label>
                </div>
				<div class="login_box">
                    <input type="password" name="REPWD" id="demo-email" value="<?php echo $REPWD?>" >
                    <label>再次輸入密碼</label>
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
					<input type="submit" name="Submit" value="送出" class="primary" />
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