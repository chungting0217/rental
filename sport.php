<!DOCTYPE HTML>

<html>
	<head>
		<title> 運動館 </title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="css1/reset.css" /> 
		<link rel="stylesheet" href="css/all.css" /> 
		<link rel="stylesheet" href="css1/base.css" /> 
		<link rel="stylesheet" href="css1/filter.css" /> 
		<link rel="stylesheet" href="css1/allsport.css" /> 
		<link rel="stylesheet" href="css1/space.css" />
		<link rel="stylesheet" href="css1/sport.css" />  
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>

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
		$ErrMsg='';
		$sqlcmd = "SELECT * FROM muserLP WHERE loginid='$MLogin'";
		$rs = querydb($sqlcmd, $db_conn);
		$Aid=$rs[0]['Aid'];
		$sname=$_SESSION['sname'];
		$telNo=$_SESSION['telNo'];
		$start=$_SESSION['start'];
		$end=$_SESSION['end'];
		$caddress=$_SESSION['caddress'];
		$address=$_SESSION['address'];
		$category=$_SESSION['category'];
		$sid=$_SESSION['sid'];
		
		
		if(!isset($_SESSION['MLoginID'])) echo "<script> {window.alert('請登入');location.href='mlogin.php'} </script>";
		if(isset($confirm))
		{
			if (count($sport)==0)$ErrMsg .= '請至少選擇開放一項運動\n';

			if(empty($ErrMsg))
			{
				$_SESSION['sname']=$sname;
				$_SESSION['telNo']=$telNo;
				$_SESSION['start']=$start;
				$_SESSION['end']=$end;
				$_SESSION['caddress']=$caddress;
				$_SESSION['address']=$address;
				$_SESSION['category']=$category;
				
				if($category==1)
				{
					$sqlcmds = "SELECT * FROM spaces WHERE mid='$Aid' AND sname='$sname' ";
					//echo $sqlcmds;
					$rs = querydb($sqlcmds, $db_conn);
					foreach($rs as $r)
					{

						$ssid=$r['sid'];
						$sqlcmds = "SELECT * FROM spacessport WHERE sid='$ssid'";
						//echo $sqlcmds;
						$rs2 = querydb($sqlcmds, $db_conn);
						foreach($rs2 as $rss)
						{
							$sportid=$rss['sportid'];
							$sqlcmd = "DELETE FROM spacetime WHERE sportid='$sportid'";
							$db_conn->query($sqlcmd);
						}
						$sqlcmd = "DELETE FROM spacessport WHERE sid='$ssid'";
						$db_conn->query($sqlcmd);
						$sqlcmd = "DELETE FROM spacereserve WHERE sid='$ssid' AND category='$category'";
						$db_conn->query($sqlcmd);
						$sqlcmd = "DELETE FROM payment WHERE sid='$ssid' AND category='$category'";
					    $db_conn->query($sqlcmd);
						$sqlcmds='INSERT INTO spacessport (sid,sport) VALUES ('
						."?,?)";
						$rss = $db_conn->prepare($sqlcmds);
						for($j=0;$j<count($sport);$j++)
						{
							$rss->execute(array($ssid,$sport[$j]));
							$nowsport=$sport[$j];
							$sportid = $db_conn->lastInsertId();
							$sqlcmdss="UPDATE spacessport SET sportid='$sportid' WHERE sid='$ssid' AND sport='$nowsport'";
							$result = updatedb($sqlcmdss, $db_conn);
						}
					}
					echo "<script> {window.alert('成功');location.href='sportset.php'} </script>";
				}
				else if ($category==2)
				{
					$sqlcmds = "SELECT * FROM specialspacessport WHERE sid='$sid'";
					$rs2 = querydb($sqlcmds, $db_conn);
					foreach($rs2 as $rss)
					{
					$sportid=$rss['sportid'];
					$sqlcmd = "DELETE FROM specialspacetime WHERE sportid='$sportid'";
					$db_conn->query($sqlcmd);
					}
					
					$sqlcmd = "DELETE FROM specialspacessport WHERE sid='$sid'";
					$db_conn->query($sqlcmd);
					$sqlcmd = "DELETE FROM spacereserve WHERE sid='$sid' AND category='$category'";
					$db_conn->query($sqlcmd);
					$sqlcmd = "DELETE FROM payment WHERE sid='$sid' AND category='$category'";
					$db_conn->query($sqlcmd);

					$sqlcmds='INSERT INTO specialspacessport (sid,sport) VALUES ('
					."?,?)";


					$rss = $db_conn->prepare($sqlcmds);

					for($j=0;$j<count($sport);$j++)
					{
						
						$rss->execute(array($sid,$sport[$j]));
						$sportids = $db_conn->lastInsertId();
						$nowsport=$sport[$j];
						
						
						$sqlcmdss="UPDATE specialspacessport SET sportid='$sportids' WHERE sid='$sid' AND sport='$nowsport'";
						$result = updatedb($sqlcmdss, $db_conn);
					}
					echo "<script> {window.alert('成功');location.href='dayset.php'} </script>";
				}
			}
			 
		}
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
				
			</ul>
		</div>

		<div class="next">
			<a href="#"><label>設定場館</label></a>
			<div class="arrow-6"></div>
			<a href="#"><label class="two">設定</label></a>
			<div class="arrow-7"></div>
			<a href="#"><label class="three">完成</label></a>
		</div>
		<!-- 新增場館 -->
		<div class="add-space">
			<form action="" method="POST">
			
				<div class="addspace">
					<label>開放運動:</label>
					<div class="sport_all">
						<?php
						if($category==1)
						{
						$sqlcmds = "SELECT * FROM spacessport WHERE sid='$sid'";
						$rs2 = querydb($sqlcmds, $db_conn);
						}
						else if($category==2)
						{
						$sqlcmds = "SELECT * FROM specialspacessport WHERE sid='$sid'";
						$rs2 = querydb($sqlcmds, $db_conn);
						}
						$sportss=array('排球','羽球','籃球','撞球','高爾夫球','桌球','壁球','游泳池','健身房','網球');
						foreach($sportss as $s)
						{
							echo'<div class="sports">';
							echo'<label >';
							echo'<input type="checkbox" name="sport[]" value="'.$s.'"';
							
							foreach($rs2 as $r)
							{
								$che=$r['sport'];
								if($che==$s)
								echo'checked';
							}
							
							echo'>';
							echo'<span>'.$s.'</span>';
							echo'</label >';
							echo'</div>';
						}
						?>
					</div>
				</div>
				<div class="addspace">
					<input type="submit" name="confirm" value="下一步">
				</div>
				
			</form>
			
			<?php 
				if (isset($ErrMsg) && !empty($ErrMsg)) { ?>
				<script type="text/javascript">
					alert('<?php echo $ErrMsg; ?>');
				</script>
			<?php } 
	
			?>


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