<?php
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['parol']))
{echo '<meta http-equiv="refresh" content="0; url=feed.php">'; exit;}
?>


<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

<?php
error_reporting(0);
$con=mysqli_connect('localhost','atilla1212','12345','universitet');
$tarix=date('Y-m-d H:i:s');
echo'<div class="container">
<div class="alert alert-primary" style="text-align: center;" role="alert"><h2>BlogApp</h2></div>';

if(isset($_POST['daxilol']))
{
	$username=trim(strip_tags(htmlspecialchars(mysqli_real_escape_string($con,$_POST['username']))));
	$parol=trim(strip_tags(htmlspecialchars(mysqli_real_escape_string($con,$_POST['parol']))));
	
	$yoxla=mysqli_query($con," SELECT * FROM users WHERE username='".$username."' AND parol='".$parol."' ");
	if(mysqli_num_rows($yoxla)>0)
	{
		$info=mysqli_fetch_array($yoxla);

		$_SESSION['user_id']=$info['id'];
		$_SESSION['ad']=$info['ad'];
		$_SESSION['soyad']=$info['soyad'];
		$_SESSION['kurs']=$info['kurs'];
		$_SESSION['username']=$info['username'];
		$_SESSION['parol']=$info['parol'];
		echo '<meta http-equiv="refresh" content="0; url=feed.php">'; exit;
	}
}

if(isset($_POST['d']))
{
	$ad=trim(strip_tags(htmlspecialchars(mysqli_real_escape_string($con,$_POST['ad']))));
	$soyad=trim(strip_tags(htmlspecialchars(mysqli_real_escape_string($con,$_POST['soyad']))));
	$kurs=trim(strip_tags(htmlspecialchars(mysqli_real_escape_string($con,$_POST['kurs']))));
	$username=trim(strip_tags(htmlspecialchars(mysqli_real_escape_string($con,$_POST['username']))));
	$parol=trim(strip_tags(htmlspecialchars(mysqli_real_escape_string($con,$_POST['parol']))));

	if(!empty($ad) && !empty($soyad) && !empty($kurs) && !empty($username) && !empty($parol))
		{
			$yoxla=mysqli_query($con," SELECT * FROM users WHERE username='".$username."' ");

			if(mysqli_num_rows($yoxla)==0)
			{
					$daxilet=mysqli_query($con," INSERT INTO users (ad,soyad,kurs,tarix,username,parol)
					 VALUES ('".$ad."','".$soyad."','".$kurs."','".$tarix."','".$username."','".$parol."')");

					if($daxilet==true)
						{echo '<div class="alert alert-success" role="alert">Ugurla qeydiyyatdan kecdiniz!</div>';}
					else
						{echo '<div class="alert alert-danger" role="alert">Siz qeydiyyatdan kece bilmediniz!</div>';}
			}
			else
				{echo '<div class="alert alert-warning" role="alert">Bu istifadeci qeydiyyatdan kecirilib!</div>';}
		}
		else
			{echo '<div class="alert alert-warning" role="alert">Zehmet olmasa melumatlari duzgun doldurun!</div>';}
}

$sec=mysqli_query($con,"SELECT * FROM users ORDER BY id DESC");

$say=mysqli_num_rows($sec);
echo'<div style="text-align: center;" class="alert alert-info" role="alert">Bazada <b>'.$say.'</b> user var<br><br></div>';

if(!isset($_POST['edit']))
{
	echo'
	<div class="container" style="width: 900px;text-align:center;">

	<div class="alert alert-warning" role="alert">Blog proqramında işləmək üçün lütfən ya qeydiyyatdan keçin, ya da sistemə daxil olun</div>
			<div class="alert alert-info" style="display: flex;" role="alert">
				<form method="post" style="margin-left:60px" enctype="multipart/form-data">
					<h3>Qeydiyyatdan Keç</h3>	
					Ad:<br>
					<input type="text" name="ad" class="form-control" autocomplete="off" value="'.$_POST['ad'].'">
					Soyad:<br>
					<input type="text" name="soyad" class="form-control" autocomplete="off" value="'.$_POST['soyad'].'">
					Kurs:<br>
					<input type="text" name="kurs" class="form-control" autocomplete="off" value="'.$_POST['kurs'].'">
					Username:<br>
					<input type="text" name="username" class="form-control" autocomplete="off" value="'.$_POST['username'].'">
					Parol:<br>
					<input type="password" name="parol" class="form-control" autocomplete="off" value="'.$_POST['parol'].'"><br>
					<button type="submit" name="d"  class="btn btn-primary btn-sm ">Qeydiyyatdan keç</button>
				</form>

				<div class="alert alert-info" role="alert">
				<form method="post" style="margin-left:150px;">
					<h3>Daxil Ol</h3>
					Username:<br>
					<input class="form-control mr-sm-2" type="text" placeholder="username" aria-label="Search" name="username"><br>
					Password:
					<input class="form-control mr-sm-2" type="password" placeholder="parol" aria-label="Search" name="parol"><br>
					<button class="btn btn-success my-2 my-sm-0" type="submit" name="daxilol">Daxil ol</button>
				</form></div>
			</div>';
}

?>
