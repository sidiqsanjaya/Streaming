<?php
include "config.php";
if(!$shelogin){
    header("location:?id=login");
   exit;
 }

$iduser = $_SESSION['id_user'];
//get data post
$komen = $_POST['comment'];
$idv = $_POST['idvid'];

 $ok = mysqli_query($conn, "INSERT INTO `comment_video` (`id`, `id_user`, `id_video`, `comment`, `comment_at`) VALUES (NULL, '$iduser', '$idv', '$komen', CURRENT_TIMESTAMP())");
if($ok){
  echo "comment added";
}else{
  echo "failed to added comment";
}

?>