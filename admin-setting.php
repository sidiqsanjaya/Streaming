<?php
if(!$shelogin){
    header("location:$domain?id=login");
    exit;
 }elseif($_SESSION['level'] == 'client'){
    header( "refresh:5;url=$domain?id=home" );
    include "error403.php";
    exit;
 }


if(isset($_POST['user'])){
    $usera = $_POST['user'];
    $sql_user = mysqli_query($conn, "SELECT * FROM account where username LIKE '%$usera%' AND `level` = 'client'");

    $datauser = "collapse show";
}else{
    $usera = '';
    $sql_user = mysqli_query($conn, "SELECT * FROM account WHERE `level` = 'client'");
    $datauser = "collapse";
}

if(isset($_POST['video'])){
    $video = $_POST['video'];
    $sql_video = mysqli_query($conn, "SELECT * FROM video where id_video LIKE '%$video$' OR judul LIKE '%$video%' OR genre LIKE '%$video%' ");
    $datavideo = "collapse show";
}else{
    $video = '';
    $sql_video = mysqli_query($conn, "SELECT * FROM video");
    $datavideo = "collapse";
}




?>

<div class="container-fluid">
    <div>
    <form method="POST" action="<?php echo $domain;?>?id=management" enctype="multipart/form-data">
            <input class="form-control mr-sm-2" type="search" placeholder="Search user" name="user" value="<?php echo $usera;?>" aria-label="Search">
            <button  class="btn btn-outline-success my-2 my-sm-0" type="submit" value=search>Search</button>
        </form>
        
        <p>
            <a class="btn btn-primary" data-toggle="collapse" href="#datauser" role="button" aria-expanded="disable" aria-controls="datauser">
            show user data
            </a>
            </p>
            <div class="<?php echo $datauser;?>" id="datauser">
                <div class="card card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-1">
                            no
                        </div>
                        <div class="col-sm-4">
                            account user name
                        </div>
                        <div class="col-sm">
                            account last login
                        </div>
                        <div class="col-sm">
                            Action
                        </div>
                    </div>
                    <?php 
                    $nouser = 0;
                    while($fetchuser = mysqli_fetch_array($sql_user)){
                        $nouser = $nouser + 1;
                        
                        $userencod = base64_encode(openssl_encrypt($fetchuser['id_user'], $_SESSION["cypherMethod"], $_SESSION["key"], $options=0, $_SESSION["iv"]));
                    ?>
                    
                    <hr>
                    <div class="row">
                        <div class="col-1">
                            <?php echo $nouser; ?>
                        </div>
                        <div class="col-sm-4">
                            <?php echo $fetchuser['username']; ?>
                        </div>
                        <div class="col-sm">
                            wait
                        </div>
                        <div class="col-sm">
                            <button type="button" onclick="location.href='?id=management-change&on=<?php echo $userencod;?>'" class="btn btn-primary">change password</button>
                            <button type="button" onclick="location.href='?id=management-delete&on=<?php echo $userencod;?>'" class="btn btn-danger">Delete data</button>
                        </div>
                    </div>
                    <?php } ?>
                    </div>
                </div>
            </div>
    </div>
    <hr>
    <div>
    <form method="POST" action="<?php echo $domain;?>?id=management" enctype="multipart/form-data">
            <input class="form-control mr-sm-2" type="search" placeholder="Search video" value="<?php echo $video;?>" name="video" aria-label="Search" >
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        <p>
            <a class="btn btn-primary" data-toggle="collapse" href="#datavideo" role="button" aria-expanded="false" aria-controls="datavideo">
            show video data
            </a>
            </p>
            <div class="<?php echo $datavideo;?>" id="datavideo">
                <div class="container">
                    <div class="row">
                        <div class="col-1">
                         no   
                        </div>
                        <div class="col-6">
                            title
                        </div>
                        <div class="col">
                            watch count
                        </div>
                        <div class="col">
                            Action
                        </div>
                    </div>
                <?php
                $novideo = 0; 
                while($fetchvideo = mysqli_fetch_array($sql_video)){ 
                $novideo = $novideo + 1; 
                $videoencod = base64_encode(openssl_encrypt($fetchvideo['id_video'], $_SESSION["cypherMethod"], $_SESSION["key"], $options=0, $_SESSION["iv"]));
                    ?>
                    <hr>
                    <div class="row">
                        <div class="col-1">
                         <?php echo $novideo; ?>   
                        </div>
                        <div class="col-6">
                          <p class="text-truncate">  <?php echo $fetchvideo['judul']; ?> </p>
                        </div>
                        <div class="col">
                            <?php echo $fetchvideo['watch']; ?>
                        </div>
                        <div class="col">
                        <button type="button" onclick="location.href='?id=management-delete-video&on=<?php echo $videoencod;?>'" class="btn btn-danger">Delete data</button>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
    </div>
</div>