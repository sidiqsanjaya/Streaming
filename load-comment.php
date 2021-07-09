<?php
include "config.php";

$idve = $_POST['idve'];
$fecth_koment = mysqli_query($conn, "SELECT `video`.`id_video`, `comment_video`.`comment`, `comment_video`.`comment_at`, `detail_user`.`fullname`, `detail_user`.`img`, `comment_video`.`id_user` FROM `video` JOIN `comment_video` ON `comment_video`.`id_video` = `video`.`id_video` LEFT JOIN detail_user ON detail_user.id_user = comment_video.id_user WHERE `video`.`id_video` = '$idve'");
while($fetch = mysqli_fetch_array($fecth_koment)){
?>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
                    <div class="d-flex flex-row comment-row">
                        <div class="p-2">
                        <span class="round">
                        <?php if($fetch['img'] ==''){?><i class='fas fa-user-alt' style='font-size:24px'></i><?php }else{?>
                        <img src="<?php echo $fetch['img'];?>" class="rounded-circle" alt="user" width="50"><?php } ?></span>
                        </div>
                        <div class="comment-text w-100">
                            <?php if(!$fetch['fullname']==''){ ?>
                                <h5><?php echo htmlspecialchars($fetch['fullname']);?></h5>
                            <?php }else{ ?>
                                <h5><?php echo htmlspecialchars($fetch['id_user']);?> not setting name</h5>
                            <?php } ?>
                            <div class="comment-footer"> <span class="date"><?php echo $fetch['comment_at'];?></span></div>
                            <p class="m-b-5 m-t-10"><?php echo htmlspecialchars($fetch['comment']);?></p>
                        </div>
                    </div>
<?php } ?>