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
if(isset($update))
{
	$date=$date = date( "Y/m/d", strtotime($weektime."1") );
	$sqlcmd = "SELECT * FROM spaces WHERE date='$date' AND sname='$sname'";
	$rs = querydb($sqlcmd, $db_conn);
	$sid=$rs[0]['sid'];
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
		// echo "<script> {window.alert('??????');location.href='managespace.php'} </script>";
		}
		else
		{
			echo "<script> {window.alert('??????');location.href='loading.php'} </script>";
		}
	}
	echo "<script> {window.alert('??????');location.href='loading.php'} </script>";
}




?>
<html>
	<head>
		<title> ????????? </title>
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
				<a class="a" href="managersmodify.php">???????????????</a>
				</li>';
				echo'<li>
				<a class="a" href="new.php">????????????</a>
				</li>';
				echo'<li>
				<a class="a" href="examine.php">????????????</a>
				</li>';
				echo'<li>
				<a class="a" href="managespace.php">????????????</a>
				</li>';

			}
			else
			{
				
				echo'<li>
				<a class="a" href="video.php">????????????</a>
				</li>';
				echo'<li>
				<a class="a" href="index.php">??????</a>
				</li>';
				echo'<li>
				<a class="a" href="allsportsearch.php">???????????????</a>
				</li>';
			}
			?>
			<!-- <li>
				<a class="a" href="#">????????????</a>
			</li>
			<li>
				<a class="a" href="#">????????????</a>
			</li>
			<li>
				<a class="a" href="#">??????</a>
			</li>
			<li>
				<a class="a" href="allsportsearch.php">???????????????</a>
			</li> -->
			<?php
			if(isset($_SESSION['LoginID'])||isset($_SESSION['MLoginID']))
			{
				echo'<li>
				<a class="a" href="logout.php">??????</a>
			</li>';
			}
			else
			{
				echo'<li>
				<a class="a" href="loginorsign.php">???????????????</a>
			</li>';
			}
			?>
			<!-- <li>
				<a class="a" href="loginorsign.php">???????????????</a>
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
						<span>??????????????????</span>
						</a></li>';
						echo'<li><a href="order.php"><i class="fab fa-elementor"></i>
						<span>????????????</span>
						</a></li>';
					}
					
				?>
				<?php
			if(isset($_SESSION['MLoginID']))
			{
				echo'<li>
					<a href="managersmodify.php">
					<i class="fas fa-user-cog"></i>
					<span>???????????????</span>
					</a></li>';
				echo'<li>
					<a href="new.php">
					<i class="fab fa-youtube"></i>
					<span>????????????</span></a>
					</li>';
					echo'<li>
					<a href="examine.php">
					<i class="fas fa-sort-amount-up"></i>
						<span>????????????</span>
						</a>
					</li>';
				echo'<li>
				<a href="managespace.php">
					<i class="fa fa-home"></i>
					<span>????????????</span>
					</a>
				</li>';
				

			}
			else
			{
				
				echo'<li>
					<a href="video.php">
					<i class="fab fa-youtube"></i>
					<span>????????????</span>
					</a>
				</li>';
				echo'<li>
					<a href="index.php">
					<i class="fa fa-home"></i>
					<span>??????</span>
					</a>
				</li>';
				echo'<li>
					<a href="allsportsearch.php">
					<i class="fa fa-running"></i>
					<span>???????????????</span>
					</a>
				</li>';
			}
			?>
				<!-- <li><a href="javascript:;">
					<i class="fa fa-home"></i>
					<span>????????????</span>
					</a>
				</li>
				<li><a href="javascript:;">
					<i class="fab fa-youtube"></i>
					<span>????????????</span>
					</a>
				</li>
				<li><a href="javascript:;">
					<i class="fa fa-home"></i>
					<span>??????</span>
					</a>
				</li>
				<li><a href="allsportsearch.php">
					<i class="fa fa-running"></i>
					<span>???????????????</span>
					</a>
				</li> -->
				<?php
					if(isset($_SESSION['LoginID'])||isset($_SESSION['MLoginID']))
					{
						echo'<li><a href="logout.php"><i class="fa fa-user"></i>
						<span>??????</span>
						</a></li>';
					}
					else
					{
						echo'<li><a href="loginorsign.php">
		
						<i class="fa fa-user"></i>
						<span>???????????????</span>
						</a>
					</li>';
					}
				?>
				
			</ul>
		</div>

		<div class="next">
			<a href="#"><label class="one">????????????</label></a>
			<div class="arrow-6"></div>
			<a href="#"><label class="two">??????</label></a>
			<div class="arrow-7"></div>
			<a href="#"><label class="three">??????</label></a>
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
		<!-- ???????????? -->
		<div class="add-space">
			<form  enctype="multipart/form-data" action="" method="POST">
				
		
				<div class="addspace">
					<label>????????????:</label>
					
					<input type="button" value="??????" onclick="addFile();">
					
		 			<div id="fileDiv"></div>
				</div>
			
				
				<div class="addspace">
				<input type="submit" name="update" value="??????">
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