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
	$MLogin=$_SESSION['MLoginID'];
	$sqlcmd = "SELECT * FROM muserLP WHERE loginid='$MLogin'";
	$rs = querydb($sqlcmd, $db_conn);
	$mid=$rs[0]['Aid'];
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
		<link rel="stylesheet" href="css1/show.css" /> 
		<link rel="stylesheet" href="css1/mbar.css" /> 
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<style>



		</style>
		<?php
		
		?>
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
		
		<div class="filter"> 
			
		</div>
		<div class="mbar">
			<ul>
				<?php
				$sid=$_GET['sid'];
				$sportid=$_GET['sportid'];
				$time=$_GET['time'];
				$category=$_GET['category'];
				echo'<li><a href="view.php?sportid='.$sportid.'&sid='.$sid.'&time='.$time.'&category='.$category.'">未繳費</a></li>';
				echo'<li><a href="checkview.php?sportid='.$sportid.'&sid='.$sid.'&time='.$time.'&category='.$category.'" style="background-color: #3F3F3F; color: #E8E7E3;">已繳費</a></li>';
				?>
				
			  </ul>
		</div>
		<div class="show_s">
			<span>預約人</span>
			 <span>預約時間</span>
			 <span>預約運動</span>
			 <span>連絡電話</span>
		</div>
		
		 <?php
		 	$sid=$_GET['sid'];
			$sportid=$_GET['sportid'];
			$time=$_GET['time'];
			$category=$_GET['category'];
			if($category==1)
			{
				$sql="SELECT * FROM payment WHERE sid='$sid' AND sportid='$sportid' AND time='$time' AND category='$category'";
				$rows = querydb($sql, $db_conn);
				foreach($rows as $row)
				{
				   $Aid=$row['Aid'];
				   $sql="SELECT * FROM memberaccount WHERE id='$Aid' ";
				   $r = querydb($sql, $db_conn);
				   $name=$r[0]['name'];
				   $phone=$r[0]['phone'];
				   $sql="SELECT * FROM spacessport WHERE sportid='$sportid' ";
				   $r = querydb($sql, $db_conn);
				   $sport=$r[0]['sport'];
   
				   echo'<div class="show" >';
				   echo'<div class="person">';
				echo'<span>'.$name.'</span>';
				echo'<span>'.$time.'</span>';
				echo'<span>'.$sport.'</span>';
				echo'<span>'.$phone.'</span>';
				
				echo'</div>';
				echo'</div>';
   
				   
				}
			}
			if($category==2)
			{
				$sql="SELECT * FROM payment WHERE sid='$sid' AND sportid='$sportid' AND time='$time' AND category='$category'";
				$rows = querydb($sql, $db_conn);
				foreach($rows as $row)
				{
				   $Aid=$row['Aid'];
				   $sql="SELECT * FROM memberaccount WHERE id='$Aid' ";
				   $r = querydb($sql, $db_conn);
				   $name=$r[0]['name'];
				   $phone=$r[0]['phone'];
				   $sql="SELECT * FROM specialspacessport WHERE sportid='$sportid' ";
				   $r = querydb($sql, $db_conn);
				   $sport=$r[0]['sport'];
   
				   echo'<div class="show" >';
				   echo'<div class="person">';
				echo'<span>'.$name.'</span>';
				echo'<span>'.$time.'</span>';
				echo'<span>'.$sport.'</span>';
				echo'<span>'.$phone.'</span>';
				
				echo'</div>';
				echo'</div>';
   
				   
				}
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