<!DOCTYPE HTML>
<!--
	Solid State by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
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
		<link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
		<link rel="stylesheet" href="css1/reserve.css" /> 
		<link rel="stylesheet" href="css1/checkbox1.css" />
		<link rel="stylesheet" href="css1/style.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style>
	
	
</style>
	<?php
		require_once("include/gpsvars.php");
		require_once("include/configure.php");
		require_once("include/db_func.php");
		require_once("htmlpurifier/library/HTMLPurifier.auto.php");
		require_once("update.php");
				session_start(); 
		
		$conf = HTMLPurifier_Config::createDefault();
		$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
		$db_conn->exec("SET CHARACTER SET utf8");
		$db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$MLogin=$_SESSION['MLoginID'];
		$LoginID=$_SESSION['LoginID'];
		
		$ErrMsg='';
		
		
		$sid=$_GET['sid'];
		if(isset($search))
		{

			$_SESSION['search_date']=$_POST['rd1'];
			$_SESSION['search_sport']=$_POST['rd'];
			
			
		}

		if(isset($confirm))
		{
		
			if(!isset($LoginID)){
			?>
				<script type="text/javascript">
					alert('請先登入會員帳號!');
				</script>
			<?php
			}
			else{
				// $s=count($timess);
				// echo $s;
				//echo "<script> {window.alert('預約成功');location.href=''} </script>";
				if(count($timess)==0)
				{
					echo "<script> {window.alert('請選擇至少1個時間');location.href=''} </script>";
					
				}
				else
				{
					$sqlcmd = "SELECT * FROM userLP WHERE loginid='$LoginID'";
					$rs = querydb($sqlcmd, $db_conn);
					// print_r($rs);
					$Aid = $rs[0]['Aid'];
					// print_r($monday);
					$people=1;
					$search_date=$_SESSION['search_date'];
					$search_sport=$_SESSION['search_sport'];
					if($_SESSION['category']==2)
					{
						$category=$_SESSION['category'];
						$sqlcmd = "SELECT * FROM specialspaces WHERE sid='$sid'";
						$rs = querydb($sqlcmd, $db_conn);
						$sname=$rs[0]['sname'];

						$sqlcmd = "SELECT * FROM specialspaces WHERE sname='$sname' AND date='$search_date'";
					
							$rss = querydb($sqlcmd, $db_conn);
							$s_sid=$rss[0]['sid']; //58
							$search_date=$_SESSION['search_date']; //2021/11/16
							$search_sport=$_SESSION['search_sport'];//排球
							
							$sqlcmd = "SELECT * FROM specialspacessport WHERE sid='$s_sid' AND sport='$search_sport'";
							$rss = querydb($sqlcmd, $db_conn);
							$sportid=$rss[0]['sportid'];//6
					}
					else if($_SESSION['category']==1)
					{
						$category=$_SESSION['category'];
						$sqlcmd = "SELECT * FROM spaces WHERE sid='$sid'";
						$rs = querydb($sqlcmd, $db_conn);
						$sname=$rs[0]['sname'];

						$sqlcmd = "SELECT * FROM spaces WHERE sname='$sname' AND date='$search_date'";
					
							$rss = querydb($sqlcmd, $db_conn);
							$s_sid=$rss[0]['sid']; //58
							$search_date=$_SESSION['search_date']; //2021/11/16
							$search_sport=$_SESSION['search_sport'];//排球
							
							$sqlcmd = "SELECT * FROM spacessport WHERE sid='$s_sid' AND sport='$search_sport'";
							$rss = querydb($sqlcmd, $db_conn);
							$sportid=$rss[0]['sportid'];//6
					}
					

							foreach($timess as $ctime)
							{
								$sqlcmd = "SELECT * FROM spacereserve WHERE sid='$s_sid' AND sportid='$sportid' AND time='$ctime' AND Aid='$Aid'";
								
								$rs=querydb($sqlcmd,$db_conn);
				
								if(empty($rs[0]['time']))
								{
									$check=0;
									continue;
								}
								else
								{	
									$check=1;
									echo "<script> {window.alert('已預約相同時間');location.href='index.php'} </script>";
									break;
								}
							}
					if($check==0)
					{
						if($_SESSION['category']==2)
						{
							$category=2;
							foreach($timess as $ctime)
							{
								
							
	
								$sqlcmd = "SELECT * FROM specialspacetime WHERE  sid='$s_sid' AND sportid='$sportid' AND time='$ctime' ";
								$rs = querydb($sqlcmd, $db_conn);
								$ptotal=$rs[0]['people'];
								if($ptotal==0)echo "<script> {window.alert('無法預約');location.href='index.php'} </script>";
								else
								{
									$search_date=date( "Y/m/d", strtotime($search_date) );
									$rsqlcmd='INSERT INTO spacereserve (sid,Aid,sportid,date,time,people,category) VALUES ('
								."?,?,?,?,?,?,?)";
									$result = $db_conn->prepare($rsqlcmd);
									$result->execute(array($s_sid,$Aid,$sportid,$search_date,$ctime,$people,$category));

									$ptotal=$ptotal-$people;
	
									$sqlcmd="UPDATE specialspacetime SET people='$ptotal' WHERE  sid='$s_sid' AND sportid='$sportid' AND time='$ctime'";
									$result = updatedb($sqlcmd, $db_conn);
								}
							echo "<script> {window.alert('預約成功');location.href='index.php'} </script>";
							}
						}
						else if($_SESSION['category']==1)
						{
							$category=1;
							foreach($timess as $ctime)
							{
								
							
	
								$sqlcmd = "SELECT * FROM spacetime WHERE  sid='$s_sid' AND sportid='$sportid' AND time='$ctime' ";
								
								$rs = querydb($sqlcmd, $db_conn);
								$ptotal=$rs[0]['people'];
								if($ptotal==0)echo "<script> {window.alert('無法預約');location.href='index.php'} </script>";
								else
								{
									$search_date=date( "Y/m/d", strtotime($search_date) );
								$rsqlcmd='INSERT INTO spacereserve (sid,Aid,sportid,date,time,people,category) VALUES ('
								."?,?,?,?,?,?,?)";

								$result = $db_conn->prepare($rsqlcmd);
								$result->execute(array($s_sid,$Aid,$sportid,$search_date,$ctime,$people,$category));
									$ptotal=$ptotal-$people;
	
									$sqlcmd="UPDATE spacetime SET people='$ptotal' WHERE  sid='$s_sid' AND sportid='$sportid' AND time='$ctime'";
									
									$result = updatedb($sqlcmd, $db_conn);
								}
							echo "<script> {window.alert('預約成功');location.href='index.php'} </script>";
							}
						}
						
					
					
					}
					
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

		
		<!-- 新增場館 -->
		<form action="" method="POST">

			<div class="reserve">
				<div class="show">
					
					<div class="main-carousel">
						<?php
						$sqlimg = "SELECT * FROM images WHERE mid='$sid'";
						$rs = querydb($sqlimg, $db_conn);
						if(empty($rs[0]['img']))
						{
							echo'<div class="cell"><img src="image/testimg.png" alt=""></div>';
						}
						else
						{
							foreach($rs as $row)
							{
								echo'<div class="cell"><img src="image/'.$row['img'].'" alt=""></div>';
							}
						}
						?>
					<!-- <div class="cell"><img src="image/testimg.jpg" alt=""></div>
					<div class="cell"><img src="image/testimg.jpg" alt=""></div>
					<div class="cell"><img src="image/testimg.jpg" alt=""></div> -->
				  </div>
				</div>
				<?php
				
					$sqlcmd = "SELECT * FROM spaces WHERE sid='$sid'";
					$rs = querydb($sqlcmd, $db_conn);
					$sname=$rs[0]['sname'];
					$mid=$rs[0]['mid'];
					$telNo=$rs[0]['sphone'];
					$semail=$rs[0]['semail'];
					$caddress=$rs[0]['caddress'];
					$a=$rs[0]['address'];
					$date=$rs[0]['date'];
					$date = date( "Y-m-d", strtotime($date) );
					$start=$rs[0]['start'];
					$end=$rs[0]['end'];
				
				
				echo'<span class="shtitle">'.$sname.'</span>';
				echo'<div class="text">';
				echo'<p>地址:'.$caddress.$a.'</p>';
				echo'<p>電話:'.$telNo.'</p>';
				echo'<p>信箱:'.$semail.'</p>';
				echo'<p>營業時間:'.$start.'-'.$end.'</p>';
				echo'</div>';
				?>
				<!-- <span class="shtitle">士林運動中心</span> -->
				<!-- <div class="text">
					<p>日期:2021/10/25</p>
					<p>地址:台北市士林區中山北路5段698巷19弄31號</p>
					<p>電話:0976735160</p>
					<p>營業時間:9:00-10:00</p>
				</div> -->
				<span class="times">開放時間:</span>
				
				<div class="contents">
					<?php
						
						$sqlcmds = "SELECT * FROM spaces WHERE mid='$mid' AND sname='$sname' ORDER BY date";
						$rs1 = querydb($sqlcmds, $db_conn);
						$q=1;
						foreach($rs1 as $r)
						{
							$date=$r['date'];
							$sqlcmd2 = "SELECT * FROM specialspaces WHERE mid='$mid' AND sname='$sname'AND date='$date' ORDER BY date";
							$rs2 = querydb($sqlcmd2, $db_conn);
							if(count($rs2)>0)
							{
								$date=$rs2[0]['date'];
								$en=date( "l", strtotime($date) );
							}
							else
							{
								$date=$r['date'];
								$en=date( "l", strtotime($date) );
							}
							
							
							if($q==1)
							{
								echo'<input type="radio" name="rd1" id="'.$en.'" value="'.$date.'" checked >';
								$q++;
							}
							else
							{
								echo'<input type="radio" name="rd1" id="'.$en.'" value="'.$date.'"';
								if(isset($_SESSION['search_date']))
								{
									if($_SESSION['search_date']==$date)
									echo 'checked';
								}
								echo'>';
							}
								

							echo'<label for="'.$en.'" class="box '.$en.'">';
							echo'<div class="plan">';
							echo'<span class="circle"></span>';
							echo'<span class="yearly">'.$date.'</span>';
							echo' </div>';
							echo' </label>';
						}
						
					?>
				</div>
				<span class="time">開放運動:</span>
				<div class="content">
					<?php
						$nu=array('one','two','three','four','five','six','seven','eight','nine','ten');
						$nus=array('first','second','third','fourth','fifth','sixth','seventh','eighth','ninth','tenth');
						$sqlcmds = "SELECT * FROM spacessport WHERE sid='$sid'";
						$rs2 = querydb($sqlcmds, $db_conn);
						$q=0;
						foreach($rs2 as $r)
						{
							
							$sport=$r['sport'];
							
							if($q==0)
								echo'<input type="radio" name="rd" id="'.$nu[$q].'" value="'.$sport.'" checked>';
								
							
							else
							{
								echo'<input type="radio" name="rd" id="'.$nu[$q].'" value="'.$sport.'"';
								if(isset($_SESSION['search_sport']))
								{
									if($_SESSION['search_sport']==$sport)
									echo 'checked';
								}
								echo '>';
							}
								
								
								

							echo'<label for="'.$nu[$q].'" class="box '.$nus[$q].'">';
							echo'<div class="plan">';
							echo'<span class="circle"></span>';
							echo'<span class="yearly">'.$sport.'</span>';
							echo' </div>';
							echo' </label>';
							$q++;
						}
						
					?>
				</div>
				<?php
				if(isset($_SESSION['search_date']) && isset($_SESSION['search_sport']))
				{
					$search_date=$_SESSION['search_date'];
						$search_sport=$_SESSION['search_sport'];
					echo'<span class="searchs">目前所選:'.$search_date.$search_sport.'</span>';
				}
				?>
				<div class="hourtime">
					<!-- start -->
					<?php
					if(isset($_SESSION['search_date']) && isset($_SESSION['search_sport']))
					{
						$search_date=$_SESSION['search_date'];
						$search_sport=$_SESSION['search_sport'];


						$sqlcmd2 = "SELECT * FROM specialspaces WHERE sname='$sname'AND date='$search_date'";
						//SELECT * FROM specialspaces WHERE sname='士林運動中心'AND date='2021/12/13'
						$rs2 = querydb($sqlcmd2, $db_conn);
						if(count($rs2)>0) $_SESSION['category']=2;
						else $_SESSION['category']=1;


						if($_SESSION['category']==2)
						{
							$sqlcmd = "SELECT * FROM specialspaces WHERE sname='$sname' AND date='$search_date'";
							$rss = querydb($sqlcmd, $db_conn);
							$s_sid=$rss[0]['sid'];
							$search_date=$_SESSION['search_date'];
							$search_sport=$_SESSION['search_sport'];
							$sqlcmd = "SELECT * FROM specialspacessport WHERE sid='$s_sid' AND sport='$search_sport'";
							$rss = querydb($sqlcmd, $db_conn);
							$sportid=$rss[0]['sportid'];
	
							$sqlcmd = "SELECT * FROM specialspacetime WHERE sid='$s_sid' AND sportid='$sportid'";
							$rsss = querydb($sqlcmd, $db_conn);
						}
						else if($_SESSION['category']==1)
						{
						$sqlcmd = "SELECT * FROM spaces WHERE sname='$sname' AND date='$search_date'";
						$rss = querydb($sqlcmd, $db_conn);
						$s_sid=$rss[0]['sid'];
						$search_date=$_SESSION['search_date'];
						$search_sport=$_SESSION['search_sport'];
						$sqlcmd = "SELECT * FROM spacessport WHERE sid='$s_sid' AND sport='$search_sport'";
						$rss = querydb($sqlcmd, $db_conn);
						$sportid=$rss[0]['sportid'];

						$sqlcmd = "SELECT * FROM spacetime WHERE sid='$s_sid' AND sportid='$sportid'";
						$rsss = querydb($sqlcmd, $db_conn);
						}
						
						
					}
					
					foreach($rsss as $rows)
					{
						$people=$rows['people'];
						if($people!=0)
						{
							echo'<div class="timecheck">';
							echo'<label>';
							echo'<input type="checkbox" name="timess[]" value="'.$rows['time'].'">';
							echo'<span>'.$rows['time'].'</span>';
							echo'</label>';
							echo'</div>';
						}
						
					}
					?>
					<!-- <div class="timecheck">
						<label>
							<input type="checkbox" name="monday[]" value="9:00-10:00">
							<span>9:00-10:00</span>
						</label>
					</div> -->

					<!-- end -->
				</div>
				<div class="search">
					<input type="submit" name="search" value="查詢">
				</div>

				<?php
				if(isset($_SESSION['search_date']) && isset($_SESSION['search_sport']))
				{
					echo'<div class="addspace">';
					echo'<input type="submit" name="confirm" value="預約">';
					echo'</div>';
				}
				?>
				
				
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
			<script src="css1/flickity.pkgd.min.js"></script>

			
			<script>
				$('.main-carousel').flickity({
  // options
  				cellAlign: 'left',
				  wrapAround:true,
					freeScroll:true
  				
				});
			</script>
		
		
		<!-- Scripts -->
			<!-- 
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script> -->

	</body>
</html>