<?php
if(!$shelogin){
    header("location:$domain?id=login");
    exit;
 }elseif($_SESSION['level'] == 'client'){
    header( "refresh:5;url=$domain?id=home" );
    include "error403.php";
    exit;
 }
//init
$error = '';

$on = $_GET['on'];
$ondecry = openssl_decrypt(base64_decode($on), $_SESSION["cypherMethod"],  $_SESSION["key"], $options=0, $_SESSION["iv"]);

$sqluser = mysqli_query($conn, "SELECT * FROM account WHERE id_user = '$ondecry'");
while($fetch = mysqli_fetch_array($sqluser)){
    $dataid = $fetch['id_user'];
    $dataun = $fetch['username'];
}

$row = mysqli_num_rows($sqluser);
if($_POST['destroythisuser'] == 1)
    if($row == 1){
        $datavideo = mysqli_query($conn, "SELECT `video`.*, `data_video`.*
        FROM `video` 
            LEFT JOIN `data_video` ON `data_video`.`id_video` = `video`.`id_video`
        WHERE `video`.`id_user` = '$ondecry'");
        while($delete = mysqli_fetch_array($datavideo)){
            $datagambar = $delete['gambar'];
            $data480 = $delete['480'];
            $data720 = $delete['720'];
            $data1080 = $delete['1080'];

            unlink("$datagambar");
            unlink("$data480");
            unlink("$data720");
            unlink("$data1080");
        }
        if($row == 1){
            $cek = mysqli_query($conn, "DELETE FROM `account` WHERE `account`.`id_user` = '$dataid' AND `account`.`username` = '$dataun'");
            mysqli_error($conn);
            $error = "OK";
            header("location:$domain?id=home");
        }
    }

if($row == 1){
?>
<div class="row justify-content-center">
    <div class="card o-hidden border-0 my-5">
        <div class="card-body p-12">
        <center><p>do you really want delete all data on this user?</p></center>
            <div class="col-lg-12">
                <form method="POST" action="?id=management-delete&on=<?php echo $on; ?>" enctype="multipart/form-data">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">user id</th>
                            <th scope="col">username</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td><?php echo htmlspecialchars($dataid); ?></td>
                            <td><?php echo htmlspecialchars($dataun); ?></td>
                            </tr>   
                        </tbody>
                    </table>
                    <div>
                    <center>
                        <button type=submit name="destroythisuser" value="1" class="btn btn-danger">accept</button>
                        <button  onclick="location.href='<?php echo $domain;?>'" type="button" class="btn btn-primary">cancel</button>
                    </center>
                    </div>
                    <a><?php echo $error; ?></a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
}else{
    include "error404.php";
}
?>