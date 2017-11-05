<div class="well">
  <img src="avatars/<?php echo $row_RecMember["m_profilepic"]; ?>" class="img-circle" width="65" length="65" alt="Avatar" />
  <p><strong><?php echo $row_RecMember["m_name"];?></strong> 您好</p>
  <p>您總共登入了 <?php echo $row_RecMember["m_login"];?> 次。<br>
  本次登入的時間為：<br>
  <?php echo $row_RecMember["m_logintime"];?></p>
  <p align="center"><a href="member_update.php">修改資料</a> | <a href="?logout=true">登出系統</a></p>
</div>
<div class="well">
  <p><a href="#">Interests</a></p>
  <p>
    <span class="label label-default">News</span>
    <span class="label label-primary">W3Schools</span>
    <span class="label label-success">Labels</span>
    <span class="label label-info">Football</span>
    <span class="label label-warning">Gaming</span>
    <span class="label label-danger">Friends</span>
  </p>
</div>
<div class="alert alert-success fade in">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
  <p><strong>Ey!</strong></p>
  People are looking at your profile. Find out who.
</div>
<p><a href="https://github.com/hayasilin">Developer's github</a></p>