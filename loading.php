<!DOCTYPE HTML>
<!--
	Solid State by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<?php
session_start();

?>
<?php
		header("Refresh:5;url=index.php");
		
		?>
<html>
	<head>
		<title> ้ๅ้คจ </title>
		<meta charset="utf-8" />
		
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="css1/reset.css" /> 
		<link rel="stylesheet" href="css/all.css" /> 
		<link rel="stylesheet" href="css1/base.css" /> 
		<link rel="stylesheet" href="css1/allsport.css" /> 
		<link rel="stylesheet" href="css1/space2.css" /> 
		<link rel="stylesheet" href="css1/loading.css" /> 
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<style>
	/* body {
		width: auto;
		
	}
	 .alt{
	width: auto;

	height: 150px;
	background-color: black;
	
}
 .logo{
	padding-top: 33px;
} 
.logo img{
	display: block;
  	margin: 0 auto;
	width: 200px; 
}
.top-nva{
	width: auto;
	overflow: hidden;
	
	
	background-color: #E8E7E3;
}
.top-nva{
	
	width: 100%;
	height: 48px;
	
}
.top-nva li{
	background-color: #E8E7E3;
	float: left;
	
	line-height: 48px;
}
.top-nva a{
	display: block;
	text-decoration: none;
	color:#777777;
	font-size: 18px;
	  padding: 0 156px;  
}

.top-nva a:hover{
	background-color: #3F3F3F;
	color: #E8E7E3;
} 
.navbar{
	position: relative;
	width: 100%;
	height: 50px;
	line-height: 50px;
	background-color: #fff;
	box-shadow: 0 1px 2px 0 rgb(0,0,0,0.1);

}
.navbar input{
	display: none;
}
.navbar label{
	position: absolute;
	 top: 0; 
	 left: 200px; 
	font-size: 20px;
	color: #666;
padding-left: 20px;
cursor: pointer;
transition: all 0.5s;
}
.navbar ul{
	position: absolute;
	top: 0;
	left:0;
	width: 200px;
	height: 100vh;
	background-color: #20222a;
	transition: all 0.5s;
}
.navbar ul li{
	width: 100%;
	height: 150px;
	margin-bottom: 10px;
}
.navbar ul li:first-child{
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
	padding: 10px;
	
}
.navbar ul li:first-child img{
	width: 80px;
	border-radius: 50%;
}
.navbar ul li:first-child span{
	color:#fff;
	font-size: 14px;
	white-space: nowrap;
}
.navbar ul li a{
	display: flex;
	align-items: center;
	width: 100%;
	height: 100%;
	color: #d2d2d2;
	text-decoration: none;
	border-left: 6px solid transparent;
}
.navbar ul li a i {
	font-size: 18px;
	margin: 0 15px;
}
.navbar ul li a span{
	font-size: 14px;
}
.navbar ul li a:hover{
	color: #fff;
	border-left: 6px solid #fb7299;
}
.navbar input:checked +label{
	left: 0;

}
.navbar input:checked +label i{
	transform: rotateY(180deg);
}
.navbar input:checked ~ ul{
	left:-200px;
} */

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
				<a class="a" href="managersmodify.php">็ฎก็ๅก่ณๆ</a>
				</li>';
				echo'<li>
				<a class="a" href="new.php">ๆฐๅขๅ?ด้คจ</a>
				</li>';
				echo'<li>
				<a class="a" href="examine.php">ๆฅ็้?็ด</a>
				</li>';
				echo'<li>
				<a class="a" href="managespace.php">็ฎก็ๅ?ด้คจ</a>
				</li>';

			}
			else
			{
				
				echo'<li>
				<a class="a" href="video.php">ๆจ่ฆๅฝฑ็</a>
				</li>';
				echo'<li>
				<a class="a" href="index.php">็งๅ</a>
				</li>';
				echo'<li>
				<a class="a" href="allsportsearch.php">ๅจๅฐ้ๅ้คจ</a>
				</li>';
			}
			?>
			<!-- <li>
				<a class="a" href="#">้ๅ่ณ่จ</a>
			</li>
			<li>
				<a class="a" href="#">ๆจ่ฆๅฝฑ็</a>
			</li>
			<li>
				<a class="a" href="#">็งๅ</a>
			</li>
			<li>
				<a class="a" href="allsportsearch.php">ๅจๅฐ้ๅ้คจ</a>
			</li> -->
			<?php
			if(isset($_SESSION['LoginID'])||isset($_SESSION['MLoginID']))
			{
				echo'<li>
				<a class="a" href="logout.php">็ปๅบ</a>
			</li>';
			}
			else
			{
				echo'<li>
				<a class="a" href="loginorsign.php">็ปๅฅๅ่จปๅ</a>
			</li>';
			}
			?>
			<!-- <li>
				<a class="a" href="loginorsign.php">็ปๅฅๅ่จปๅ</a>
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
						<span>ๆๅก่ณๆไฟฎๆน</span>
						</a></li>';
						echo'<li><a href="order.php"><i class="fab fa-elementor"></i>
						<span>้?็ด็ด้</span>
						</a></li>';
					}
					
				?>
				<?php
			if(isset($_SESSION['MLoginID']))
			{
				echo'<li>
					<a href="managersmodify.php">
					<i class="fas fa-user-cog"></i>
					<span>็ฎก็ๅก่ณๆ</span>
					</a></li>';
				echo'<li>
					<a href="new.php">
					<i class="fab fa-youtube"></i>
					<span>ๆฐๅขๅ?ด้คจ</span></a>
					</li>';
					echo'<li>
					<a href="examine.php">
					<i class="fas fa-sort-amount-up"></i>
						<span>ๆฅ็้?็ด</span>
						</a>
					</li>';
				echo'<li>
				<a href="managespace.php">
					<i class="fa fa-home"></i>
					<span>็ฎก็ๅ?ด้คจ</span>
					</a>
				</li>';
				

			}
			else
			{
				
				echo'<li>
					<a href="video.php">
					<i class="fab fa-youtube"></i>
					<span>ๆจ่ฆๅฝฑ็</span>
					</a>
				</li>';
				echo'<li>
					<a href="index.php">
					<i class="fa fa-home"></i>
					<span>็งๅ</span>
					</a>
				</li>';
				echo'<li>
					<a href="allsportsearch.php">
					<i class="fa fa-running"></i>
					<span>ๅจๅฐ้ๅ้คจ</span>
					</a>
				</li>';
			}
			?>
				<!-- <li><a href="javascript:;">
					<i class="fa fa-home"></i>
					<span>้ๅ่ณ่จ</span>
					</a>
				</li>
				<li><a href="javascript:;">
					<i class="fab fa-youtube"></i>
					<span>ๆจ่ฆๅฝฑ็</span>
					</a>
				</li>
				<li><a href="javascript:;">
					<i class="fa fa-home"></i>
					<span>็งๅ</span>
					</a>
				</li>
				<li><a href="allsportsearch.php">
					<i class="fa fa-running"></i>
					<span>ๅจๅฐ้ๅ้คจ</span>
					</a>
				</li> -->
				<?php
					if(isset($_SESSION['LoginID'])||isset($_SESSION['MLoginID']))
					{
						echo'<li><a href="logout.php"><i class="fa fa-user"></i>
						<span>็ปๅบ</span>
						</a></li>';
					}
					else
					{
						echo'<li><a href="loginorsign.php">
		
						<i class="fa fa-user"></i>
						<span>็ปๅฅๅ่จปๅ</span>
						</a>
					</li>';
					}
				?>
			</ul>
		</div>

		<div class="next">
			<a href="#"><label class="one">ๆฐๅขๅ?ด้คจ</label></a>
			<div class="arrow-6"></div>
			<a href="#"><label class="two">่จญๅฎ</label></a>
			<div class="arrow-7"></div>
			<a href="#"><label class="three">ๅฎๆ</label></a>
		</div>
			<div class="load">
				<div class="loading">
					<span> loading....</span>
				</div>
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