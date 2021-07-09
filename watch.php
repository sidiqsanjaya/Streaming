
<?php
$idv = $_GET['v'];
$countwatch = 
$video = mysqli_query($conn, "SELECT `detail_user`.`fullname`, `detail_user`.`country`,`detail_user`.`img`, `video`.* FROM `detail_user` RIGHT JOIN `video` ON detail_user.id_user = video.id_user WHERE video.id_video = '$idv'");
var_dump($video);
$datavideo = mysqli_query($conn, "SELECT * FROM `data_video` WHERE `id_video` = '$idv'");

if(mysqli_num_rows($datavideo)== 1) {
?>
<link href="./js/videojs/video-js.min.css" rel="stylesheet">
<script src="./js/videojs/video.min.js"></script>
<script src="./js/videojs/jquery-3.5.1.min.js"></script>
    
    
      <div class="container">
        <?php 
        while($dvideo=mysqli_fetch_array($datavideo)){ 
          ?>
          <div class="row">
            <div class="col-md-12">
              <video id="video" class="video-js vjs-default-skin embed-responsive embed-responsive-16by9" width="1000" controls autoplay data-setup='{}'>
              <source src="<?php echo $dvideo['480']; ?>" type='video/mp4' label='480p' />
              <source src="<?php echo $dvideo['720']; ?>" type='video/mp4' label='720p' />
              <source src="<?php echo $dvideo['1080']; ?>" type='video/mp4' label='1080p' />
              </video>
            </div>
          </div>
          <?php 
          } 
          ?>
          <?php while($v=mysqli_fetch_array($video)){ ?>
            <div class="container">
            <br>
              <div class="row">
                <div class="col">
                <p class="lead  text-body text-justify font-weight-bold" style="color: black;"><?php echo htmlspecialchars($v['judul']);?></p>
                </div>
              </div>
              <div class="row">
                <div class="col text-left">
                  <?php echo $watch = $v['watch']; 
                          $watch = $watch + 1;
                          mysqli_query($conn, "UPDATE `video` SET `watch` = '$watch' WHERE `video`.`id_video` = '$idv'");
                          ?> views
                </div>
                <div class="col text-right">
                  <?php echo $v['upload_at']; ?>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col">
                  <div class="d-flex flex-row comment-row">
                    <div class="p-1">
                    <?php if($v['img']== ''){ ?>
                      <img src="./img/brokenimg.png" class="rounded-circle" alt="user" width="50"></span>
                    <?php }else{ ?>
                      <img src="<?php echo $v['img'];?>" class="rounded-circle" alt="user" width="50"></span>
                    <?php } ?>
                    </div>
                    <div class="comment-text w-100">
                      <?php if(!$v['fullname']==''){ ?>
                        <h5><?php echo htmlspecialchars($v['fullname']);?></h5>
                      <?php }else{ ?>
                        <h5><?php echo htmlspecialchars($v['id_user']);?> not setting name</h5>
                      <?php } ?>
                  </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-md">
                <span class="teaser text-justify" style="display: block; width: 150px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><?php echo htmlspecialchars($v['sinopsis']);?></span>
                <span class="complete text-justify" style="display: none;"><?php echo htmlspecialchars($v['sinopsis']);?>
                <br><hr><br>
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
                            <td><?php echo htmlspecialchars($v['judul']);?></td>
                          </tr>
                          <tr>
                            <td>Genre</td>
                            <td><?php echo htmlspecialchars($v['genre']);?></td>
                          </tr>
                          <tr>
                            <td>Production</td>
                            <td><?php echo htmlspecialchars($v['produksi']);?></td>
                          </tr>
                          <tr>
                            <td>Duration</td>
                            <td><?php echo htmlspecialchars($v['durasi']);?></td>
                          </tr>
                          <tr>
                            <td>release</td>
                            <td><?php echo htmlspecialchars($v['rilis']);?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                
                </span>
                <br>
                <span class="more font-weight-bold text-secondary">SHOW MORE</span>
                </div>
              </div>
            </div>
            <hr>
          </div>
       
        <?php } ?>
        <hr>
        <!--comment-->
        <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <?php if(!$shelogin){
                  echo '<h4 class="card-title">must login to comment</h4>';
                }else{?>
                  <form id="sentcomment" method="POST">
                    <div class="form-group">
                      <input type="text" class="form-control" name="comment" placeholder="write a comment">
                      <input type="hidden" value="<?php echo $idv;?>" name="idvid" />
                    </div>
                  </form>
                  <?php } ?>
                  <br>
                    <h4 class="card-title">Recent Comments</h4>
                    <h6 class="card-subtitle">Latest Comments section by users</h6>
                </div>
                <div class="comment-widgets m-b-20">
                    <div class="d-flex flex-row comment-row">
                    <div id="display_comment"></div>
                </div>
            </div>
        </div>
    </div>   
      </div>
<script type="text/javascript">
  $(document).ready(function() { 
      $("#sentcomment").submit(function(e) {
          e.preventDefault();
          $.ajax({
              url: 'save-comment.php',
              type: 'post',
              data: $(this).serialize(),             
              success: function(data) {               
              document.getElementById("sentcomment").reset();
              load_comment();              
              }
          });
      });

      load_comment();
      function load_comment()

      {
        $.ajax({
          url:"load-comment.php",
          method:"POST",
          data: {idve: '<?php echo $idv;?>'},
          success: function(data){
            $('#display_comment').html(data);

          }
        })
      }
  })
</script>
<script>


</script>
</script>
<div id="status"></div>
<script src="./js/videojs/videojs-resolution-switcher.js"></script>
<script>
$.fn.clicktoggle = function(a, b) {
    return this.each(function() {
        var clicked = false;
        $(this).click(function() {
            if (clicked) {
                clicked = false;
                return b.apply(this, arguments);
            }
            clicked = true;
            return a.apply(this, arguments);
        });
    });
};
$(".more").clicktoggle(function() {
  $(this).text("SHOW LESS").siblings(".complete").show();
  $(this).siblings(".teaser").hide();
}, function() {
  $(this).text("SHOW MORE").siblings(".complete").hide();
  $(this).siblings(".teaser").show();
});
</script>
<script>
  videojs('video').videoJsResolutionSwitcher()
</script>
<script>    
  window.oncontextmenu = function () {
        return false;
      }
      $(document).keydown(function (event) {
        if (event.keyCode == 123) {
          return false;
        }
        else if ((event.ctrlKey && event.shiftKey && event.keyCode == 123) || (event.ctrlKey && event.shiftKey && event.keyCode == 123) || (event.ctrlKey && event.shiftKey && event.keyCode == 17) || (event.ctrlKey && event.shiftKey && event.keyCode == 16) || (event.ctrlKey && event.shiftKey && event.keyCode == 73)) {
          return false;
        }
      });
</script>

<?php }else{ 
  include "error404.php";
}  ?>