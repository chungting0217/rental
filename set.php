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
session_start(); 
$conf = HTMLPurifier_Config::createDefault();
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$db_conn->exec("SET CHARACTER SET utf8");
$db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$weektime=$_SESSION['weektime'];
$sname=$_SESSION['sname'];

if(isset($confim))
{
	$monday=$_POST['monday'];
	$time= count($monday);
	$allsport=array(1=>'排球',2=>'羽球',3=>'籃球',4=>'撞球',5=>'高爾夫球',6=>'桌球',7=>'壁球',8=>'游泳池',9=>'健身房',10=>'網球');
	$allsportarr=array(1=>'volley[]',2=>'badminton[]',3=>'basketball[]',4=>'snooker[]',5=>'golf[]',6=>'billiards[]',7=>'squash[]',8=>'pool[]',9=>'gym[]',10=>'tennis[]');
	for($i=1;$i<=7;$i++)
	{
		 $date=$date = date( "Y/m/d", strtotime($weektime.$i) );
	 	 $sqlcmd = "SELECT * FROM spaces WHERE date='$date' AND sname='$sname'";
	 	 $rs = querydb($sqlcmd, $db_conn);
	 	 $sid=$rs[0]['sid'];
		  $sqlcmds = "SELECT * FROM spacessport WHERE sid='$sid'";
		  $rss = querydb($sqlcmds, $db_conn);
		  foreach($rss as $r)
		  {
			$sportid=$r['sportid'];
			$sport=$r['sport'];
			$rsqlcmd='INSERT INTO spacetime (sid,sportid,name,time,people,limitpeople) VALUES ('
	 	 ."?,?,?,?,?,?)";
		  $result = $db_conn->prepare($rsqlcmd);
			for($k=0;$k<count($allsport);$k++)
					{
						if($sport==$allsport[$k])
						$th=$k;
					}
			if($th==1)
			{
				for($k=0;$k<count($volley);$k++)
				{
					$result->execute(array($sid,$sportid,$sname,$volley[$k],$people1,$people1));
				}
			}
			if($th==2)
			{
				for($k=0;$k<count($badminton);$k++)
				{
					$result->execute(array($sid,$sportid,$sname,$badminton[$k],$people2,$people2));
				}
			}
			if($th==3)
			{
				for($k=0;$k<count($basketball);$k++)
				{
					$result->execute(array($sid,$sportid,$sname,$basketball[$k],$people3,$people3));
				}
			}
			if($th==4)
			{
				for($k=0;$k<count($snooker);$k++)
				{
					$result->execute(array($sid,$sportid,$sname,$snooker[$k],$people4,$people4));
				}
			}
			if($th==5)
			{
				for($k=0;$k<count($golf);$k++)
				{
					$result->execute(array($sid,$sportid,$sname,$golf[$k],$people5,$people5));
				}
			}
			if($th==6)
			{
				for($k=0;$k<count($billiards);$k++)
				{
					$result->execute(array($sid,$sportid,$sname,$billiards[$k],$people6,$people6));
				}
			}
			if($th==7)
			{
				for($k=0;$k<count($squash);$k++)
				{
					$result->execute(array($sid,$sportid,$sname,$squash[$k],$people7,$people7));
				}
			}
			if($th==8)
			{
				for($k=0;$k<count($pool);$k++)
				{
					$result->execute(array($sid,$sportid,$sname,$pool[$k],$people8,$people8));
				}
			}
			if($th==9)
			{
				for($k=0;$k<count($gym);$k++)
				{
					$result->execute(array($sid,$sportid,$sname,$gym[$k],$people9,$people9));
				}
			}
			if($th==10)
			{
				for($k=0;$k<count($tennis);$k++)
				{
					$result->execute(array($sid,$sportid,$sname,$tennis[$k],$people10,$people10));
				}
			}
		  }
	 	
		
	}
	
	echo "<script> {window.alert('成功');location.href='setimg.php'} </script>";

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
		<link rel="stylesheet" href="css1/allsport.css" /> 
		<link rel="stylesheet" href="css1/space1.css" /> 
		<link rel="stylesheet" href="css1/checkbox.css" /> 
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<style>
	
	.update
{
	margin-left: 50%;
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
				
			</ul>
		</div>

		<div class="next">
			<a href="#"><label class="one">新增場館</label></a>
			<div class="arrow-6"></div>
			<a href="#"><label class="two">設定</label></a>
			<div class="arrow-7"></div>
			<a href="#"><label class="three">完成</label></a>
		</div>
		<!-- 新增場館 -->
		<div class="add-space">
			<form  enctype="multipart/form-data" action="" method="POST">
				<?php
				$weektime=$_SESSION['weektime'];
				$date=$date = date( "Y/m/d", strtotime($weektime."1") );
					$sqlcmd = "SELECT * FROM spaces WHERE date='$date' AND sname='$sname'";
					$rs = querydb($sqlcmd, $db_conn);
					$sid=$rs[0]['sid'];
					$allsport=array(1=>'排球',2=>'羽球',3=>'籃球',4=>'撞球',5=>'高爾夫球',6=>'桌球',7=>'壁球',8=>'游泳池',9=>'健身房',10=>'網球');
					$allsportarr=array(1=>'volley[]',2=>'badminton[]',3=>'basketball[]',4=>'snooker[]',5=>'golf[]',6=>'billiards[]',7=>'squash[]',8=>'pool[]',9=>'gym[]',10=>'tennis[]');
					$peoples=array(1=>'people1',2=>'people2',3=>'people3',4=>'people4',5=>'people5',6=>'people6',7=>'people7',8=>'people8',9=>'people9',10=>'people10');
					$sqlcmd = "SELECT * FROM spacessport WHERE sid='$sid'";
					$rs = querydb($sqlcmd, $db_conn);
					foreach($rs as $rss)
					{
						
						$sport=$rss['sport'];
						for($k=0;$k<count($allsport);$k++)
					{
						if($sport==$allsport[$k])
						$th=$k;
					}
					$names=$allsportarr[$th];
					$pname=$peoples[$th];
						echo'<div class="addspace"><label>'.$sport.'開放時段:</label></div>';
						echo'<div class="addspace">';
						echo'<label>每個時段租借次數/人數:</label>';
						echo'<select name="'.$pname.'">';
						for($j=1;$j<100;$j++)
						echo'<option value="'.$j.'">'.$j.'</option>';
						echo'</select>';
						echo'</div>';
						echo'<div class="contain">';
						$weektime=$_SESSION['weektime'];
					// $weektime='2021-W37';
						$date=$date = date( "Y/m/d", strtotime($weektime."1") );
						$sname=$_SESSION['sname'];
					// $sname='曹仲';
						$sqlcmd = "SELECT * FROM spaces WHERE date='$date' AND sname='$sname'";
						$rs1 = querydb($sqlcmd, $db_conn);
						$start=$rs1[0]['start'];
						$end=$rs1[0]['end'];
					
					
					$total=(strtotime($end)-strtotime($start))/60*60;
					$time=date('H', $total);

					$times = strtotime($start) + 60*60;
					$times = date('H:i', $times);
					$first=$start;
					
					
					for($i=1;$i<=$time;$i++)
					{
						$times = strtotime($first) + 60*60;
						$second = date('H:i', $times);
						$value=$first.'-'.$second;
						echo'<div class="timecheck">';
						echo'<label>';
						echo'<input type="checkbox" name="'.$names.'" value="'.$value.'">';
						echo'<span>'.$value.'</span>';
						echo'</label>';
						echo'</div>';
						$first=$second;
					}
						echo'</div>';

					}
				
				//echo'';
				// $weektime='2021-W37';
				
				
				?>
				
				<div class="addspace">
					<input type="submit" name="confim" value="下一步">
				</div>
				
			</form>
			



		</div>
		
		
		<!-- Scripts -->
			<!-- 
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script> -->

	</body>
</html>