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
        <link rel="stylesheet" href="css1/login.css" /> 
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<style>
    .login .box{
    display: flex;
    justify-content: space-around;
    align-items: center;
    flex-direction: column;
    width: 100px;
    height: 140px;
    margin: 20px;
    cursor: pointer;
    flex-grow: 1;
    position: relative;
    
}
.login .box .img p{
    font-size: 20px;
    position: absolute;
    top:160px;


}
		</style>
	</head>
	<body class="cbody">
		<div id="header" class="alt">
			<div class="logo"><a href="index.php"><img src="image/LOGO.png"></a></div>
		</div>

	<div calss="nva-top">
		<ul class="top-nva">
			
			<li>
				<a class="a" href="video.php">推薦影片</a>
			</li>
			<li>
				<a class="a" href="index.php">租借</a>
			</li>
			<li>
				<a class="a" href="allsportsearch.php">全台運動館</a>
			</li>
			<li>
				<a class="a" href="loginorsign.php">登入和註冊</a>
			</li>
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
				
				<li><a href="video.php">
					<i class="fab fa-youtube"></i>
					<span>推薦影片</span>
					</a>
				</li>
				<li><a href="index.php">
					<i class="fa fa-home"></i>
                
					<span>租借</span>
					</a>
				</li>
				<li><a href="allsportsearch.php">
					<i class="fa fa-running"></i>
					<span>全台運動館</span>
					</a>
				</li>
				<li><a href="loginorsign.php">
		
					<i class="fa fa-user"></i>
					<span>登入和註冊</span>
					</a>
				</li>
				
			</ul>
		</div>
        <div class="lbody">
            <div class="login">
                <div class="box">
                    <a href="mlogin.php">
                    <div class="img"><i class="fas fa-users-cog fa-10x"></i>
                        
                    <p>管理者登入</p>
                    </div>
                    
                    </a>
                </div>
                <div class="box">
                    <a href="login.php">
                        <div class="img"><i class="fas fa-user fa-10x"></i>
                            <p>使用者登入</p>
                        </div>
                        </a>
                </div>
                
            </div>
        </div>
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