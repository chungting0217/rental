<!DOCTYPE HTML>
<!--
	Solid State by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
--> 
<?php
session_start();
require_once("include/gpsvars.php");
require_once("include/configure.php");
require_once("include/db_func.php");
require_once("htmlpurifier/library/HTMLPurifier.auto.php");

$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$db_conn->exec("SET CHARACTER SET utf8");
$db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


if (!isset($loginid)) $loginid = "";
$loginid=$_SESSION['MLoginID'];
echo $loginid;
$ErrMsg='';
if(!isset($OPWD))
$OPWD=$_POST['PWD'];
if(isset($Giveup)){
	header("Location: index.php");
}
if (isset($Confim)){
	$NPWD=$_POST['NPWD'];
    $username = mb_substr($username, 0, 40, "utf-8");
    $email = mb_substr($email, 0, 40, "utf-8");
	
	
    if (empty($username)) $ErrMsg .= '姓名不可為空白\n';
	if (preg_match('/[\x{4e00}-\x{9fa5}]|[a-zA-Z]+/u',$username)) {
        
		if(preg_match("/[ '.,:;*?~'!@#$%^&-=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$username)){
			$ErrMsg .= '姓名有不合法輸入\n'; 
			}
    }
    // if (!preg_match("/^[\w]*$/",$username)) {
    //     $ErrMsg .= "姓名有不合法輸入\n"; 
    // }
    $username = htmlspecialchars($username); 

    
    if (empty($userphone)) $ErrMsg .= '電話不可為空白\n';
    $p ='/^09[0-9]{8}$/';
	if(!preg_match($p,$userphone))$ErrMsg .= '電話內容錯誤\n';
    
    if (empty($email)) $ErrMsg .= 'Email不可為空白\n';
    
    $email = htmlspecialchars($email);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL))$ErrMsg = 'email格式錯誤\n';
	
    //if (empty($PWD)) $ErrMsg .= '密碼不可為空白\n';
    //if (!preg_match("/^[A-Za-z0-9]*$/",$PWD)) {
       // $ErrMsg .= "密碼有不合法輸入"; 
    //}
	if (!preg_match("/^[A-Za-z0-9]*$/",$NPWD)) {
        $ErrMsg .= "密碼有不合法輸入"; 
    }
	echo $ErrMsg;
    if(empty($ErrMsg)){
		
        if (!get_magic_quotes_gpc()) {
            $username = addslashes($username);
			$userphone = addslashes($userphone);

            
			$email = addslashes($email);
            
        }
		$sqlcmd="UPDATE manager SET username='$username',userphone='$userphone' WHERE email='$loginid'";
        
		echo $sqlcmd;
		$result = updatedb($sqlcmd, $db_conn);
		
		
		if($NPWD=="")
		{
			echo "<script> {window.alert('修改成功');location.href='index.php'} </script>";
		}
		else
		{
			$NPWD=sha1($NPWD);
			$sqlcmd="UPDATE muserLP SET password='$NPWD' WHERE loginid='$loginid'";
		$result = updatedb($sqlcmd, $db_conn);
		echo "<script> {window.alert('修改成功');location.href='index.php'} </script>";
		}
		//echo "<script> {window.alert('$PWD');} </script>";
		//echo "<script> {window.alert('$NPWD');} </script>";
		//echo "<script> {window.alert('$PWD');location.href='temp.php'} </script>";
        //echo "<script> {window.alert('修改成功');location.href='temp.php'} </script>";

       
        //exit();
    }
}
	if (!isset($Name)) {    

		$sqlcmd = "SELECT * FROM manager WHERE email='$loginid'";
		$rs = querydb($sqlcmd, $db_conn);
		
		//if (count($rs) <= 0) die('No data found');      // 找不到資料，正常應該不會發生
		$username = $rs[0]['username'];
		$userphone = $rs[0]['userphone'];
		$email = $rs[0]['email'];
		
		
		$sqlcmd = "SELECT * FROM muserLP WHERE loginid='$loginid'";
		$rs = querydb($sqlcmd, $db_conn);
		$PWD=$rs[0]['password'];
		//$OPWD=$PWD;
		$Aid=$rs[0]['Aid'];
		
	} else {    // 點選送出後，程式發現有錯誤
	// Demo for stripslashes
		if (get_magic_quotes_gpc()) {
			$username = stripslashes($username);
			$userphone = stripslashes($userphone);
			$email = stripslashes($email);

		}
	}
	$ErrMsg='';

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
    .login .login_box label,
