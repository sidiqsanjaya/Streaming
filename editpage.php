<?php
if(!$shelogin){
  header("location:$domain?id=login");
  exit;
}
$get = $_GET['on'];
$idvid = openssl_decrypt(base64_decode($get), $_SESSION["cypherMethod"],  $_SESSION["key"], $options=0, $_SESSION["iv"]);
$tempuser = $_SESSION['id_user'];
//validasi
$sqlcheck = mysqli_query($conn, "SELECT `video`.`id_video`, `account`.`id_user` FROM `video` LEFT JOIN `account` ON `video`.`id_user` = `account`.`id_user` WHERE `video`.`id_video` = '$idvid' AND `account`.`id_user` = '$tempuser' ");


//inisialisasi
$err = $title_err = $genre_err = $Produksi_err = $Rilis_err = $Sinopsis_err = '';
if($featureedit== 'on'){
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        //validasi
        if(empty(trim($_POST['judul']))){
            $title_err = "Please enter a title.";
        }elseif(strlen(trim($_POST['judul'])) < 6){
            $title_err = "title must have atleast 6 characters";
        }elseif(strlen(trim($_POST['judul'])) >200){
            $title_err = "maximum title 200 characters";
        }elseif(!preg_match('/^[1-9a-zA-Z ]*$/', $_POST['judul'])){
            $title_err = "<p class='text-danger'>text input like that is prohibited</p>";
        }else{
            $judul   = $_POST['judul'];
        }
        
        if(empty(trim($_POST['Genre']))){
            $genre_err = "Please enter a genre.";
        }elseif(strlen(trim($_POST['Genre'])) < 2){
            $genre_err = "genre must have atleast 2 characters";
        }elseif(strlen(trim($_POST['Genre'])) >100){
            $genre_err = "maximum genre leght 100 characters";
        }elseif(!preg_match('/^[1-9a-zA-Z,. ]*$/', $_POST['Genre'])){
            $genre_err = "<p class='text-danger'>text input like that is prohibited</p>";
        }else{
            $genre   = $_POST['Genre'];
        }

        if(empty(trim($_POST['Produksi']))){
            $Produksi_err = "Please enter a Produksi.";
        }elseif(strlen(trim($_POST['Produksi'])) < 2){
            $Produksi_err = "Produksi must have atleast 2 characters";
        }elseif(strlen(trim($_POST['Produksi'])) >50){
            $Produksi_err = "maximum Produksi leght 50 characters";
        }elseif(!preg_match('/^[1-9a-zA-Z ,.-]*$/', $_POST['Produksi'])){
            $Produksi_err = "<p class='text-danger'>text input like that is prohibited</p>";
        }else{
            $Produksi   = $_POST['Produksi'];
        }

        function validateDate($date, $format = 'Y-m-d H:i:s')
        {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
        }

        if(empty(trim($_POST['Rilis']))){
            $Rilis_err = "Please enter a release date.";
        }elseif(strlen(trim($_POST['Rilis'])) < 6){
            $Rilis_err = "release date must have atleast 6 characters";
        }elseif(strlen(trim($_POST['Rilis'])) >10){
            $Rilis_err = "maximum date release 10 characters";
        }elseif(!validateDate($_POST['Rilis'], 'Y-m-d')){
            $Rilis_err = "<p class='text-danger'>text input like that is prohibited</p>";
        }else{
            $rilis   = $_POST['Rilis'];
        }

        if(empty(trim($_POST['Sinopsis']))){
            $Sinopsis_err = "Please enter a Sinopsis.";
        }elseif(strlen(trim($_POST['Sinopsis'])) < 1){
            $Sinopsis_err = "Sinopsis must have atleast 1 characters";
        }elseif(strlen(trim($_POST['Sinopsis'])) >10000){
            $Sinopsis_err = "maximum Sinopsis 10000 characters";
        }else{       
            $Sinopsis   = $_POST['Sinopsis'];       
        }
        
        
        if(empty($Rilis_err) && empty($Sinopsis_err) && empty($title_err) && empty($genre_err) && empty($Produksi_err)){
           $sqlupdate = "UPDATE `video` SET `judul` = '$judul', `genre` = '$genre', `produksi` = '$Produksi', `rilis` = '$rilis', `sinopsis` = '$Sinopsis' WHERE `video`.`id_video` = '$idvid'";
            $check = mysqli_query($conn,$sqlupdate);
           if($check){
                $err = "data has been changed successfully";
                header( "refresh:5;url=$domain?id=listdata" );
            }else{
                $err = mysqli_error($conn);
                //$err ="failed, try again later";
            }
        }
        
    }
}else{
    $err = "Sorry, this function is currently disabled, please try again later."; 
}


