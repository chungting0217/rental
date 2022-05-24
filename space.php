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
		<link rel="stylesheet" href="css1/space.css" />
		<link rel="stylesheet" href="css1/sport.css" />  
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
<style>
	

</style>
	<?php
		session_start();
		require_once("include/gpsvars.php");
		require_once("include/configure.php");
		require_once("include/db_func.php");
		require_once("htmlpurifier/library/HTMLPurifier.auto.php");
		
		$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
		$db_conn->exec("SET CHARACTER SET utf8");
		$db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db_conn1 = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
		$db_conn1->exec("SET CHARACTER SET utf8");
		$db_conn1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$MLogin=$_SESSION['MLoginID'];
		$ErrMsg='';
		if(!isset($_SESSION['MLoginID'])) echo "<script> {window.alert('請登入');location.href='mlogin.php'} </script>";
		if(isset($confirm))
		{
			$sqlcmd = "SELECT * FROM muserLP WHERE loginid='$MLogin'";
	 	 	$rs = querydb($sqlcmd, $db_conn);
	 	 	$mid=$rs[0]['Aid'];
			$sname=$_POST['sname'];
			$city=$_POST['city'];
			$sport=$_POST['sport'];
			$address=$_POST['address'];
			$sname = mb_substr($sname, 0, 40, "utf-8");
			if (empty($sname)) $ErrMsg .= '姓名不可為空白\n';
			
			$sqlcmd="SELECT * FROM spaces WHERE sname = '$sname'";
    		$rs = querydb($sqlcmd, $db_conn);
    		if(count($rs)>0)$ErrMsg.= '此名稱已使用過了';

			if (empty($telNo)) $ErrMsg .= '電話不可為空白\n';
    		$p ='/^[0][1-9]{1,3}[0-9]{6,8}$/';
			if(!preg_match($p,$telNo))$ErrMsg .= '電話內容錯誤\n';
			
			if (empty($semail)) $ErrMsg .= '信箱不可為空白\n';
			if(!preg_match("/^[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[@]{1}[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[.]{1}[A-Za-z]{2,5}$/", $semail))$ErrMsg .= '信箱內容錯誤\n';
			
			if (empty($city)) $ErrMsg .= '縣市不可為空白\n';
			if (count($sport)==0)$ErrMsg .= '請至少選擇開放一項運動\n';
			if (empty($address)) $ErrMsg .= '地址不可為空白\n';
    		$semail = htmlspecialchars($semail);
			// echo $mname;
			// echo $telNo;
			// echo $memail;
			
			// $date1 = date( "m/d", strtotime($weektime."1") ); // First day of week
			// $date2 = date( "m/d", strtotime($weektime."7") ); // Last day of week
			if(empty($ErrMsg))
			{
				// for($i=1;$i<=7;$i++)
				// {
				// 	$date = date( "m/d", strtotime($weektime.$i) );
				// 	echo $date;
				// }
				$sqlcmd='INSERT INTO spaces (mid,sname,sphone,semail,caddress,address,date,start,end) VALUES ('
					."?,?,?,?,?,?,?,?,?)";
					$rs = $db_conn->prepare($sqlcmd);
					$_SESSION['sname']=$sname;
					$_SESSION['weektime']=$weektime;
					$sport=$_POST['sport'];
				 for($i=1;$i<=7;$i++)
				 {
					
				 	$date = date( "Y/m/d", strtotime($weektime.$i) );
				 	$rs->execute(array($mid,$sname,$telNo,$semail,$city,$address,$date,$mondaystart,$mondayend));
				 	$uid = $db_conn->lastInsertId();
				 	
				 	
				 	$sqlcmd="UPDATE spaces SET sid='$uid' WHERE date='$date' AND sname='$sname'";
        		 	$result = updatedb($sqlcmd, $db_conn);
				 	$sqlcmds='INSERT INTO spacessport (sid,sport) VALUES ('
					."?,?)";
					$rss = $db_conn1->prepare($sqlcmds);

					for($j=0;$j<count($sport);$j++)
					{
						$rss->execute(array($uid,$sport[$j]));
						$nowsport=$sport[$j];
						$sportid = $db_conn1->lastInsertId();
						$sqlcmd="UPDATE spacessport SET sportid='$sportid' WHERE sid='$uid' AND sport='$nowsport'";
        		 		$result = updatedb($sqlcmd, $db_conn1);
					}
				 }
				 echo "<script> {window.alert('成功');location.href='set.php'} </script>";
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
			<a href="#"><label>新增場館</label></a>
			<div class="arrow-6"></div>
			<a href="#"><label class="two">設定</label></a>
			<div class="arrow-7"></div>
			<a href="#"><label class="three">完成</label></a>
		</div>
		<!-- 新增場館 -->
		<div class="add-space">
			<form action="" method="POST">
				<div class="addspace">
					<label>場館名稱:</label>
					<input type="text" name="sname" value="<?php echo $sname;?>">
				</div>
				<div class="addspace">
					<label>場館電話:</label>
					<input type="tel" name="telNo" value="<?php echo $telNo;?>">
				</div>
				<div class="addspace">
					<label>場館信箱:</label>
					<input type="email" name="semail" value="<?php echo $semail;?>">
				</div>
				<div class="addspace">
					<label>地址:</label>
					<select name="city">
						<?php
							$address=array('台北市','新北市','桃園市','臺中市','台南市','高雄市','新竹縣','苗栗縣','彰化縣','南投縣','雲林縣'
							,'嘉義縣','屏東縣','宜蘭縣','花蓮縣','臺東縣','澎湖縣','金門縣','連江縣','基隆市','新竹市','嘉義市');
							echo '<option value="">請選擇場館城市</option>';
							foreach($address as $city)
							{
								echo '<option value="'.$city.'">'.$city.'</option>';
								if($city==$caddress) echo 'selected="selected"';
								echo '>'.$city.'</option>';
							}
						?>
					</select>
					<input type="text" name="address" value="<?php echo $a;?>">
				</div>
				<div class="addspace">
					<label>建立一周場館時間:</label>
					<input type="week" name="weektime">
				</div>
				<div class="addspace">
					<label>本週開閉館時間:</label>
					<input type="time" name="mondaystart" value="09:00">
					<input type="time" name="mondayend" value="22:00">
				</div>
				<div class="addspace">
					<label>選擇開放運動:</label>
					<div class="sport_all">
						<?php
						$sportss=array('排球','羽球','籃球','撞球','高爾夫球','桌球','壁球','游泳池','健身房','網球');
						foreach($sportss as $s)
						{
							echo'<div class="sports">';
							echo'<label >';
							echo'<input type="checkbox" name="sport[]" value="'.$s.'">';
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