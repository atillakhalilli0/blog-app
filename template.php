<?php
include 'head.php';
//error_reporting(0);
$con = mysqli_connect('localhost', 'atilla1212', '12345', 'universitet');
echo '<div class="container">';
$tarix = date('Y-m-d H:i:s');
$sec = mysqli_query($con, "SELECT * FROM feed ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Feed</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>
<body>
<?php
if(isset($_POST['sil'])) {
    $haberinSahibi = mysqli_query($con, "SELECT user_id FROM feed WHERE id = ".$_POST['id']);
    $haber = mysqli_fetch_assoc($haberinSahibi);

    if ($haber['user_id'] == $_SESSION['user_id']) {
        echo '
        <div class="alert alert-warning" role="alert">
            Bu xəbəri silmək istədiyinizdən əminsiniz?
            <form method="post">
                <input type="hidden" name="id" value="'.$_POST['id'].'">
                <button type="submit" class="btn btn-warning btn-sm" name="d1">Hə</button>
                <button type="submit" class="btn btn-warning btn-sm" name="d2">Yox</button>
            </form>
        </div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Bu xəbəri silə bilməzsən!</div>';
    }
}

if(isset($_POST['d1'])) {
    $sil = mysqli_query($con, "DELETE FROM feed WHERE id = ".$_POST['id']);

    if($sil) {
        echo '<div class="alert alert-success" role="alert">Xəbər silindi!</div>';
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo '<div class="alert alert-danger" role="alert">Xəbər silinə bilmədi!</div>';
    }
} elseif(isset($_POST['d2'])) {
    echo '<div class="alert alert-info" role="alert">Silmə ləğv edildi!</div>';
}

$i = mysqli_num_rows($sec);
while ($info = mysqli_fetch_array($sec)) {
    echo
    '<div class="alert alert-secondary">
        <img src="" alt="Post Image">
        <h2>#'.$i.'<br>'.$info['basliq'].'</h2>
        <p>'.$info['basliq'].'</p>
        <p class="date">'.$info['tarix'].'</p>
        <p>
        <form method="post">
        <input type="hidden" name="id" value="' . $info['id'] . '">
        <input type="hidden" name="basliq" value="' . $info['basliq'] . '">
        <input type="hidden" name="melumat" value="' . $info['melumat'] . '">
        <button type="submit" name="sil" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash-fill"></i></button>
        </form>
    </div>';

    $i--;
}
?>

</body>
</html>
