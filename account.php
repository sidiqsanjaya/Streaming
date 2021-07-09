<?php 
 if(!$shelogin){
     header("location:?id=login");
    exit;
  }

$fullname_err = $country_err = $err = '';
if($featuredetailaccount == 'on'){    
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["fullname"]))){
        $fullname_err = "Please enter a fullname.";
    }elseif(strlen(trim($_POST["fullname"])) < 6){
        $fullname_err = "fullname must have atleast 6 characters";
    }elseif(strlen(trim($_POST["fullname"])) >30){
        $fullname_err = "maximum fullname 30 characters";
    }elseif(!preg_match('/^[1-9a-zA-Z ]*$/', $_POST["fullname"])){
        $fullname_err = "<p class='text-danger'>text input like that is prohibited</p>";
    }else{
        $fullname   = $_POST['fullname'];
    }

    if(empty(trim($_POST["country"]))){
        $country_err = "Please enter you country.";
    }elseif(strlen(trim($_POST["country"])) < 2){
        $country_err = "Country names less than 2 are there?";
    }elseif(strlen(trim($_POST["country"])) >20){
        $country_err = "maximum coutry name 20 characters";
    }elseif(!preg_match('/^[1-9a-zA-Z ]*$/', $_POST["country"])){
        $country_err = "<p class='text-danger'>text input like that is prohibited</p>";
    }else{
        $country    = $_POST['country'];
    }

    $folder = "./img/";
    $pict   = $_FILES['profile']['tmp_name'];
    $pict_n = $_FILES['profile']['name'];             
    $extension_img = array('png','jpg');
    $ex = explode('.', $pict_n);
    $ext = strtolower(end($ex));
    

    if(empty($fullname_err) && empty($country_err)){
        $tempiduser = $_SESSION['id_user'];
        $sqlcheck = "SELECT id_user FROM detail_user WHERE id_user = '$tempiduser'";
        if($stmt = mysqli_prepare($conn, $sqlcheck)){
            mysqli_stmt_bind_param($stmt, "s", $param_iduser);
            $param_iduser = trim($tempiduser); 

            $rename = $folder.$tempiduser.".".$ext; 

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    unlink("$rename");
                    $sqlupdate = "UPDATE `detail_user` SET `fullname` = '$fullname', `country` = '$country', `img` = '$rename' WHERE `detail_user`.`id_user` = '$tempiduser' ";
                    mysqli_query($conn,$sqlupdate);
                    move_uploaded_file($pict, $rename);
                    header( "refresh:5;url=$domain" );

                } else{
                    move_uploaded_file($pict, $rename);
                    $sqlinsert = "INSERT INTO `detail_user` VALUES (NULL, '$tempiduser', '$fullname', '$country', '$rename')";
                    mysqli_query($conn,$sqlinsert);
                    header( "refresh:5;url=$domain" );
                }
            } else{
                $err = '<div class="p-3 mb-2 bg-secondary text-white">Oops! Something went wrong. Please try again later.</div>';
            }
            mysqli_stmt_close($stmt);
        } 
    }
    
  }
}else{
  $err = "Sorry, this function is currently disabled, please try again later."; 
}
  //cek nama dg country sudah diisi blm
$tempiduser = $_SESSION['id_user'];
$sqldata = "SELECT fullname, country FROM detail_user WHERE id_user = '$tempiduser'";
$hasil = mysqli_query($conn,$sqldata);
$qsql = mysqli_num_rows($hasil);
if($qsql= 1){
    while($hasil2=mysqli_fetch_array($hasil)){
    $data_fullname  = $hasil2['fullname'];
    $data_country   = $hasil2['country'];
    }
}else{
    $data_fullname  = "";
    $data_country   = "";
}

?>

<div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <form method="POST" action="<?php echo $domain;?>?id=account" enctype="multipart/form-data">
                <font size=6>account</font>
                <div class="form-group row">
                  <label for="inputthumb" class="col-sm-2 col-form-label">Profile</label>
                  <div class="col-sm-10">
                    <input type="file" class="form-control" accept="image/jpg, image/png" id="inputthumb" name="profile" required></input>
                    <span><?php echo $gambar_error; ?></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="fullname" class="col-sm-2 col-form-label">full name</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="fullname" value="<?php echo htmlspecialchars($data_fullname); ?>" placeholder="insert full name" name="fullname" size="30" minlength="6" maxlength="30" required>
                    <span class="help-block"><?php echo $fullname_err; ?></span>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="country" class="col-sm-2 col-form-label">country</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="country" value="<?php echo htmlspecialchars($data_country); ?>" placeholder="insert name country" name="country" size="20" minlength="2" maxlength="20" required>
                    <span class="help-block"><?php echo $country_err; ?></span>
                  </div>
                </div>
                <center>
                <button type="submit" class="btn btn-primary">Submit</button> 
                <button type="reset"  class="btn btn-danger">reset </button>
                <div> 
				    <span class="help-block"><?php echo "| Status : ".$err."|"; ?></span>             
                </div>
                </center>
              </div>
            </div>
          </div>
        </div>
      </div>
