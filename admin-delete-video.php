<?php
if(!$shelogin){
    header("location:$domain?id=login");
    exit;
 }elseif($_SESSION['level'] == 'client'){
    header( "refresh:5;url=$domain?id=home" );
    include "error403.php";
    exit;
 }

$error ="";
$on = $_GET['on'];
$ondecry = openssl_decrypt(base64_decode($on), $_SESSION["cypherMethod"],  $_SESSION["key"], $options=0, $_SESSION["iv"]);
echo $ondecry;

 $sqloutput = mysqli_query($conn, "SELECT `video`.*, `data_video`.* FROM `video` LEFT JOIN `data_video` ON `data_video`.`id_video` = `video`.`id_video` WHERE `video`.`id_video` = '$ondecry'");
while($data = mysqli_fetch_array($sqloutput)){
    $dataid     = $data['id_video'];
    $datajudul  = $data['judul'];
    $datagambar = $data['gambar'];
    $data480    = $data['480'];
    $data720    = $data['720'];
    $data1080   = $data['1080'];
}

if($_POST['destroyIt'] == 1){
        $row = mysqli_num_rows($sqloutput);
        if($row == 1){
            unlink("$datagambar");
            unlink("$data480");
            unlink("$data720");
            unlink("$data1080");
            $sqldelmusic =  mysqli_query($conn,"DELETE FROM `video` WHERE `video`.`id_video` = '$dataid'");
            header( "refresh:5;url=$domain" ); 
        }elseif($row == 0){
            $error = "this data has been deleted / not found";
            include "error404.php";
            header( "refresh:5;url=$domain" );    
        }
}

?>

<div class="row justify-content-center">
    <div class="card o-hidden border-0 my-5">
        <div class="card-body p-12">
            <div class="col-lg-12">
                <form method="POST" action="?id=management-delete-video&on=<?php echo $on; ?>" enctype="multipart/form-data">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">video id</th>
                            <th scope="col">title</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td><?php echo $dataid; ?></td>
                            <td><?php echo $datajudul; ?></td>
                            </tr>   
                        </tbody>
                    </table>
                    <div>
                        <button type=submit name="destroyIt" value="1" class="btn btn-danger">accept</button>
                        <button  onclick="location.href='<?php echo $domain;?>'" type="button" class="btn btn-primary">cancel</button>
                    </div>
                    <a><?php echo $error; ?></a>
                </form>
            </div>
        </div>
    </div>
</div>

