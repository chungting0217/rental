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
	$Login=$_SESSION['LoginID'];
	$sqlcmd = "SELECT * FROM userLP WHERE loginid='$Login'";
	$rs = querydb($sqlcmd, $db_conn);
	$Aid=$rs[0]['Aid'];

	
?>
<html>
	<head>
		<title> 運動館 </title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="css1/reset.css" /> 
		<link rel="stylesheet" href="css/all.css" /> 
		<link rel="stylesheet" href="css1/base.css" /> 
		<link rel="stylesheet" href="css1/filter.css" /> 
		<link rel="stylesheet" href="css1/re1.css" /> 
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
		<style>

.modal-header h3 {
font-size: 30px;
color: black;
/* 置中 */
position: absolute;
top:14%;
left: 50%;
transform: translate(-50%, -50%);
}
.modal-body form .btn {
width: 90%;
font-size: 25px;
color: white;
background:#424141;
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
		<div class="filter"> 
			
		</div>

		<script src="assets/js/jquery.min.js"></script>
		<script>
			$(function(){
				$(".checkme").click(function(event){
					var x=$(this).is(':checked');
					if(x==true){
						$(this).parents(".filter").find('.add-filter').show();
					}
					else
					{
						$(this).parents(".filter").find('.add-filter').hide();
					}
				});
			})
		</script>
		<div class="ad">
			 <span>預約日期</span>
			 <span>名稱</span>
			 <span>地址</span>
			 <span>電話</span>
			 <span>預約運動</span>
			<span>預約時間</span>
			
		</div>
		
		 <?php
		 	$n=0;
		 	$sql = "SELECT * FROM spacereserve WHERE Aid='$Aid'";
			 $rows = querydb($sql, $db_conn);
			foreach($rows as $row)
			{
				$sportid=$row['sportid'];
				$time=$row['time'];
				$sid=$row['sid'];
				$date=$row['date'];
				$category=$row['category'];
				if($category==1)
				{
					$sqli = "SELECT * FROM spaces WHERE sid='$sid'";
					$r = querydb($sqli, $db_conn);
					$sname=$r[0]['sname'];
					$caddress=$r[0]['caddress'];
					$address=$r[0]['address'];
					$sphone=$r[0]['sphone'];
					$sqli = "SELECT * FROM spacessport WHERE sportid='$sportid'";
					$r = querydb($sqli, $db_conn);
					$sport=$r[0]['sport'];
				}
				else if($category==2)
				{
					$sqli = "SELECT * FROM specialspaces WHERE sid='$sid'";
					$r = querydb($sqli, $db_conn);
					$sname=$r[0]['sname'];
					$caddress=$r[0]['caddress'];
					$address=$r[0]['address'];
					$sphone=$r[0]['sphone'];
					$sqli = "SELECT * FROM specialspacessport WHERE sportid='$sportid'";
					$r = querydb($sqli, $db_conn);
					$sport=$r[0]['sport'];
				}

				echo'<div class="administrate">';
				echo'<div class="text">';
				echo'<div class="dates">'.$date.'</div>';
				echo'<span>'.$sname.'</span>';
				echo'<span>'.$caddress.$address.'</span>';
				echo'<span>'.$sphone.'</span>';
				echo'<span>'.$sport.'</span>';
				echo'<span>'.$time.'</span>';
				
				
				echo'<a href="delete.php?sid='.$sid.'&Aid='.$Aid.'&sportid='.$sportid.'&time='.$time.'&category='.$category.'">取消預約</a>';
				

				echo'</div>';
				echo'</div>';
			
			}
			
		 ?>
		 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
			<script>
				$(document).ready(function() 
				{
					setInterval(function () {
						$("#autodata").load("update.php");
						refresh();
					},10000);
				});
			</script>

			<div id="autodata"></div>
	</body>
</html>