.login .login_box label{
    top: -20px;
    color: #03e9f4;
    font-size:12px;
}
		</style>
	</head>
	<body class="cbody">
		<div id="header" class="alt">
			<div class="logo"><a href="index.php"><img src="image/LOGO.png"></a></div>
		</div>

		<div calss="nva-top">
		<ul class="top-nva">
		<?php
			if(isset($_SESSION['MLoginID']))
			{
				echo'<li>
				<a class="a" href="managersmodify.php">管理員資料</a>
				</li>';
				echo'<li>
				<a class="a" href="new.php">新增場館</a>
				</li>';
				echo'<li>
				<a class="a" href="examine.php">查看預約</a>
				</li>';
				echo'<li>
				<a class="a" href="managespace.php">管理場館</a>
				</li>';

			}
			else
			{
				
				echo'<li>
				<a class="a" href="video.php">推薦影片</a>
				</li>';
				echo'<li>
				<a class="a" href="index.php">租借</a>
				</li>';
				echo'<li>
				<a class="a" href="allsportsearch.php">全台運動館</a>
				</li>';
			}
			?>
			<!-- <li>
				<a class="a" href="#">運動資訊</a>
			</li>
			<li>
				<a class="a" href="#">推薦影片</a>
			</li>
			<li>
				<a class="a" href="#">租借</a>
			</li>
			<li>
				<a class="a" href="allsportsearch.php">全台運動館</a>
			</li> -->
			<?php
			if(isset($_SESSION['LoginID'])||isset($_SESSION['MLoginID']))
			{
				echo'<li>
				<a class="a" href="logout.php">登出</a>
			</li>';
			}
			else
			{
				echo'<li>
				<a class="a" href="loginorsign.php">登入和註冊</a>
			</li>';
			}
			?>
			<!-- <li>
				<a class="a" href="loginorsign.php">登入和註冊</a>
			</li> -->
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
				<?php
					if(isset($_SESSION['LoginID']))
					{
						echo'<li><a href="modify.php"><i class="fas fa-user-cog"></i>
						<span>會員資料修改</span>
						</a></li>';
						echo'<li><a href="order.php"><i class="fab fa-elementor"></i>
						<span>預約紀錄</span>
						</a></li>';
					}
					
				?>
				<?php
			if(isset($_SESSION['MLoginID']))
			{
				echo'<li>
					<a href="managersmodify.php">
					<i class="fas fa-user-cog"></i>
					<span>管理員資料</span>
					</a></li>';
				echo'<li>
					<a href="new.php">
					<i class="fab fa-youtube"></i>
					<span>新增場館</span></a>
					</li>';
					echo'<li>
					<a href="examine.php">
					<i class="fas fa-sort-amount-up"></i>
						<span>查看預約</span>
						</a>
					</li>';
				echo'<li>
				<a href="managespace.php">
					<i class="fa fa-home"></i>
					<span>管理場館</span>
					</a>
				</li>';
				

			}
			else
			{
				
				echo'<li>
					<a href="video.php">
					<i class="fab fa-youtube"></i>
					<span>推薦影片</span>
					</a>
				</li>';
				echo'<li>
					<a href="index.php">
					<i class="fa fa-home"></i>
					<span>租借</span>
					</a>
				</li>';
				echo'<li>
					<a href="allsportsearch.php">
					<i class="fa fa-running"></i>
					<span>全台運動館</span>
					</a>
				</li>';
			}
			?>
				<!-- <li><a href="javascript:;">
					<i class="fa fa-home"></i>
					<span>運動資訊</span>
					</a>
				</li>
				<li><a href="javascript:;">
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
				</li> -->
				<?php
					if(isset($_SESSION['LoginID'])||isset($_SESSION['MLoginID']))
					{
						echo'<li><a href="logout.php"><i class="fa fa-user"></i>
						<span>登出</span>
						</a></li>';
					}
					else
					{
						echo'<li><a href="loginorsign.php">
		
						<i class="fa fa-user"></i>
						<span>登入和註冊</span>
						</a>
					</li>';
					}
				?>
				<!-- <li><a href="loginorsign.php">
		
					<i class="fa fa-user"></i>
					<span>登入和註冊</span>
					</a>
				</li> -->
				
			</ul>
		</div>
		<form method="post" action="">
        <div class="sbody">
            <div class="login">
                <h2>管理員資料</h2>
				
				<div class="login_box">
                    <input type="text" name="username" id="username" value="<?php echo $username ?>"/>
					<label>管理者名稱</label>
                </div>
				
				<div class="login_box">
                                <input type="text" id="userphone" name="userphone" placeholder="09xxxxxxxx" minlength="10" maxlength="10" value="<?php echo $userphone ?>">
								<label>電話</label>
                            </div>
							
                <div class="login_box">
				
                	<input type="text" id="email" name="email" readonly="readonly" value="<?php echo $email ?>">
					<label>管理者email</label>
					<!-- <label><?php echo $email?></label> -->
                </div>
                <div class="login_box">
				<input type="password" id="password" name="NPWD">
                    <label>新密碼</label>
                </div>
				
				
				
					<!-- <input type="submit" name="Submit" value="登入" class="primary" /> -->
                <!-- <a >
				
                    登入
                </a>-->
				<div>
				<input type="submit" name="Confim" value="修改" class="primary" /> 
				</div>
				<div>
				<input type="submit" name="Giveup" value="放棄修改">
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