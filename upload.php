<?php
   if(!$shelogin){
     header("location:?id=login");
    exit;
  }

//error_reporting(0);
//init
$error_detail = $title_err = $genre_err = $Sinopsis_err = $Produksi_err = $Rilis_err =$gambar_error = $video_error = '';
//send back value
$judul = $genre = $produksi = $rilis = $sinopsi = '';
if($featureupload == 'on'){
  if($_SERVER["REQUEST_METHOD"] == "POST"){
                  //include "config.php";                
                  $id_video = substr(md5(time()), 0, 16);
                  //get post video
                  $folder ='./disk/';
                  $video  = $_FILES['filevideo']['tmp_name'];
                  $video_n= $_FILES['filevideo']['name'];
                  $pict   = $_FILES['filegambar']['tmp_name'];
                  $pict_n = $_FILES['filegambar']['name'];
                  
                  
                  $extension_img = array('png','jpg');
                  $ex = explode('.', $pict_n);
                  $ext = strtolower(end($ex));

                  $extension_video = array('MKV','mp4');
                  $ex2 =explode('.', $video_n);
                  $ext2=strtolower(end($ex2));

                  $rename = $id_video.".".$ext;
                  //ffmpeg
                 //echo $rename;
                  $ffmpeg = "ffmpeg";

                  //duration
                  $time = $result = shell_exec("$ffmpeg -i ".$video." 2>&1 | grep Duration | cut -d ' ' -f 4 | sed s/,//");
                  

                  //get post and validate
                  if(empty(trim($_POST['judul']))){
                    $title_err = "Please enter a title.";
                }elseif(strlen(trim($_POST['judul'])) < 4){
                    $title_err = "title must have atleast 4 characters";
                    $judul   = $_POST['judul'];
                }elseif(strlen(trim($_POST['judul'])) >200){
                    $title_err = "maximum title 200 characters";
                    $judul   = $_POST['judul'];
                }elseif(!preg_match('/^[1-9a-zA-Z ]*$/', $_POST['judul'])){
                    $title_err = "<p class='text-danger'>text input like that is prohibited</p>";
                    $judul   = $_POST['judul'];
                }else{
                    $judul   = $_POST['judul'];
                }
                
                if(empty(trim($_POST['Genre']))){
                    $genre_err = "Please enter a genre.";
                }elseif(strlen(trim($_POST['Genre'])) < 2){
                    $genre_err = "genre must have atleast 2 characters";
                    $genre   = $_POST['Genre'];
                }elseif(strlen(trim($_POST['Genre'])) >100){
                    $genre_err = "maximum genre leght 100 characters";
                    $genre   = $_POST['Genre'];
                }elseif(!preg_match('/^[1-9a-zA-Z,. ]*$/', $_POST['Genre'])){
                    $genre_err = "<p class='text-danger'>text input like that is prohibited</p>";
                    $genre   = $_POST['Genre'];
                }else{
                    $genre   = $_POST['Genre'];
                }
        
                if(empty(trim($_POST['Produksi']))){
                    $Produksi_err = "Please enter a Produksi.";
                }elseif(strlen(trim($_POST['Produksi'])) < 2){
                    $Produksi_err = "Produksi must have atleast 2 characters";
                    $produksi   = $_POST['Produksi'];
                }elseif(strlen(trim($_POST['Produksi'])) >50){
                    $Produksi_err = "maximum Produksi leght 50 characters";
                    $produksi   = $_POST['Produksi'];
                }elseif(!preg_match('/^[1-9a-zA-Z ,.-]*$/', $_POST['Produksi'])){
                    $Produksi_err = "<p class='text-danger'>text input like that is prohibited</p>";
                    $produksi   = $_POST['Produksi'];
                }else{
                    $produksi   = $_POST['Produksi'];
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
                    $rilis   = $_POST['Rilis'];
                }elseif(strlen(trim($_POST['Rilis'])) >10){
                    $Rilis_err = "maximum date release 10 characters";
                    $rilis   = $_POST['Rilis'];
                }elseif(!validateDate($_POST['Rilis'], 'Y-m-d')){
                    $Rilis_err = "<p class='text-danger'>text input like that is prohibited</p>";
                    $rilis   = $_POST['Rilis'];
                }else{
                    $rilis   = $_POST['Rilis'];
                }
        
                if(empty(trim($_POST['Sinopsis']))){
                    $Sinopsis_err = "Please enter a Sinopsis.";
                }elseif(strlen(trim($_POST['Sinopsis'])) < 1){
                    $Sinopsis_err = "Sinopsis must have atleast 1 characters";
                    $sinopsi   = $_POST['Sinopsis'];
                }elseif(strlen(trim($_POST['Sinopsis'])) >10000){
                    $Sinopsis_err = "maximum Sinopsis 10000 characters";
                    $sinopsi   = $_POST['Sinopsis'];
                }else{        
                    $sinopsi   = $_POST['Sinopsis'];
                }
                

                $disable = 1;
            if($disable == 0){
              if(empty($error_detail) && empty($title_err) && empty($genre_err) && empty($Sinopsis_err) && empty($Produksi_err) && empty($Rilis_err) && empty($gambar_error) && empty($video_error)){
                if(in_array($ext2, $extension_video) == true){
                  if(in_array($ext, $extension_img) == true){
                    for ($preset = 0; $preset <=3; $preset++) {
                      switch ($preset) {
                        case 0 :
                        //480p
                        $bitrate_rate = '1100k';
                        $bitrate_total = '1200k';
                        $resolution = '845x480';
                        $fps = 60; 
                        $file = "$folder$resolution$id_video.mp4";

                        $command = "$ffmpeg -i $video -c:v h264_nvenc -s $resolution -preset fast -b:v $bitrate_rate -maxrate $bitrate_total -bufsize $bitrate_total -filter:v fps=fps=$fps $file";
                          shell_exec($command);
                          $converter480p = "OK";
                        break;
                        case 1 :
                        //720p
                        $bitrate_rate = '2200k'; 
                        $bitrate_total = '2300k';
                        $resolution = '1280x720';
                        $fps = 60; 
                        $file = "$folder$resolution$id_video.mp4";

                        $command = "$ffmpeg -i $video -c:v h264_nvenc -s $resolution -preset fast -b:v $bitrate_rate -maxrate $bitrate_total -bufsize $bitrate_total -filter:v fps=fps=$fps $file";
                          shell_exec($command);
                          $converter720p = "OK";
                        break;
                        case 2 :
                        //1080p
                        $bitrate_rate = '3000k'; 
                        $bitrate_total = '3200k';
                        $resolution = '1920x1080';
                        $fps = 60; 
                        $file = "$folder$resolution$id_video.mp4";

                        $command = "$ffmpeg -i $video -c:v h264_nvenc -s $resolution -preset fast -b:v $bitrate_rate -maxrate $bitrate_total -bufsize $bitrate_total -filter:v fps=fps=$fps $file";
                          shell_exec($command);
                          $converter1080p = "OK";
                        break;
                        case 3 :
                                $iduser          = $_SESSION['id_user'];
                                $param_judul     = $judul;
                                $param_genre     = $genre;
                                $param_produksi  = $produksi;
                                $param_rilis     = $rilis;
                                $param_durasi    = $time;
                                $param_sinopsis  = $sinopsi;
                                $param_thumbnail = $folder.$rename;
                                
                                move_uploaded_file($pict, $param_thumbnail);
                                $sql="INSERT INTO video VALUES (NULL, '$iduser', '$id_video', '$param_judul', '$param_genre', '$param_produksi', '$param_durasi', '$param_rilis', '$param_sinopsis', '$param_thumbnail', 0,CURRENT_TIMESTAMP)";
                                
                                  $upload=mysqli_query($conn, $sql);
                                  if ($upload){
                                    $resolution1    = '845x480';
                                    $param_480p     = "$folder$resolution1$id_video.mp4";
                                    $resolution2    = '1280x720';
                                    $param_720p     = "$folder$resolution2$id_video.mp4";
                                    $resolution3    = '1920x1080';
                                    $param_1080     = "$folder$resolution3$id_video.mp4";

                                    $sql2 ="INSERT INTO `data_video` VALUES (NULL, '$id_video', '$param_480p', '$param_720p', '$param_1080')";
                                    $upload2=mysqli_query($conn, $sql2);
                                    if($upload2){
                                      $error_detail = '<div class="p-3 mb-2 bg-success text-white">OK</div>';
                                    }else{
                                      $error_detail = '<div class="p-3 mb-2 bg-secondary text-white">failed to upload.. try again later</div>';
                                      echo mysqli_error($conn);
                                      unlink("$param_thumbnail");
                                      unlink("$param_480p");
                                      unlink("$param_720p");
                                      unlink("$param_1080");
                                      mysqli_query($conn, "DELETE FROM `video` WHERE `video`.`id_video` = '$id_video'");
                                  }
                                  }else{
                                    $error_detail = '<div class="p-3 mb-2 bg-secondary text-white">failed to upload.. try again later</div>';;
                                    echo mysqli_error($conn);
                                  }
                        break;
                      }
                    }                
                  }else{
                    $gambar_error = '<div class="p-3 mb-2 bg-secondary text-white">Extensions allowed png, jpg.</div>';
                  }
                }else{
                  $video_error = '<div class="p-3 mb-2 bg-secondary text-white">Extensions allowed MKV, MP4.</div>';
                }
              }
            }

  }
}else{
  $error_detail = "Sorry, this function is currently disabled, please try again later."; 
}
?>
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <form method="POST" action="<?php echo $domain;?>?id=upload" enctype="multipart/form-data">
                <font size=6>upload video</font>

                <div class="form-group row">
                  <label for="inputvideo" class="col-sm-2 col-form-label">video</label>
                  <div class="col-sm-10">
                    <input type="file" class="form-control" accept="video/mp4, video/mkv" id="inputvideo" name="filevideo" required></input>
                    <span><?php echo $video_error; ?></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputthumb" class="col-sm-2 col-form-label">Thumbnails</label>
                  <div class="col-sm-10">
                    <input type="file" class="form-control" accept="image/jpg, image/png" id="inputthumb" name="filegambar" required></input>
                    <span><?php echo $gambar_error; ?></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="judul" class="col-sm-2 col-form-label">Title</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="judul" value="<?php echo $judul; ?>" placeholder="insert title" name="judul" size="200" minlength="4" maxlength="200" required>
                    <span><?php echo $title_err; ?></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="genre" class="col-sm-2 col-form-label">Genre</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="genre" value="<?php echo $genre; ?>" placeholder="insert Genre" name="Genre" size="100" minlength="2" maxlength="100" required>
                    <span><?php echo $genre_err; ?></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="produksi" class="col-sm-2 col-form-label">Production</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="produksi" value="<?php echo $produksi; ?>"  placeholder="insert produksi" name="Produksi" size="50" minlength="2" maxlength="50" required>
                    <span><?php echo $Produksi_err; ?></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="rilis" class="col-sm-2 col-form-label">release</label>
                  <div class="col-sm-10">
                    <input type="date" class="form-control" id="rilis" value="<?php echo $rilis; ?>" name="Rilis" required>
                    <span><?php echo $Rilis_err; ?></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="sinopsis" class="col-sm-2 col-form-label">Synopsis</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" id="sinopsis" name="Sinopsis" size="10000" minlength="1" maxlength="10000" required><?php echo $sinopsi; ?></textarea>
                    <span><?php echo $Sinopsis_err; ?></span>
                  </div>
                </div>
                <center>
                <button type="submit" class="btn btn-primary">Submit</button> 
                <button type="reset"  class="btn btn-danger">reset upload</button>
                <div> 
				          <span class="help-block"><?php echo "$error_detail"; ?></span>             
                </div>
                </center>
              </div>
            </div>
          </div>
        </div>
      </div>