if(mysqli_num_rows($sqlcheck) == 1){
    $video = mysqli_query($conn, "SELECT `detail_user`.`fullname`, `detail_user`.`country`, `video`.* FROM `detail_user` , `video` WHERE `video`.`id_video` = '$idvid'");
?>

<?php while($v=mysqli_fetch_array($video)){ ?>
    <form method="POST" action="<?php echo $domain;?>?id=edit&on=<?php echo $get; ?>" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-12">
            <p class="lead text-center text-capitalize text-body" style="color: black;"><?php echo $v['judul'];?></p>
          </div>
        </div>       
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped table-dark">
                <thead>
                  <tr>                   
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Title</td>
                    <td>
                        <input type="text" value="<?php echo htmlspecialchars($v['judul']);?>" class="form-control" name="judul" placeholder="name@example.com">
                        <span class="help-block"><?php echo $title_err; ?></span>  
                    </td>
                  </tr>
                  <tr>
                    <td>Genre</td>
                    <td>
                        <input type="text" value="<?php echo htmlspecialchars($v['genre']);?>" class="form-control" name="Genre" placeholder="genre video">
                        <span class="help-block"><?php echo $genre_err; ?></span> 
                        </td>
                  </tr>
                  <tr>
                    <td>Production</td>
                    <td>
                        <input type="text" value="<?php echo htmlspecialchars($v['produksi']);?>" class="form-control" name="Produksi" placeholder="nname production">
                        <span class="help-block"><?php echo $Produksi_err; ?></span> 
                        </td>
                  </tr>
                  <tr>
                    <td>Duration</td>
                    <td>
                        <input type="text" value ="<?php echo htmlspecialchars($v['durasi']);?>" class="form-control" readonly>
                        </td>
                  </tr>
                  <tr>
                    <td>release</td>
                    <td>
                        <input type="date" class="form-control" value="<?php echo htmlspecialchars($v['rilis']);?>" name ="Rilis">
                        <span class="help-block"><?php echo $Rilis_err; ?></span> 
                        </td>
                  </tr>
                  <tr>
                    <td>Sinopsis</td>
                    <td>
                        <textarea class="form-control"  name="Sinopsis" required><?php echo htmlspecialchars($v['sinopsis']);?></textarea>
                        <span class="help-block"><?php echo $Sinopsis_err; ?></span> 
                        </td>
                  </tr>
                  <tr>
                    <td>Uploader</td>
                    <td><?php echo htmlspecialchars($v['fullname']);?></td>
                  </tr>
                  <tr>
                    <td>Uploader from </td>
                    <td><?php echo htmlspecialchars($v['country']);?></td>
                  </tr>
                </tbody>
              </table>
              <center>
                <button type="submit" class="btn btn-primary">Submit</button> 
                <button type="reset"  class="btn btn-danger">reset upload</button>
                <div> 
				          <span class="help-block"><?php echo "| Status : ".$err." |"; ?></span>             
                </div>
                </center>
            </div>
          </div>
    </form>    
    <?php } ?>


<?php
}else{
include "error403.php"; 
}
?>