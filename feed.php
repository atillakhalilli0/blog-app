<?php
include 'head.php';
//error_reporting(0);
echo '<div class="container">';
$con = mysqli_connect('localhost', 'atilla1212', '12345', 'universitet');
$tarix = date('Y-m-d H:i:s');

if (isset($_POST['d'])) {
    $basliq = trim(strip_tags(htmlspecialchars(mysqli_real_escape_string($con, $_POST['basliq']))));
    $melumat = trim(strip_tags(htmlspecialchars(mysqli_real_escape_string($con, $_POST['melumat']))));

    if (!empty($basliq) && !empty($melumat)) {
        if (!isset($_FILES['foto']['name']) || $_FILES['foto']['size'] == 0) {
            $unvan = '';
        } else {
            include 'upload.php';
            if (isset($error)) {
                echo $error;
                return;
            }
        }

        $daxilet = mysqli_query($con, "INSERT INTO feed (basliq,melumat,foto,tarix,user_id) 
        VALUES ('" . $basliq . "','" . $melumat . "','" . $unvan . "','" . $tarix . "','" . $_SESSION['user_id'] . "')");

        if ($daxilet == true) {
            echo '<div class="alert alert-success" role="alert">Xəbər paylaşıldı!</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Xəta baş verdi!</div>';
        }
    }
}

if (!isset($_POST['edit'])) {
    echo '
	<div class="alert alert-primary" role="alert">
	<form method="post" enctype="multipart/form-data">
	Basliq:<br>
	<input type="text" class="form-control" name="basliq">
	Melumat:<br>
	<input type="text" class="form-control" name="melumat">
	Foto:<br>
	<input type="file" class="form-control" name="foto">
	<button type="submit" class="btn btn-primary btn-sm" name="d">OK</button>
	</form>
	</div>';
}

?>

