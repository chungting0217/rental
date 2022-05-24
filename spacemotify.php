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
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
<style>
	
.update
{
	margin-left: 50%;
}
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
		$MLogin=$_SESSION['MLoginID'];
		$ErrMsg='';
		$category=$_GET['category'];
			$sid=$_GET['sid'];
			$_SESSION['sid']=$sid;
		if(!isset($_SESSION['MLoginID'])) echo "<script> {window.alert('請登入');location.href='mlogin.php'} </script>";
		if(!isset($cname))
		{
			$category=$_GET['category'];
			$sid=$_GET['sid'];
			$_SESSION['sid']=$sid;
			if($category==1)
			{
				$sqlcmd = "SELECT * FROM spaces WHERE sid='$sid'";
				$rs = querydb($sqlcmd, $db_conn);
				$sname=$rs[0]['sname'];
				$telNo=$rs[0]['sphone'];
				$semail=$rs[0]['semail'];
				$caddress=$rs[0]['caddress'];
				$a=$rs[0]['address'];
				$date=$rs[0]['date'];
				$week=date( "W", strtotime($date) );
				$date = date( "Y-m-d", strtotime($date) );
				$start=$rs[0]['start'];
				$end=$rs[0]['end'];
			}
			if($category==2)
			{
				$sqlcmd = "SELECT * FROM specialspaces WHERE sid='$sid'";
				$rs = querydb($sqlcmd, $db_conn);
				$sname=$rs[0]['sname'];
				$telNo=$rs[0]['sphone'];
				$semail=$rs[0]['semail'];
				$caddress=$rs[0]['caddress'];
				$a=$rs[0]['address'];
				$date=$rs[0]['date'];
				$date = date( "Y-m-d", strtotime($date) );
				$start=$rs[0]['start'];
				$end=$rs[0]['end'];
				
			}
			
		}
		if(isset($deleteimg))
		{
				
				$sqlcmd = "SELECT * FROM images WHERE mid='$sid' ";
				$rs=querydb($sqlcmd,$db_conn);
				foreach($rs as $row)
				{
					$temp_name=$row['img'];
					unlink("image/".$temp_name);
				}
				$sqlcmd = "DELETE FROM images WHERE mid='$sid' ";
				$db_conn->query($sqlcmd);
				
				echo "<script> {window.alert('成功');location.href='managespace.php'} </script>";
			
		}
		if(isset($confirm))
		{
			$sqlcmd = "SELECT * FROM muserLP WHERE loginid='$MLogin'";
	 	 	$rs = querydb($sqlcmd, $db_conn);
	 	 	$mid=$rs[0]['Aid'];
			$sname=$_POST['sname'];
			$telNo=$_POST['telNo'];
			$start=$_POST['start'];
			$end=$_POST['end'];
			$semail=$_POST['semail'];
			$caddress=$_POST['city'];
			$a=$_POST['address'];
			$sname = mb_substr($sname, 0, 40, "utf-8");
			if (empty($sname)) $ErrMsg .= '姓名不可為空白\n';
			
			
			if (empty($telNo)) $ErrMsg .= '電話不可為空白\n';
    		$p ='/^[0][1-9]{1,3}[0-9]{6,8}$/';
			if(!preg_match($p,$telNo))$ErrMsg .= '電話內容錯誤\n';
			
			if (empty($semail)) $ErrMsg .= '信箱不可為空白\n';
			if(!preg_match("/^[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[@]{1}[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[.]{1}[A-Za-z]{2,5}$/", $semail))$ErrMsg .= '信箱內容錯誤\n';
			
			if (empty($city)) $ErrMsg .= '縣市不可為空白\n';
			
			if (empty($a)) $ErrMsg .= '地址不可為空白\n';
    		$semail = htmlspecialchars($semail);
			// echo $mname;
			// echo $telNo;
			// echo $memail;
			// echo $day;
			// echo date("Y/m/d",strtotime($day));
			// $date1 = date( "m/d", strtotime($weektime."1") ); // First day of week
			// $date2 = date( "m/d", strtotime($weektime."7") ); // Last day of week
			if(empty($ErrMsg))
			{
				$_SESSION['sname']=$sname;
				$_SESSION['telNo']=$telNo;
				$_SESSION['start']=$start;
				$_SESSION['end']=$end;
				$_SESSION['caddress']=$caddress;
				$_SESSION['address']=$a;
				$_SESSION['category']=$category;
				$_SESSION['sid']=$sid;
				if($category==1)
				{
					$sqlcmd = "SELECT * FROM muserLP WHERE loginid='$MLogin'";
					$rs = querydb($sqlcmd, $db_conn);
					$Aid=$rs[0]['Aid'];
					$sqlcmds = "SELECT * FROM spaces WHERE mid='$Aid' AND sname='$sname' ";
					$rs = querydb($sqlcmds, $db_conn);
					$i=1;
					foreach($rs as $rss)
					 {
					 	$ssid=$rss['sid'];
						$date = date( "Y/m/d", strtotime($weektime.$i) );
					 	$sqlcmd="UPDATE spaces SET sname='$sname',sphone='$telNo',semail='$semail',caddress='$caddress',address='$a',date='$date',start='$start',end='$end' WHERE sid='$ssid'";
						// print($sqlcmd);
					 	$result = updatedb($sqlcmd, $db_conn);
					 	$i++;
					 }
				}
				if($category==2)
				{
					$date = date( "Y/m/d", strtotime($day) );
					$_SESSION['day']=$date;
					$sqlcmd="UPDATE specialspaces SET sname='$sname',sphone='$telNo',semail='$semail',caddress='$caddress',address='$a',date='$date',start='$start',end='$end' WHERE sid='$sid'";
					$result = updatedb($sqlcmd, $db_conn);
				}
				
			}
			
			  echo "<script> {window.alert('成功');location.href='managespace.php'} </script>";
		}

		#######################
		if(isset($confirm2))
		{
			$sqlcmd = "SELECT * FROM muserLP WHERE loginid='$MLogin'";
	 	 	$rs = querydb($sqlcmd, $db_conn);
	 	 	$mid=$rs[0]['Aid'];
			$sname=$_POST['sname'];
			$telNo=$_POST['telNo'];
			$start=$_POST['start'];
			$end=$_POST['end'];
			$semail=$_POST['semail'];
			$caddress=$_POST['city'];
			$a=$_POST['address'];
			
			$sname = mb_substr($sname, 0, 40, "utf-8");
			if (empty($sname)) $ErrMsg .= '姓名不可為空白\n';
			
			$sname = htmlspecialchars($sname); 
			
			if (empty($telNo)) $ErrMsg .= '電話不可為空白\n';
    		$p ='/^[0][1-9]{1,3}[0-9]{6,8}$/';
			if(!preg_match($p,$telNo))$ErrMsg .= '電話內容錯誤\n';
			
			if (empty($semail)) $ErrMsg .= '信箱不可為空白\n';
			if(!preg_match("/^[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[@]{1}[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[.]{1}[A-Za-z]{2,5}$/", $semail))$ErrMsg .= '信箱內容錯誤\n';
			
			if (empty($city)) $ErrMsg .= '縣市不可為空白\n';
			
			if (empty($a)) $ErrMsg .= '地址不可為空白\n';
    		$semail = htmlspecialchars($semail);
			
			if(empty($ErrMsg))
			{
				$_SESSION['sname']=$sname;
				$_SESSION['telNo']=$telNo;
				$_SESSION['start']=$start;
				$_SESSION['end']=$end;
				$_SESSION['caddress']=$caddress;
				$_SESSION['address']=$a;
				$_SESSION['category']=$category;
				
				if($category==1)
				{
					$_SESSION['weektime']=$weektime;
					$sqlcmd = "SELECT * FROM muserLP WHERE loginid='$MLogin'";
					//echo $sqlcmd;
					$rs = querydb($sqlcmd, $db_conn);
					$Aid=$rs[0]['Aid'];
					$sqlcmds = "SELECT * FROM spaces WHERE mid='$Aid' AND sname='$sname' ";
					//echo $sqlcmds;
					$rs = querydb($sqlcmds, $db_conn);
					$i=1;
					 foreach($rs as $rss)
					 {
					 	$ssid=$rss['sid'];
						$date = date( "Y/m/d", strtotime($weektime.$i) );
					 	$sqlcmd="UPDATE spaces SET sname='$sname',sphone='$telNo',semail='$semail',caddress='$caddress',address='$a',date='$date',start='$start',end='$end' WHERE sid='$ssid'";
						// print($sqlcmd);
					 	$result = updatedb($sqlcmd, $db_conn);
					 	$i++;
					 }
					
				}
				if($category==2)
				{
					$date = date( "Y/m/d", strtotime($day) );
					$_SESSION['day']=$date;
					$sqlcmd="UPDATE specialspaces SET sname='$sname',sphone='$telNo',semail='$semail',caddress='$caddress',address='$a',date='$date',start='$start',end='$end' WHERE sid='$sid'";
					$result = updatedb($sqlcmd, $db_conn);
				}
				
			}
			
			  echo "<script> {location.href='sport.php'} </script>";
		}


		if(isset($opens))
		{
			$sqlcmd = "SELECT * FROM muserLP WHERE loginid='$MLogin'";
			
			$rs = querydb($sqlcmd, $db_conn);
			$Aid=$rs[0]['Aid'];
			
			$sqlcmds = "SELECT * FROM spaces WHERE mid='$Aid' AND sname='$sname' ";
			$rs = querydb($sqlcmds, $db_conn);
			$i=1;
			$open='Y';
			 foreach($rs as $rss)
			{
				
				$ssid=$rss['sid'];
				$date = date( "Y/m/d", strtotime($weektime.$i) );
				$sqlcmd="UPDATE spaces SET open='$open' WHERE sid='$ssid'";
							// print($sqlcmd);
				$result = updatedb($sqlcmd, $db_conn);
				$i++;
			}
			echo "<script> {window.alert('成功');location.href='managespace.php'} </script>";
		}
		if(isset($delete))
		{
			$sqlcmd = "SELECT * FROM muserLP WHERE loginid='$MLogin'";
			
			$rs = querydb($sqlcmd, $db_conn);
			$Aid=$rs[0]['Aid'];
			
			$sqlcmds = "SELECT * FROM spaces WHERE mid='$Aid' AND sname='$sname' ";
			$rs = querydb($sqlcmds, $db_conn);
			$i=1;
			$open='N';
			 foreach($rs as $rss)
			{
				
				$ssid=$rss['sid'];
				$date = date( "Y/m/d", strtotime($weektime.$i) );
				$sqlcmd="UPDATE spaces SET open='$open' WHERE sid='$ssid'";
							// print($sqlcmd);
				$result = updatedb($sqlcmd, $db_conn);
				$i++;
			}
			echo "<script> {window.alert('成功');location.href='managespace.php'} </script>";
		}

		if(isset($update))
		{
			$extension=array('jpeg','jpg','png','gif');
			
			echo $ErrMsg;
			foreach($_FILES['image']['tmp_name'] as $key => $value) 
			{
				$date=date('Ymdhis');
				
				//$filename=$_FILES['image']['name'][$key];
				$filesname=$_FILES['image']['name'][$key];
				$name=explode('.',$filesname);
				$newPath=$date.'.'.$name[1];
				$oldPath=$_FILES['image']['tmp_name'][$key];
				rename("image/".$oldPath,"image/".$newPath);
				$filename_tmp=$_FILES['image']['tmp_name'][$key];//de
				
				
				$ext=pathinfo($newPath,PATHINFO_EXTENSION);

				$finalimg='';
				if(in_array($ext,$extension))
				{
					if(!file_exists('image/'.$newPath))
					{
						move_uploaded_file($filename_tmp, "image/".$newPath);
						//$finalimg=$filename;
						$finalimg=$newPath;
					}
					else
					{
						$copy=mt_rand(0,10000);
						$newPath=$date.$copy.'.'.$name[1];
						rename("image/".$oldPath,"image/".$newPath);
						move_uploaded_file($filename_tmp, "image/".$newPath);
						$finalimg=$newPath;;
						
					}
					
					// $insertqry="INSERT INTO `images`( `mid`, `img`) VALUES ('$mid','$finalimg')";
					// mysqli_query($con,$insertqry);
				 $sqlcmd='INSERT INTO images (mid,img) VALUES ('
        		 ."?,?)";
				 $rs = $db_conn->prepare($sqlcmd);
        		 $rs->execute(array($sid,$finalimg));
				// echo "<script> {window.alert('成功');location.href='managespace.php'} </script>";
				}
				else
				{
					echo "<script> {window.alert('成功');location.href='managespace.php'} </script>";
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
		<script src="assets/js/jquery.min.js"></script>
		<script language="javascript"> 
			var addFile=function()
			{
				var div=document.getElementById("fileDiv");
				var br=document.createElement("br");
				var input=document.createElement("input");
				var buttom=document.createElement("input");

				input.setAttribute("type","file");
				input.setAttribute("name","image[]");
				buttom.setAttribute("type","buttom");
				buttom.style.width='50px';
				buttom.setAttribute("value","X");

				buttom.onclick=function()
				{
					div.removeChild(br);
					div.removeChild(input);
					div.removeChild(buttom);
				}
				div.appendChild(br);
				div.appendChild(input);
				div.appendChild(buttom);
			}
		</script>
		<!-- 新增場館 -->
		<div class="add-space">
			<form enctype="multipart/form-data" action="" method="POST">
				<div class="addspace">
					<label>場館名稱:</label>
					<input type="text" name="sname" readonly="readonly" value="<?php echo $sname;?>">※不可更改
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
								echo '<option value="'.$city.'"';
								if($city==$caddress) echo 'selected="selected"';
								echo '>'.$city.'</option>';
							}
						?>
					</select>
					<input type="text" name="address" value="<?php echo $a;?>">
				</div>
				<div class="addspace">
					<label>場館時間:</label>
					<?php
					if($category==1)
					{
						$week=date("W",strtotime($date));
						$year=date("Y",strtotime($date));
						$w='W';
						$d='-';
						$week=$year.$d.$w.$week;
						
						echo'<input type="week" name="weektime" value="'.$week.'">';
						
					}
					else if($category==2)
					echo'<input type="date" name="day" value="'.$date.'">';
					
					?>
					
				</div>
				<div class="addspace">
					<label>當天開閉館時間:</label>
					<input type="time" name="start" value="<?php echo $start;?>">
					<input type="time" name="end" value="<?php echo $end;?>">
				</div>
				<?php
				if($category==1)
				{
					echo'<div class="addspace">';
					echo'<label>新增照片:</label>';
					echo'<input type="button" value="新增" onclick="addFile();">';
					echo'<div id="fileDiv"></div>';
					echo'</div>';
					echo'<div class="update"><input type="submit" name="update" value="上傳"></div>';
				}
				
				
				?>
				<!-- <div class="addspace">
					<label>新增照片:</label>
					
					<input type="button" value="新增" onclick="addFile();">
					
		 			<div id="fileDiv"></div>
				</div>
				<div class="update"><input type="submit" name="update" value="上傳"></div> -->
				<div class="addspace">
					<input type="submit" name="confirm2" value="設定場館">
				</div>
				<div class="addspace">
					<input type="submit" name="confirm" value="儲存">
				</div>
				<div class="addspace">
					<?php
					if($category==1)
					{
						$sqlcmd = "SELECT * FROM muserLP WHERE loginid='$MLogin'";
			
						$rs = querydb($sqlcmd, $db_conn);
						$Aid=$rs[0]['Aid'];
						$sql="SELECT * FROM spaces WHERE sid='$sid' AND mid='$Aid'";
						$rs = querydb($sql, $db_conn);
						$open=$rs[0]['open'];
						if($open=='Y')
						{
							echo'<input type="submit" name="delete" value="閉館">';
						}
						else if($open=='N')
						{
							echo'<input type="submit" name="opens" value="開館">';
						}
						
					}
					
					
					?>
					
				</div>
				<div class="addspace">
				<input type="submit" name="deleteimg" value="刪除內存照片">
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