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


if (!isset($mName)) $mName = '';

if (!isset($mPhone)) $mPhone = '';

if (!isset($Email)) $Email = '';
if (!isset($PWD)) $PWD = '';
$ErrMsg='';

if (isset($Confim)){

 
    $mName = mb_substr($mName, 0, 40, "utf-8");
    $Email = mb_substr($Email, 0, 40, "utf-8");

    
    if (empty($mName)) $ErrMsg .= '姓名不可為空白\n';
    if (!preg_match("/^[\w]*$/",$mName)) {
        $ErrMsg .= '姓名有不合法輸入\n'; 
    }
   
    $mName = htmlspecialchars($mName); 

    
    
    if (empty($mPhone)) $ErrMsg .= '電話不可為空白\n';
    $p ='/^[0][1-9]{1,3}[0-9]{6,8}$/';
	if(!preg_match($p,$mPhone))$ErrMsg .= '電話內容錯誤\n';

    if (empty($Email)) $ErrMsg .= '信箱不可為空白\n';
    
    $Email = htmlspecialchars($Email);

    if (empty($PWD)) $ErrMsg .= '密碼不可為空白\n';
    if (!preg_match("/^[A-Za-z0-9]*$/",$PWD)) {
        $ErrMsg .= "密碼有不合法輸入"; 
    }
    $sqlcmd="SELECT * FROM manager WHERE email = '$Email'";
    $rs = querydb($sqlcmd, $db_conn);
    if(count($rs)>0)$ErrMsg.= '此email已使用過了';
	//echo "<script> {window.alert('修改成功1');} </script>";
    if(empty($ErrMsg)){
        $sqlcmd='INSERT INTO manager (Aid,username,userphone,email) VALUES ('
			."?,?,?,?)";
			
        $rs = $db_conn->prepare($sqlcmd);
        
        $rs->execute(array($uid,$mName,$mPhone,$Email));
        //echo "<script> {window.alert('修改成功1');} </script>";
        //$sqlcmd="SELECT * FROM account WHERE name = '$Name' AND email = '$Email' ";
        //$rs = querydb($sqlcmd, $db_conn);
        // if(count($rs)>0){
            //$uid = $rs[0]['id'];
        $uid = $db_conn->lastInsertId();
        $sqlcmd='INSERT INTO muserLP (Aid,loginid, password) VALUES ('
        ."?,?,?)";
        $rs = $db_conn->prepare($sqlcmd);
        $rs->execute(array($uid,$Email,sha1($PWD)));
        
        $sqlcmd="UPDATE manager SET Aid='$uid' WHERE email='$Email'";
        $result = updatedb($sqlcmd, $db_conn);
        //}else{
        //    $ErrMsg = '註冊失敗請稍後再試或聯絡開發人員';
        //}
        $Name ='';
        $mName ='';
        $Phone ='';
        $mPhone ='';
        $Email='';
        $Address ='';
        $PWD ='';
       
        echo "<script> {window.alert('註冊成功');location.href='mlogin.php'} </script>";

        //header("Location: login.php");
        exit();
    }
}
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
                <h2>管理員註冊</h2>
				

				<div class="login_box">
				<input type="text" name="mName" id="mname" value="<?php echo $mName?>"/>
				<label>管理人員名稱:</label>
                </div>
				<div class="login_box">
				<input type="tel" id="telNo" name="mPhone" placeholder="09xxxxxxxx" minlength="10" maxlength="10" value="<?php echo $mPhone?>">
				<label >管理人員電話:</label>
                </div>
                <div class="login_box">
				
                	<input type="email" id="email" name="Email" value="<?php echo $Email?>">
					<label>信箱</label>
                </div>
                <div class="login_box">
				<input type="password" id="password" name="PWD">
                    <label>密碼</label>
                </div>
				
				
				
					<!-- <input type="submit" name="Submit" value="登入" class="primary" /> -->
                <!-- <a >
				
                    登入
                </a>-->
				<div>
				<input type="submit" name="Confim" value="註冊" class="primary" /> 
				</div>
				
            </div>
        </div>
		</form>	
		<script src="assets/js/jquery.min.js"></script>
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