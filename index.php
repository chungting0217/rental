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
		<link rel="stylesheet" href="css1/items.css" /> 
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<style>

p{
		margin-top: 10px;
	}
	a{
		color: black;
		text-decoration:none
	}
	.pages
	{
		
		padding: 0 10px;
	}
<?php 
require_once("include/gpsvars.php");
require_once("include/configure.php");
require_once("include/db_func.php");
require_once("htmlpurifier/library/HTMLPurifier.auto.php");
session_start(); 
unset($_SESSION['search_date']);
unset($_SESSION['search_sport']);
unset($_SESSION['venue']);
unset($_SESSION['venue2']);
unset($_SESSION['sdate']);
unset($_SESSION['ssport']);
$conf = HTMLPurifier_Config::createDefault();
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$db_conn->exec("SET CHARACTER SET utf8");
$db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$num=12;

?>
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
				<!-- <li><a href="loginorsign.php">
		
					<i class="fa fa-user"></i>
					<span>登入和註冊</span>
					</a>
				</li> -->
				
			</ul>
		</div>
		<div class="filter"> 
			<li><a href="javascript:;" class="fil">
				
				<input type="checkbox"  id="checkbox1" class="checkme">
				<label for="checkbox1"><i class="fas fa-filter"></i><span>篩選</span></label>
				
				<form method="post" action="">
				<div class="add-filter">
					<?php
					$address=array('台北市','新北市','桃園市','臺中市','台南市','高雄市','新竹縣','苗栗縣','彰化縣','南投縣','雲林縣'
					,'嘉義縣','屏東縣','宜蘭縣','花蓮縣','臺東縣','澎湖縣','金門縣','連江縣','基隆市','新竹市','嘉義市');
					$h=0;
					foreach($address as $word)
					{
						$h++;
						echo '<input type="checkbox" id="'.$word.'" name="address[]" value="'.$word.'"';
													
						echo'>';
						echo '<label for="'.$word.'">'.$word.'</label>';
						
						if($h==3)
							{
								echo'</br>';
								$h=0;
							}	
					}
					echo'</br>';
					?>
					<input type="submit" name="Confim" class="add-search" value="搜尋" />
					<input type="submit" name="reConfim" class="add-search" value="重置" />
				</div>
				</form>
				</a>
			</li>
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
			<?php

				$open='Y';
				if(!isset($_SESSION['sqls']))
				{
					$sqlcmd = "SELECT * FROM spaces WHERE id IN (SELECT MIN(id) AS id FROM spaces GROUP BY sname ) AND open='$open' ";
					
					$_SESSION['sqls']=$sqlcmd;
					$sqlcmdi = "SELECT count(DISTINCT sname) AS reccount FROM spaces WHERE open='$open' ";
					$_SESSION['sqlis']=$sqlcmdi;

				}
				// 按下重整按鈕
				if(isset($reConfim))
				{
					$_GET['page']=1;
					unset($_SESSION['checks']);
					unset($_SESSION['sqls']);
					$sqlcmd = "SELECT * FROM spaces WHERE id IN (SELECT MIN(id) AS id FROM spaces GROUP BY sname ) AND open='$open'";
					
					$_SESSION['sqls']=$sqlcmd;
					$sqlcmdi = "SELECT count(DISTINCT sname) AS reccount FROM spaces ";
					$_SESSION['sqlis']=$sqlcmdi;
				}

				if(!isset($_SESSION['checks']))$_SESSION['checks']=0;
				// 按下搜尋按鈕
				if(isset($Confim))
				{
					$_SESSION['checks']=1;
					$where= "caddress=";
					$d="'";
					$address=$_POST['address'];
					$or=' or ';
					//$sql = "SELECT * FROM spaces WHERE id IN (SELECT MIN(id) AS id FROM spaces GROUP BY sname ) AND open='$open' AND ";
					$sql = "SELECT * FROM spaces  WHERE open='$open' AND ";
					for($i=0;$i<count($address);$i++)
					{
						$words=$words.$where.$d.$address[$i].$d;
						if($i!=count($address)-1)
							$words=$words.$or;	
					}
					$ord=' GROUP BY sname';
				 $sqlcmd=$sql.$words.$ord;

				 $_SESSION['sqls']=$sqlcmd;
				 $sqlcmdi = "SELECT count(DISTINCT sname) AS reccount FROM spaces  WHERE ";
				 $op='AND open=';
				 $op=$op.$d.$open.$d;
				 $sqlcmdi=$sqlcmdi.$words.$op;

				 $_SESSION['sqlis']=$sqlcmdi;
				 $_GET['page']=1;
				}

				$page=isset($_GET['page'])?$_GET['page']:1;
				// 判斷搜尋按鈕
				if($_SESSION['checks']==1)
				{
					
					$offset=($page-1)*$num;
					
				 $back=" LIMIT {$offset},{$num}";
				 $order=" ORDER BY caddress";
				 $sqltmp=$_SESSION['sqls'];
				 $_SESSION['sqls']=$_SESSION['sqls'].$order.$back;
				 
				}
				// 判斷重新整理按鈕
				if($_SESSION['checks']==0)
				{
					
					$offset=($page-1)*$num;
					$order=" ORDER BY caddress";	
				 $back=" LIMIT {$offset},{$num}";
				 $sqltmp=$_SESSION['sqls'];
				 $_SESSION['sqls']=$_SESSION['sqls'].$order.$back;
				 
				}
				
				
				if(!isset($i))$i=4;
			// 	if($rs = querydb($_SESSION['sql'], $db_conn))
			// {
				$rows = querydb($_SESSION['sqls'], $db_conn);
				// $sqlcmdi = "SELECT count(*) AS reccount FROM venue WHERE ";
				$rs = querydb($_SESSION['sqlis'], $db_conn);
				$RecCount = $rs[0]['reccount'];
				
				
				// echo'<table border="1" cellpadding="5" cellspacing="0" align="center" width="70%">';
				// echo'<tr align="center"><th>名稱</th><th>地址</th><th>電話</th></tr>';

				echo '<div class="items">';
				foreach($rows as $row)
				{
					$sid=$row['sid'];
					$sqlimg = "SELECT * FROM images WHERE mid='$sid'";
					$rss = querydb($sqlimg, $db_conn);
					echo'<div class="items-sports">';
				
					if(empty($rss[0]['img']))
					echo'<div class="image"><img src="image/testimg.png" alt=""></div>';
					else
					echo'<div class="image"><img src="image/'.$rss[0]['img'].'" alt=""></div>';
					
					echo'<div class="information">';
					// echo'<p>'.$row['date'].'</p>';
					echo'<p>'.$row['sname'].'</p>';
					echo'<p>地址: '.$row['caddress'].$row['address'].'</p>';
					echo '<p>電話: '.$row['sphone'].'</p>';
					echo'<a href="reserve.php?sid='.$sid.'">';
					echo'<div class="order">預約</div>';
					echo'</a>';
					echo'</div>';
					echo'</div>';
				}
				// echo'</table>';
				mysqli_free_result($rs);
				mysqli_close($db_conn);
			// }
			
			$total= (int) ceil($RecCount/$num);
			echo'</div>';
			
			echo '<p class="page" align="center">';
			
			if($page!=1)echo'<a href="?page='.($page-1).'" class="pages" text-decoration="none"><span> 上一頁 </span></a>';
			// if($total<5)
			// {
			// 	for($l=1;$j<=$total;$l++)
			// 	echo'<a href="?page='.$l.'" class="pages" text-decoration="none"><span>' . $l . '</span></a>';
			
			// }
			if($page>=$total)
			{
				$page=$total;
			}
			else if($page>=$total-4 && $total>4)
			{
				for($j=$total-4;$j<=$total;$j++)
				echo'<a href="?page='.$j.'" class="pages" text-decoration="none"><span>' . $j . '</span></a>';
			} 
			else if($page<3)
			{
				if($total<5)
				$i=$total-1;
				for( $k=1 , $t=$i+1 ; $k<=$t ; $k++ )
				{
					echo'<a href="?page='.$k.'" class="pages" text-decoration="none"><span>' . $k . '</span></a>';
					
				}
			}
			else if($page>=3)
			{
				if($total<5)
				$i=$total;
				for( $p=$page-2 , $t=$i+$page-2 ; $p<=$t ; $p++ )
				{
					
					echo'<a href="?page='.$p.'" class="pages" text-decoration="none"><span>' . $p . '</span></a>';
					
				}
				
			}
			
			if($page<$total-1)
				echo'<a href="?page='.($page+1).'" class="pages" text-decoration="none"><span> 下一頁 </span></a>';
			
			echo'</p>';
			
			// echo $_SESSION['sql'];
			// echo $_SESSION['sqli'];
			// echo $total;	
			$_SESSION['sqls']=$sqltmp;	
			
			?>
	</body>
</html>