<?php
header("Content-Type: text/html; charset=utf-8");
require_once("connMysql.php");

include("check_login.php");

//留言板資料
//預設每頁筆數
$pageRow_records = 5;
//預設頁數
$num_pages = 1;
//若已經有翻頁，將頁數更新
if (isset($_GET['page'])) {
	$num_pages = $_GET['page'];
}
//本頁開始記錄筆數 = (頁數-1)*每頁記錄筆數
$startRow_records = ($num_pages - 1) * $pageRow_records;
//未加限制顯示筆數的SQL敘述句
$query_RecBoard = "SELECT * FROM `board` ORDER BY `boardtime` DESC";

//本人留言的內容
$query_member_RecBoard = "SELECT * FROM `board` WHERE `boardname`='".$row_RecMember["m_name"]."' ORDER BY `boardtime` DESC";

//加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
$query_limit_RecBoard = $query_RecBoard . " LIMIT " . $startRow_records . ", " . $pageRow_records;
//以加上限制顯示筆數的SQL敘述句查詢資料到 $RecBoard 中
$RecBoard = mysql_query($query_limit_RecBoard);
//以未加上限制顯示筆數的SQL敘述句查詢資料到 $all_RecBoard 中
$all_RecBoard = mysql_query($query_RecBoard);
//計算總筆數
$total_records = mysql_num_rows($all_RecBoard);
//計算總頁數=(總筆數/每頁筆數)後無條件進位。
$total_pages = ceil($total_records / $pageRow_records);

//我的相簿

//預設每頁筆數
$pageRow_records = 5;
//本頁開始記錄筆數 = (頁數-1)*每頁記錄筆數
$startRow_records = ($num_pages - 1) * $pageRow_records;
//未加限制顯示筆數的SQL敘述句
// $query_RecAlbum = "SELECT `album`.`album_id` , `album`.`album_date` , `album`.`album_location` , `album`.`album_title` , `album`.`album_desc` , `albumphoto`.`ap_picurl`, count( `albumphoto`.`ap_id` ) AS `albumNum` FROM `album` LEFT JOIN `albumphoto` ON `album`.`album_id` = `albumphoto`.`album_id` GROUP BY `album`.`album_id` , `album`.`album_date` , `album`.`album_location` , `album`.`album_title` , `album`.`album_desc` ORDER BY `album_date` DESC";

//本人的相簿
$query_RecAlbum = "SELECT `album`.`album_id` , `album`.`album_date` , `album`.`album_location` , `album`.`album_title` , `album`.`album_desc` , `albumphoto`.`ap_picurl`, count( `albumphoto`.`ap_id` ) AS `albumNum` FROM `album` LEFT JOIN `albumphoto` ON `album`.`album_id` = `albumphoto`.`album_id` WHERE `album`.`m_id`='".$row_RecMember["m_id"]."' GROUP BY `album`.`album_id` , `album`.`album_date` , `album`.`album_location` , `album`.`album_title` , `album`.`album_desc` ORDER BY `album_date` DESC";

//加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
$query_limit_RecAlbum = $query_RecAlbum . " LIMIT " . $startRow_records . ", " . $pageRow_records;
//以加上限制顯示筆數的SQL敘述句查詢資料到 $RecAlbum 中
$RecAlbum = mysql_query($query_limit_RecAlbum);
//以未加上限制顯示筆數的SQL敘述句查詢資料到 $all_RecAlbum 中
$all_RecAlbum = mysql_query($query_RecAlbum);
//計算總筆數
$total_album_records = mysql_num_rows($all_RecAlbum);

//新增相簿
if (isset($_POST["action"]) && ($_POST["action"] == "add")) {
	$query_insert = "INSERT INTO `album` (`album_title` ,`album_date` ,`album_location` ,`album_desc`, `m_id`) VALUES (";
	$query_insert .= "'" . $_POST["album_title"] . "',";
	$query_insert .= "'" . $_POST["album_date"] . "',";
	$query_insert .= "'" . $_POST["album_location"] . "',";
  $query_insert .= "'" . $_POST["album_desc"] . "',";
  $query_insert .= "'" . $row_RecMember["m_id"] . "')";
	mysql_query($query_insert);
	//取得新增的相簿編號
	$album_pid = mysql_insert_id();

	for ($i = 0; $i < count($_FILES["ap_picurl"]["name"]); $i++) {
		if ($_FILES["ap_picurl"]["tmp_name"][$i] != "") {
			$query_insert = "INSERT INTO albumphoto (album_id, ap_date, ap_picurl, ap_subject) VALUES (";
			$query_insert .= $album_pid . ",";
			$query_insert .= "NOW(),";
			$query_insert .= "'" . $_FILES["ap_picurl"]["name"][$i] . "',";
			$query_insert .= "'" . $_POST["ap_subject"][$i] . "')";
			mysql_query($query_insert);
			if (!move_uploaded_file($_FILES["ap_picurl"]["tmp_name"][$i], "photos/" . $_FILES["ap_picurl"]["name"][$i]))
				die("檔案上傳失敗！");
			;
		}
	}

	//重新導向到修改畫面
  header("Location: albumfix.php?id=" . $album_pid);
}
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
          <h3>相增相簿</h3>
          <a href="#" onClick="window.history.back();">回上一頁</a>

          <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
            <div class="form-group">
              <label for="album_title">相簿名稱：</label>
              <input class="form-control" type="text" name="album_title" id="album_title" />
            </div>
            <div class="form-group">
              <label for="album_date">拍攝時間：</label>
              <input class="form-control" name="album_date" type="text" id="album_date" value="<?php echo date("Y-m-d H:i:s"); ?>" />
            </div>
            <div class="form-group">
              <label for="album_location">拍攝地點 ：</label>
              <input class="form-control" type="text" name="album_location" id="album_location" />
            </div>
            <div class="form-group">
              <label for="album_desc">相簿說明：</label>
              <textarea class="form-control" name="album_desc" id="album_desc" cols="45" rows="5"></textarea>
            </div>
            <hr />
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
              <input name="action" type="hidden" id="action" value="add">    
              <input type="submit" name="button" id="button" value="確定新增" class="btn btn-default" />
              <input type="button" name="button2" id="button2" value="回上一頁" onClick="window.history.back();" class="btn btn-default" />
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
