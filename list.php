<?php
if(!$shelogin){
    header("location:$domain?id=login");
    exit;
}

$tempuser = $_SESSION['id_user'];
$sqllist = mysqli_query($conn, "SELECT * FROM video WHERE id_user = '$tempuser'");
?>

<h4>list of your uploads</h4>
<div class="row">
    <div class="container">
        <div class="row">
            <div class="col col-sm-1">
                <h5>no</h5>
            </div>
            <div class="col">
                <h5>Thubmnail</h5>
            </div>
                <div class="col-6">
            <h5>Title</h5>
            </div>
            <div class="col">
                <h5>Action</h5>
            </div>
        </div>
        <hr>
        <?php 
        $no = 0;
        while($list = mysqli_fetch_array($sqllist)){
            $no = $no + 1; 
            $tmpidvideo = base64_encode(openssl_encrypt($list['id_video'], $_SESSION["cypherMethod"], $_SESSION["key"], $options=0, $_SESSION["iv"]));
        ?>
        
        <div class="row">
            <div class="col col-sm-1">
                <h5><?php echo $no; ?></h5>
            </div>
            <div class="col">
            <img src="<?php echo $list['gambar'];?>" alt="gambar" class="img-thumbnail">
            </div>
            <div class="col-6">
                <h5><?php echo htmlspecialchars($list['judul']); ?></h5>
            </div>
            <div class="col">
            <button onclick="location.href='<?php echo $domain; ?>?id=watch&v=<?php echo $list['id_video'];?>'" type="button" class="btn btn-primary">view</button>
                <button onclick="location.href='?id=edit&on=<?php echo $tmpidvideo;?>'" type="button" class="btn btn-primary">Edit</button>
                <button onclick="location.href='?id=dell&on=<?php echo $tmpidvideo; ?>'" type="button" class="btn btn-warning">Delete</button>
            </div>
        </div>
        </a>
        <hr>
        <?php } ?>
    </div>
</div>