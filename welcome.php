
    
        <?php
		$pencarian=$_GET['Cari'];
		if($pencarian != ''){	
			$data = mysqli_query($conn, "SELECT `detail_user`.`fullname`, `detail_user`.`country`, `video`.`judul`, `video`.`genre`, `video`.`produksi`, `video`.`gambar`, `detail_user`.* ,video.sinopsis,video.id_video FROM `detail_user`, `video` WHERE `detail_user`.`fullname` LIKE '%$pencarian%' OR `detail_user`.`country` LIKE '%$pencarian%' OR `video`.`judul` LIKE '%$pencarian%' OR `video`.`genre` LIKE '%$pencarian%' OR `video`.`produksi` LIKE '%$pencarian%'");
      while($hasil=mysqli_fetch_array($data)){
        ?>
            <div class="card mb-2">
            <a href='<?php echo $domain;?>?id=watch&v=<?php echo $hasil['id_video'];?>'>
              <div class="row no-gutters">
                <div class="col-md-3">
                  <img src="<?php echo $hasil['gambar'];?>" class="card-img" alt="<?php echo $hasil['judul'];?>">
                </div>
                <div class="col-md-5">
                  <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($hasil['judul']);?></h5>
                    <p class="card-text"><small class="text-muted"><?php echo htmlspecialchars($hasil['produksi']);?></small></p>
                    <p class="card-text text-truncate"><?php echo htmlspecialchars($hasil['sinopsis']);?></p>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                  </div>
                </div>
              </div>
            </a>
            </div>
      <?php 
      }
		}else{
		$data = mysqli_query($conn, "select * from video");
      while($hasil=mysqli_fetch_array($data)){
        ?>
        <div class="row">
          <div class="col-md-0 p-2">
            <a href='<?php echo $domain; ?>?id=watch&v=<?php echo $hasil['id_video'];?>'>
              <div class="card" style="width: 10rem; height: 23rem">
                <img class="card-img-top mx-auto"  src="<?php echo $hasil['gambar']; ?>" alt="card image cap"  alt="Card image cap" style=" min-width: 50px;  min-height: 250px;  max-height: 1280px; max-width: 720px;">
                  <div class="card-body overflow-auto" style="  min-width: 50px;  min-height: 140px;">
                    <h6 class="card-title text-truncate" style="max-width: 150px;"><?php echo htmlspecialchars($hasil['judul']);?></h6>
                    <p class="card-text text-truncate" style="max-width: 150px;"><center><?php echo htmlspecialchars($hasil['produksi']);?></p>
                  </div>
              </div>
            </a>	  
          </div>
      <?php 
      }
		}
    ?>	
    </div>
