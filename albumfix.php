<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("connMysql.php");

include("check_login.php");

//更新相簿
if(isset($_POST["action"])&&($_POST["action"]=="update")){	
	//更新相簿資訊
	$query_update = "UPDATE `album` SET ";
	$query_update .= "`album_title`='".$_POST["album_title"]."',";
	$query_update .= "`album_date`='".$_POST["album_date"]."',";
	$query_update .= "`album_location`='".$_POST["album_location"]."',";	
	$query_update .= "`album_desc`='".$_POST["album_desc"]."' ";	
	$query_update .= "WHERE `album_id`=".$_POST["album_id"];
	mysql_query($query_update);	
	//更新照片資訊
	for ($i=0; $i<count($_POST["ap_id"]); $i++) {
		$query_update = "UPDATE `albumphoto` SET `ap_subject`='".$_POST["update_subject"][$i]."' WHERE `ap_id`=".$_POST["ap_id"][$i];	
		mysql_query($query_update);
	}
	//執行檔案刪除
	for ($i=0; $i<count($_POST["delcheck"]); $i++) {
		$delid = $_POST["delcheck"][$i];
		$query_del = "DELETE FROM `albumphoto` WHERE `ap_id`=".$_POST["ap_id"][$delid];	
		mysql_query($query_del);
		unlink("photos/".$_POST["delfile"][$delid]);
	}
	//執行照片新增及檔案上傳
	for ($i=0; $i<count($_FILES["ap_picurl"]); $i++) {
	  if ($_FILES["ap_picurl"]["tmp_name"][$i] != "") {
		  $query_insert = "INSERT INTO albumphoto (album_id, ap_date, ap_picurl, ap_subject) VALUES (";
		  $query_insert .= $_POST["album_id"].",";
		  $query_insert .= "NOW(),";	  
		  $query_insert .= "'". $_FILES["ap_picurl"]["name"][$i]."',";
		  $query_insert .= "'".$_POST["ap_subject"][$i]."')";		  
		  mysql_query($query_insert);		  
		  if(!move_uploaded_file($_FILES["ap_picurl"]["tmp_name"][$i] , "photos/" . $_FILES["ap_picurl"]["name"][$i])) die("檔案上傳失敗！");;		  
	  }
	}		
	//重新導向回到本畫面
	header("Location: ?id=".$_POST["album_id"]);
}
//顯示相簿資訊SQL敘述句
$query_RecAlbum = "SELECT * FROM `album` WHERE `album_id`=".$_GET["id"];
//顯示照片SQL敘述句
$query_RecPhoto = "SELECT * FROM `albumphoto` WHERE `album_id`=".$_GET["id"]." ORDER BY `ap_date` DESC";
//將二個SQL敘述句查詢資料到 $RecAlbum、$RecPhoto 中
$RecAlbum = mysql_query($query_RecAlbum);
$RecPhoto = mysql_query($query_RecPhoto);
//計算照片總筆數
$total_records = mysql_num_rows($RecPhoto);
//取得相簿資訊
$row_RecAlbum=mysql_fetch_assoc($RecAlbum);
?>
<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Skill Swap</title>
	<link href="style.css" rel="stylesheet" type="text/css">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<header>
    <?php include("navigation_section.php")?>
  </header>

	<main>
    <div class="container text-center">    
      <div class="row">

        <div class="col-sm-3 well">
          <?php include("member_section.php")?>
        </div>
        
        <div class="col-sm-7">
          <h3>相簿更新</h3>
          <a href="myalbum.php">回到我的相簿</a>

          <div>相片總數: <?php echo $total_records;?></div>
             
          <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
            <div class="form-group">
              <label for="album_title">相簿名稱：</label>
              <input class="form-control" name="album_title" type="text" id="album_title" value="<?php echo $row_RecAlbum["album_title"];?>" />
              <input class="form-control" name="album_id" type="hidden" id="album_id" value="<?php echo $row_RecAlbum["album_id"];?>" />       
            </div>
            <div class="form-group">
              <label for="album_title">拍攝時間：</label>
              <input class="form-control" name="album_date" type="text" id="album_date" value="<?php echo $row_RecAlbum["album_date"];?>" />
            </div>
            <div class="form-group">
              <label for="album_title">拍攝地點：</label>
              <input class="form-control" name="album_location" type="text" id="album_location" value="<?php echo $row_RecAlbum["album_location"];?>" />
            </div>
            <div class="form-group">
              <label for="album_title">相簿說明：</label>
              <textarea class="form-control" name="album_desc" id="album_desc" cols="45" rows="5"><?php echo $row_RecAlbum["album_desc"];?></textarea>
            </div>
            <div class="row">
              <?php
              $checkid=0;
              while($row_RecPhoto=mysql_fetch_assoc($RecPhoto)){
              ?>
              <div class="col-md-4 col-sm-6">
                <div class="thumbnail">
                  <div>
                    <img src="photos/<?php echo $row_RecPhoto["ap_picurl"];?>" alt="<?php echo $row_RecPhoto["ap_subject"];?>" width="120" height="120" border="0" />
                  </div>
                  <div>
                    <p>
                    <input name="ap_id[]" type="hidden" id="ap_id[]" value="<?php echo $row_RecPhoto["ap_id"];?>" />
                    <input name="delfile[]" type="hidden" id="delfile[]" value="<?php echo $row_RecPhoto["ap_picurl"];?>">
                    <input name="update_subject[]" type="text" id="update_subject[]" value="<?php echo $row_RecPhoto["ap_subject"];?>" size="15" />
                    <br />
                    <input name="delcheck[]" type="checkbox" id="delcheck[]" value="<?php echo $checkid;$checkid++?>" />
                    刪除?
                    </p>
                  </div>
                </div>
              </div>
              <?php }?>
            </div>
            <hr />
            <p>新增照片</p>
            <div class="form-group">
              <label for="album_title">照片1</label>
              <input class="form-control" type="file" name="ap_picurl[]" id="ap_picurl[]" />
              <label for="album_title">說明1</label>
              <input class="form-control" type="text" name="ap_subject[]" id="ap_subject[]" />
            </div>
            <div class="form-group">
              <label for="album_title">照片2</label>
              <input class="form-control" type="file" name="ap_picurl[]" id="ap_picurl[]" />
              <label for="album_title">說明2</label>
              <input class="form-control" type="text" name="ap_subject[]" id="ap_subject[]" />
            </div>
            <div class="form-group">
              <label for="album_title">照片3</label>
              <input class="form-control" type="file" name="ap_picurl[]" id="ap_picurl[]" />
              <label for="album_title">說明3</label>
              <input class="form-control" type="text" name="ap_subject[]" id="ap_subject[]" />
            </div>
            <div class="form-group">
              <label for="album_title">照片4</label>
              <input class="form-control" type="file" name="ap_picurl[]" id="ap_picurl[]" />
              <label for="album_title">說明4</label>
              <input class="form-control" type="text" name="ap_subject[]" id="ap_subject[]" />
            </div>
            <div class="form-group">
              <label for="album_title">照片5</label>
              <input class="form-control" type="file" name="ap_picurl[]" id="ap_picurl[]" />
              <label for="album_title">說明5</label>
              <input class="form-control" type="text" name="ap_subject[]" id="ap_subject[]" />
            </div>
            <div class="form-group">
            <p>
              <input name="action" type="hidden" id="action" value="update">
              <input class="btn btn-default" type="submit" name="button" id="button" value="確定修改" />
              <input class="btn btn-default" type="button" name="button2" id="button2" value="回上一頁" onClick="window.history.back();" />
            </p>
            </div>
          </form>
        </div>

        <div class="col-sm-2 well">
          <?php include("album_section.php")?>
        </div>
      </div>
    </div>
  </main>

  <?php include("footer_section.php")?>

</body>
</html>
