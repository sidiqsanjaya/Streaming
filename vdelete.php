<?php
if(!$shelogin){
    header("location:$domain?id=login");
    exit;
  }
  $get = $_GET['on'];
  $idvid = openssl_decrypt(base64_decode($get), $_SESSION["cypherMethod"],  $_SESSION["key"], $options=0, $_SESSION["iv"]);
  $tempuser = $_SESSION['id_user'];
  //validasi user memiliki video tsb atau tidak
  $sqlcheck = mysqli_query($conn, "SELECT `video`.`id_video`, `account`.`id_user` FROM `video` LEFT JOIN `account` ON `video`.`id_user` = `account`.`id_user` WHERE `video`.`id_video` = '$idvid' AND `account`.`id_user` = '$tempuser' ");

  $vdell= mysqli_query($conn, "SELECT `video`.*, `data_video`.* FROM `video` LEFT JOIN `data_video` ON `data_video`.`id_video` = `video`.`id_video` WHERE `video`.`id_video` = '$idvid'");    
    while($delete = mysqli_fetch_array($vdell)){
        $d480 = $delete['480'];
        $d720 = $delete['720']; 
        $d1080 = $delete['1080']; 
        $dgambar = $delete['gambar']; 
        }
        if($featuredelete == 'on'){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                if(mysqli_num_rows($sqlcheck) == 1){ 
                        unlink($d480);
                        unlink($d720);
                        unlink($d1080);
                        unlink($dgambar);
                        $sqldelete = mysqli_query($conn, "DELETE FROM `video` WHERE `video`.`id_video` = '$idvid'");
                        //mysqli_error($sqldelete);
                        $error = "deleting data is complete";
                        header( "refresh:5;url=$domain?id=listdata" );
                }else{
                        $error = "this data has been deleted / not found";
                        header( "refresh:5;url=$domain?id=listdata" );
                }
            } 
        }else{
            $error = "Sorry, this function is currently disabled, please try again later."; 
        }
  
if(mysqli_num_rows($sqlcheck) == 1){ 
?>
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-auto center">
         <h3>are you sure to delete the video?</3>
        </div>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-md-auto center">
            <form method="post" href="<?php echo $domain."?dell&on=".$get;?>">
            <button type="submit" class="btn btn-danger">Yes</button>
            </form>
        </div>
        <div class="col-md-auto center">
            <button type="button" onclick="window.history.back()" class="btn btn-primary">no</button>
        </div>
    </div>
    <span class="center"><?php echo $error;?></span>
</div>
<?php
}else{
    include "error403.php";
}
?>