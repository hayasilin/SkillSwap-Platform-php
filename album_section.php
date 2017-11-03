<p><a href="myalbum.php" class="btn btn-primary">My album</a></p>
<p>相簿總數: <?php echo $total_album_records; ?></p>
<h5>最新相簿:</h5>
<?php	while($row_RecAlbum=mysql_fetch_assoc($RecAlbum)){ ?>
<div class="thumbnail">
  <a href="albumshow.php?id=<?php echo $row_RecAlbum["album_id"]; ?>"><?php if($row_RecAlbum["albumNum"]==0){?><img src="images/nopic.png" alt="暫無圖片" /><?php }else{ ?><img src="photos/<?php echo $row_RecAlbum["ap_picurl"]; ?>" alt="<?php echo $row_RecAlbum["album_title"]; ?>" /><?php } ?></a>
  <p><a href="albumshow.php?id=<?php echo $row_RecAlbum["album_id"]; ?>"><?php echo $row_RecAlbum["album_title"]; ?></a></p>
  <p class="card-text">共 <?php echo $row_RecAlbum["albumNum"]; ?> 張 </p>
</div>
<?php } ?>