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
		<link rel="stylesheet" href="css1/test.css" /> 
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
		<style>



		</style>
		<?php
		if(isset($sure))
		{
			$_SESSION['venue']=$_POST['venue'];
			echo "<script> {location.href=''} </script>";
			unset($_SESSION['venue2']);
		}
		if(isset($sure2))
		{
			$_SESSION['venue2']=$_POST['venue2'];
			echo "<script> {location.href=''} </script>";
			unset($_SESSION['venue']);
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
		<div class="select_som">
			<form method="post" action="">
				<div class="sele">
					<label>選擇周排程:</label>
					<select name="venue">
						<?php
						$sql="SELECT * FROM spaces WHERE id IN (SELECT MIN(id) AS id FROM spaces GROUP BY sname )AND mid='$mid'";
						$rows = querydb($sql, $db_conn);
						echo '<option value="">請選擇場館</option>';
						foreach($rows as $row)
						{

							$venue=$row['sname'];
							echo'<option value="'.$venue.'"';
							if(isset($_SESSION['venue']))
							{
								if($_SESSION['venue']==$venue)
								echo'selected';
							}
							echo'>'.$venue.'</option>';
						}
						?>
						<!-- <option value="士林運動中心">士林運動中心</option> -->
						<input type="submit" name="sure" value="確定">
					</select>
					<label>選擇日排程:</label>
					<select name="venue2">
						<?php
						$sql="SELECT * FROM specialspaces WHERE id IN (SELECT MIN(id) AS id FROM specialspaces GROUP BY sname )AND mid='$mid'";
						$rows = querydb($sql, $db_conn);
						echo '<option value="">請選擇場館</option>';
						foreach($rows as $row)
						{

							$venue=$row['sname'];
							echo'<option value="'.$venue.'"';
							if(isset($_SESSION['venue2']))
							{
								if($_SESSION['venue2']==$venue)
								echo'selected';
							}
							echo'>'.$venue.'</option>';
						}
						?>
						<!-- <option value="士林運動中心">士林運動中心</option> -->
						<input type="submit" name="sure2" value="確定">
					</select>
				</div>
		<div class="body">
		<div class="calendar">
			<?php
			if(isset($_SESSION['venue']))
			{
				$venue=$_SESSION['venue'];
				$sql="SELECT * FROM spaces WHERE mid='$mid' AND sname='$venue' ORDER BY date";
				$rows = querydb($sql, $db_conn);
				$i=1;
				foreach($rows as $row)
				{
	
					$id=$row['id'];
					if($i==1)
					{
						$firstdate=$row['date'];
					}
					if($i==7)
					{
						$lastdate=$row['date'];
					}
					$i+=1;
				}
				$years=date("Y", strtotime($firstdate) );
				$fdate=date("d M", strtotime($firstdate) );
				$ldate=date("d M", strtotime($lastdate) );
			}
			if(isset($_SESSION['venue2']))
			{
				$venue=$_SESSION['venue2'];
				$sql="SELECT * FROM specialspaces WHERE mid='$mid' AND sname='$venue' ORDER BY date";
				$rows = querydb($sql, $db_conn);
				$i=1;
				$count=count($rows);
				foreach($rows as $row)
				{
	
					$id=$row['id'];
					if($i==1)
					{
						$firstdate=$row['date'];
					}
					if($i==$count)
					{
						$lastdate=$row['date'];
					}
					$i+=1;
				}
				$years=date("Y", strtotime($firstdate) );
				$fdate=date("d M", strtotime($firstdate) );
				$ldate=date("d M", strtotime($lastdate) );
			}
			?>
			<header>
				
				<div class="calendar__title" style="display: flex; justify-content: center; align-items: center">
				 
				  <h1 class="" style="flex: 1;"><span></span><strong><?php echo''.$fdate.' – '.$ldate.''; ?></strong> <?php echo $years; ?></h1>
				  
				</div> 
				<div style="align-self: flex-start; flex: 0 0 1"></div>
			</header>
			
			<div class="outer">
		  
			
			<table>
			<thead>
			  <tr>
				
				<th class="headcol"></th>
				<th>運動</th>
				<?php
				if(isset($_SESSION['venue']))
				{
					$sql="SELECT * FROM spaces WHERE mid='$mid' AND sname='$venue' ORDER BY date";
				$rows = querydb($sql, $db_conn);
				$todays=date("Y/m/d");
				$today=date("M, d", strtotime($todays) );
				foreach($rows as $row)
				{
					$date=$row['date'];
					$dates=date("M, d", strtotime($date) );
					echo'<th class=';
					if($dates==$today)echo'" today"';
					$sec=date("l", strtotime($dates) );
					if($sec=='Sunday' ||$sec=='Saturday')echo'" secondary"';
					echo'>'.$dates.'</th>';
				
				}
				}
				if(isset($_SESSION['venue2']))
				{
					$sql="SELECT * FROM specialspaces WHERE mid='$mid' AND sname='$venue' ORDER BY date";
				$rows = querydb($sql, $db_conn);
				$todays=date("Y/m/d");
				$today=date("M, d", strtotime($todays) );
				$counts=count($rows);
				foreach($rows as $row)
				{
					$date=$row['date'];
					$dates=date("M, d", strtotime($date) );
					echo'<th class=';
					if($dates==$today)echo'" today"';
					$sec=date("l", strtotime($dates) );
					if($sec=='Sunday' ||$sec=='Saturday')echo'" secondary"';
					echo'>'.$dates.'</th>';
				
				}
				if($counts<7)
				{
					$counts=7-$counts;
					for($j=0;$j<$counts;$j++)
					{
						echo'<th></th>';
					}
				}
				}
				?>
				<!-- <th>Mon, 18</th>
				<th>Tue, 19</th>
				<th class="today">Wed, 20</th>
				<th>Thu, 21</th>
				<th>Fri, 22</th>
				<th class="secondary">Sat, 23</th>
				<th class="secondary">Sun, 24</th> -->
			  </tr>
			</thead>
			</table>
		  
		  <div class="wrap"> 
			<table class="offset">
		  
			<tbody>
			  
			  <?php
				if(isset($_SESSION['venue']))
				{
					$sqls="SELECT * FROM spaces WHERE id IN (SELECT MIN(id) AS id FROM spaces GROUP BY sname )AND mid='$mid' AND sname='$venue'";
				$rs = querydb($sqls, $db_conn);
				$start=$rs[0]['start'];
				$end=$rs[0]['end'];
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
						echo'<tr>';
						echo'<td class="headcol">'.$value.'</td>';
						$sql = "SELECT * FROM spaces WHERE mid='$mid' AND sname='$venue' ORDER BY date";
						$rows = querydb($sql, $db_conn);
						// 運動
						echo'<td>';
							$sdate=$rows[0]['date'];
							$sqls = "SELECT * FROM spaces WHERE mid='$mid' AND sname='$venue' AND date='$date'";
							$rows = querydb($sqls, $db_conn);
							$sid=$rows[0]['sid'];
							$sqls="SELECT * FROM spacessport WHERE sid='$sid' GROUP BY sport ORDER BY sportid";
							$rows = querydb($sqls, $db_conn);
							foreach($rows as $row)
							{
								$ssport=$row['sport'];
								echo'<div class="sports" >'.$ssport.'</div>';
							}
						
						echo'</td>';
						// 運動尾
						//bar
						
						$sql = "SELECT * FROM spaces WHERE mid='$mid' AND sname='$venue' ORDER BY date";
						$rows = querydb($sql, $db_conn);
						$check=1;
						foreach($rows as $row)
							{
								
								echo'<td>';
								$date=$row['date'];
								$sid=$row['sid'];//7
								$sql2 = "SELECT * FROM specialspaces WHERE mid='$mid' AND sname='$venue' AND date='$date'";
								//SELECT * FROM specialspaces WHERE mid=8 AND sname='士林運動中心' AND date='2021/12/13'
								$row2 = querydb($sql, $db_conn);
								$true=count($row2)>0;
								$check=1;
								/*if($true)
								{
									$sql2="SELECT * FROM spacessport WHERE sid='$sid' ORDER BY sportid";
									$row3 = querydb($sql2, $db_conn);
									$sids=$sid;
									$sid=$row2[0]['sid'];
									$sqls="SELECT * FROM specialspacessport WHERE sid='$sid' ORDER BY sportid";
									//SELECT * FROM specialspacessport WHERE sid=1 ORDER BY sportid  2
									$rows = querydb($sqls, $db_conn);
									$count=count($rows);
									$check=2;
									
									
								}
								else
								{
									$sqls="SELECT * FROM spacessport WHERE sid='$sid' ORDER BY sportid";
									$rows = querydb($sqls, $db_conn);
									$check=1;
								}*/
								$sqls="SELECT * FROM spacessport WHERE sid='$sid' ORDER BY sportid";
									$rows = querydb($sqls, $db_conn);
								$run=0;
								foreach($rows as $row)
								{
									$sportid=$row['sportid'];
									/*
									if($true)
									{
										$sql = "SELECT * FROM specialspacetime WHERE sid='$sid' AND sportid='$sportid' AND time='$value'";
										
										//SELECT * FROM specialspacetime WHERE sid=1 AND sportid=1 AND time='09:00-10:00'
										$rows = querydb($sql, $db_conn);
										$people=$rows[0]['people'];
										$limitpeople=$rows[0]['limitpeople'];
										$total=$limitpeople-$people;
										$per=($total/$limitpeople)*100;

										if($run%7==0)
										{
										$sportid=$row3[0]['sportid'];
										$sid=$sids;
										$sql = "SELECT * FROM spacetime WHERE sid='$sid' AND sportid='$sportid' AND time='$value'";
										
										$rows = querydb($sql, $db_conn);
										$people=$rows[0]['people'];
										$limitpeople=$rows[0]['limitpeople'];
										$total=$limitpeople-$people;
										$per=($total/$limitpeople)*100;
										}
										$run++;
									}
									else
									{
										$sql = "SELECT * FROM spacetime WHERE sid='$sid' AND sportid='$sportid' AND time='$value'";
										
										$rows = querydb($sql, $db_conn);
										$people=$rows[0]['people'];
										$limitpeople=$rows[0]['limitpeople'];
										$total=$limitpeople-$people;
										$per=($total/$limitpeople)*100;
									}
									*/
									// $rows = querydb($sql, $db_conn);
									// 	$people=$rows[0]['people'];
									// 	$limitpeople=$rows[0]['limitpeople'];
									// 	$total=$limitpeople-$people;
									// 	$per=($total/$limitpeople)*100;
									$sql = "SELECT * FROM spacetime WHERE sid='$sid' AND sportid='$sportid' AND time='$value'";
										
										$rows = querydb($sql, $db_conn);
										$people=$rows[0]['people'];
										$limitpeople=$rows[0]['limitpeople'];
										$total=$limitpeople-$people;
										$per=($total/$limitpeople)*100;
										
									
									
									if(is_nan($per))echo'';
									else
									{
										$per=number_format($per,1);
										echo'<div class="sports" ><a href="view.php?sportid='.$sportid.'&sid='.$sid.'&time='.$value.'&category='.$check.'"><img src="';
										if($per<=50)
										echo'images/blue.jpg';
										else if($per>50 &&$per<=80)
										echo'images/yellow.jpg';
										else if($per>80)
										echo'images/red.jpg';
										echo'"  width=';
										if($per==0)
											echo'1';
										else echo $per;
										echo'% height=10px alt=""><span>'.$per.'%</span></a></div>';

									}
								
									$run++;
								}
								echo'</td>';
								
							}
						
						//bar尾
						echo'</tr>';
						$first=$second;
						echo'<tr>';
						echo'<td class="headcol"></td>';
						echo'<td></td>';
						echo'<td></td>';
						echo'<td></td>';
						echo'<td></td>';
						echo'<td></td>';
						echo'<td></td>';
						echo'<td></td>';
						echo'<td></td>';
						echo'</tr>';

					}
				}
				if(isset($_SESSION['venue2']))
				{
					$sqls="SELECT * FROM specialspaces WHERE id IN (SELECT MIN(id) AS id FROM specialspaces GROUP BY sname )AND mid='$mid' AND sname='$venue'";
				$rs = querydb($sqls, $db_conn);
				$start=$rs[0]['start'];
				$end=$rs[0]['end'];
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
						echo'<tr>';
						echo'<td class="headcol">'.$value.'</td>';
						$sql = "SELECT * FROM specialspaces WHERE mid='$mid' AND sname='$venue' ORDER BY date";
						$rows = querydb($sql, $db_conn);
						// 運動
						echo'<td>';
							$sdate=$rows[0]['date'];
							$sqls = "SELECT * FROM specialspaces WHERE mid='$mid' AND sname='$venue' AND date='$date'";
							$rows = querydb($sqls, $db_conn);
							$sid=$rows[0]['sid'];
							$sqls="SELECT * FROM specialspacessport WHERE sid='$sid' GROUP BY sport ORDER BY sportid";
							$rows = querydb($sqls, $db_conn);
							foreach($rows as $row)
							{
								$ssport=$row['sport'];
								echo'<div class="sports" >'.$ssport.'</div>';
							}
						
						echo'</td>';
						// 運動尾
						//bar
						
						$sql = "SELECT * FROM specialspaces WHERE mid='$mid' AND sname='$venue' ORDER BY date";
						$rows = querydb($sql, $db_conn);
						$check=1;
						foreach($rows as $row)
							{
								
								echo'<td>';
								$date=$row['date'];
								$sid=$row['sid'];//7
								$sql2 = "SELECT * FROM specialspaces WHERE mid='$mid' AND sname='$venue' AND date='$date'";
								//SELECT * FROM specialspaces WHERE mid=8 AND sname='士林運動中心' AND date='2021/12/13'
								$row2 = querydb($sql, $db_conn);
								$true=count($row2)>0;
								$check=2;
								/*if($true)
								{
									$sql2="SELECT * FROM spacessport WHERE sid='$sid' ORDER BY sportid";
									$row3 = querydb($sql2, $db_conn);
									$sids=$sid;
									$sid=$row2[0]['sid'];
									$sqls="SELECT * FROM specialspacessport WHERE sid='$sid' ORDER BY sportid";
									//SELECT * FROM specialspacessport WHERE sid=1 ORDER BY sportid  2
									$rows = querydb($sqls, $db_conn);
									$count=count($rows);
									
									
									
								}
								else
								{
									$sqls="SELECT * FROM spacessport WHERE sid='$sid' ORDER BY sportid";
									$rows = querydb($sqls, $db_conn);
									$check=1;
								}*/
								$sqls="SELECT * FROM specialspacessport WHERE sid='$sid' ORDER BY sportid";
									$rows = querydb($sqls, $db_conn);
								$run=0;
								foreach($rows as $row)
								{
									$sportid=$row['sportid'];
									/*
									if($true)
									{
										$sql = "SELECT * FROM specialspacetime WHERE sid='$sid' AND sportid='$sportid' AND time='$value'";
										
										//SELECT * FROM specialspacetime WHERE sid=1 AND sportid=1 AND time='09:00-10:00'
										$rows = querydb($sql, $db_conn);
										$people=$rows[0]['people'];
										$limitpeople=$rows[0]['limitpeople'];
										$total=$limitpeople-$people;
										$per=($total/$limitpeople)*100;

										if($run%7==0)
										{
										$sportid=$row3[0]['sportid'];
										$sid=$sids;
										$sql = "SELECT * FROM spacetime WHERE sid='$sid' AND sportid='$sportid' AND time='$value'";
										
										$rows = querydb($sql, $db_conn);
										$people=$rows[0]['people'];
										$limitpeople=$rows[0]['limitpeople'];
										$total=$limitpeople-$people;
										$per=($total/$limitpeople)*100;
										}
										$run++;
									}
									else
									{
										$sql = "SELECT * FROM spacetime WHERE sid='$sid' AND sportid='$sportid' AND time='$value'";
										
										$rows = querydb($sql, $db_conn);
										$people=$rows[0]['people'];
										$limitpeople=$rows[0]['limitpeople'];
										$total=$limitpeople-$people;
										$per=($total/$limitpeople)*100;
									}
									*/
									// $rows = querydb($sql, $db_conn);
									// 	$people=$rows[0]['people'];
									// 	$limitpeople=$rows[0]['limitpeople'];
									// 	$total=$limitpeople-$people;
									// 	$per=($total/$limitpeople)*100;
									$sql = "SELECT * FROM specialspacetime WHERE sid='$sid' AND sportid='$sportid' AND time='$value'";
										
										$rows = querydb($sql, $db_conn);
										$people=$rows[0]['people'];
										$limitpeople=$rows[0]['limitpeople'];
										$total=$limitpeople-$people;
										$per=($total/$limitpeople)*100;
										
									
									
									if(is_nan($per))echo'';
									else
									{
										$per=number_format($per,1);
										echo'<div class="sports" ><a href="view.php?sportid='.$sportid.'&sid='.$sid.'&time='.$value.'&category='.$check.'"><img src="';
										if($per<=50)
										echo'images/blue.jpg';
										else if($per>50 &&$per<=80)
										echo'images/yellow.jpg';
										else if($per>80)
										echo'images/red.jpg';
										echo'"  width=';
										if($per==0)
											echo'1';
										else echo $per;
										echo'% height=10px alt=""><span>'.$per.'%</span></a></div>';

									}
								
									$run++;
								}
								echo'</td>';
								
							}
						
						//bar尾
						echo'</tr>';
						$first=$second;
						echo'<tr>';
						echo'<td class="headcol"></td>';
						echo'<td></td>';
						echo'<td></td>';
						echo'<td></td>';
						echo'<td></td>';
						echo'<td></td>';
						echo'<td></td>';
						echo'<td></td>';
						echo'<td></td>';
						echo'</tr>';

					}
				}
			  	
			  	
			 	
			  ?>
			  <!-- <tr>
				<td class="headcol">
					
				9:00-10:00
			    </td>
				<td>
				
				  <div class="sports" >籃球</div>
				  <div class="sports">羽球</div>
				  <div class="sports">排球</div>
				  <div class="sports">健身房</div>
				  <div class="sports">健身房</div>
				  <div class="sports">健身房</div>
				  <div class="sports">健身房</div>
				  <div class="sports">健身房</div>
				  
				</td>
				<td>
					
				  <div class="sports" ><a href=""><img src="images/blue.jpg"  width='10%' height='10px'alt=""><span>0%</span></a></div>
				  <div class="sports"><a href=""><img src="images/yellow.jpg"  width='20%' height='10px'alt=""></a></div>
				  <div class="sports"><a href=""><img src="images/red.jpg"  width='30%' height='10px'alt=""></a></div>
				  <div class="sports"><a href=""><img src="images/red.jpg"  width='40%' height='10px'alt=""></a></div>
				  <div class="sports"><a href=""><img src="images/red.jpg"  width='50%' height='10px'alt=""></a></div>
				  <div class="sports"><a href=""><img src="images/red.jpg"  width='60%' height='10px'alt=""></a></div>
				  <div class="sports"><a href=""><img src="images/red.jpg"  width='70%' height='10px'alt=""></a></div>
				  <div class="sports"><a href=""><img src="images/red.jpg"  width='80%' height='10px'alt=""></a></div>
				</td>
				<td>
				
				</td>
				<td>
					
				</td>
				<td>
				
				</td>
				<td>
					
				</td>
				<td>
				
				</td>
				<td>
					
				</td>
			  </tr>
			  
			  <tr>
				<td class="headcol"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			  </tr> -->
			  
			</tbody>
		  </table>
		  </div>
		  </div>
		  </div>
		</div>
		 
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