<?php 
require ("config.php");



?>    
<html lang="en">
  <head>   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

     
    <meta name="author" content="<?php echo $author;?>">  
    <meta name="description" content="<?php echo $description;?>">    
    <title>Streaming</title>
    <link rel="icon" href="./logowp/favicon.png">
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/stylesheet.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>

  <body style=" background-image: url(&quot;logowp/wallpaper.jpg&quot;);  background-position: top left;  background-size: 100%;  background-repeat: repeat;" class="">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="<?php echo $domain; ?>"><?php echo $namedomain; ?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">          
          
        </ul>
        <form action="" method="get" class="form-inline my-2 my-lg-0">
          <input type="text" name="Cari" class="form-control mr-sm-2"  placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-primary my-2 my-sm-0" type="submit"><i class="fa fa-search">search</i></button>
        </form>
        <li class="nav-item">
        <?php if(!$shelogin){ ?>
          <a class="btn btn-outline-success my-2 my-sm-0"  href='<?php echo $domain; ?>?id=login' role="button"> 
            Sign In
          </a>
          <?php }else{ ?>
            <a class="btn btn-outline-success my-2 my-sm-0 fa fa-upload"  href='<?php echo $domain; ?>?id=upload' role="button"> 
            Upload</a>
          <button type="button" class="btn btn-outline-success my-2 my-sm-0 fa fa-user-circle" data-toggle="modal" data-target="#exampleModal">
            account
          </button>  
          <?php } ?>     
        </li>
      </div>
    </nav>

<?php if($shelogin){?>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">List Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body rem=2">
      <a class="btn btn-outline-success my-2 my-sm-0"  href='<?php echo $domain; ?>?id=account' role="button"> 
            account info</a>
      <a class="btn btn-outline-success my-2 my-sm-0"  href='<?php echo $domain; ?>?id=listdata' role="button"> 
            list video upload</a>
      <a class="btn btn-outline-success my-2 my-sm-0"  href='<?php echo $domain; ?>?id=passwordchange' role="button"> 
            change password</a>
      <?php
      if($_SESSION['level'] == "server"){ ?>
      <hr>
      <div>
      <a class="btn btn-outline-danger my-2 my-sm-0"  href='<?php echo $domain; ?>?id=management' role="button"> 
            Management data video & user</a>
      </div>
      <?php } ?>
      <hr>
      <div>
      <a class="btn btn-outline-danger my-2 my-sm-0"  href='<?php echo $domain; ?>?id=logout' role="button"> 
            logout</a>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>

    <main role="main" class="container" >
       <div class="py-4" style="background-image: linear-gradient(rgb(255, 255, 255,0.8), rgba(255, 255, 255,0.8)); background-position: left top; background-size: 100%; background-repeat: repeat;">
    <div class="container">
    
    <!--disini gan -->
    <?php
      //echo $_SESSION['id_user'];
      $id = $_GET['id'];
      switch ($id){
        case 'home':
          include "welcome.php";
          break;
        case 'watch':
          include "watch.php";
          break;
        case 'login':
          include "login.php";
          break;
        case 'logout':
          include "logout.php";
          break;
        case 'register':
          include "register.php";
          break;
        case 'account':
          include "account.php";
          break;  
        case 'passwordchange':
          include "changepwd.php";
          break;

          case 'upload':
          include "upload.php";
          break;        
        case 'listdata':
          include "list.php";
          break;
        case 'edit':
          include "editpage.php";
          break;
        case 'dell':
          include "vdelete.php";
          break;

        //admin
        case 'management':
          include "admin-setting.php";
          break;
        case 'management-change':
          include "admin-change.php";
          break;
        case 'management-delete':
          include "admin-delete.php";
          break;
        case 'management-delete-video':
          include "admin-delete-video.php";
          break;



        case '403':
          include "error403.php";
          break;
        case '404':
          include "error404.php";
          break;       
        default:
          include "welcome.php";
          break;
      }    
?>
    <!--stop disini gan -->
    </main>
    <footer class="text-muted py-5" >
    <div class="container">
      <p class="float-right">
        <a href="#">Back to top</a>
      </p>
      <p>© Boostrap&nbsp; <br>© Streaming <?php echo $copyright; ?></p>
      <p>Version : <?php echo $version;?></p>
    </div>
  </footer>    
    <script src="./js/jquery-3.5.1.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
  </body>
</html>