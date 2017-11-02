<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("connMysql.php");
session_start();
//檢查是否經過登入
if(!isset($_SESSION["loginMember"]) || ($_SESSION["loginMember"]=="")){
	header("Location: index.php");
}
//執行登出動作
if(isset($_GET["logout"]) && ($_GET["logout"]=="true")){
	unset($_SESSION["loginMember"]);
	unset($_SESSION["memberLevel"]);
	header("Location: index.php");
}
//繫結登入會員資料
$query_RecMember = "SELECT * FROM `memberdata` WHERE `m_username`='".$_SESSION["loginMember"]."'";
$RecMember = mysql_query($query_RecMember);	
$row_RecMember=mysql_fetch_assoc($RecMember);

//留言板資料
//預設每頁筆數
$pageRow_records = 10;
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

if (isset($_POST["action"]) && ($_POST["action"] == "add")) {
	$query_insert = "INSERT INTO `board` (`boardname` ,`boardsex` ,`boardsubject` ,`boardtime` ,`boardmail` ,`boardweb` ,`boardcontent` ,`boardavatar`) VALUES (";
	$query_insert .= "'" . $row_RecMember["m_name"] . "',";
	$query_insert .= "'" . $row_RecMember["m_sex"] . "',";
	$query_insert .= "'" . $_POST["boardsubject"] . "',";
	$query_insert .= "NOW(),";
	$query_insert .= "'" . $row_RecMember["m_email"] . "',";
	$query_insert .= "'" . $_POST["boardweb"] . "',";
  $query_insert .= "'" . $_POST["boardcontent"] . "',";
  $query_insert .= "'" . $row_RecMember["m_profilepic"] . "')";
  mysql_query($query_insert);
  // echo $query_insert;
	//重新導向回到主畫面
  header("Location: index.php");
}

//我的相簿

//預設每頁筆數
$pageRow_records = 5;
//本頁開始記錄筆數 = (頁數-1)*每頁記錄筆數
$startRow_records = ($num_pages - 1) * $pageRow_records;
//未加限制顯示筆數的SQL敘述句
$query_RecAlbum = "SELECT `album`.`album_id` , `album`.`album_date` , `album`.`album_location` , `album`.`album_title` , `album`.`album_desc` , `albumphoto`.`ap_picurl`, count( `albumphoto`.`ap_id` ) AS `albumNum` FROM `album` LEFT JOIN `albumphoto` ON `album`.`album_id` = `albumphoto`.`album_id` GROUP BY `album`.`album_id` , `album`.`album_date` , `album`.`album_location` , `album`.`album_title` , `album`.`album_desc` ORDER BY `album_date` DESC";
//加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
$query_limit_RecAlbum = $query_RecAlbum . " LIMIT " . $startRow_records . ", " . $pageRow_records;
//以加上限制顯示筆數的SQL敘述句查詢資料到 $RecAlbum 中
$RecAlbum = mysql_query($query_limit_RecAlbum);
//以未加上限制顯示筆數的SQL敘述句查詢資料到 $all_RecAlbum 中
$all_RecAlbum = mysql_query($query_RecAlbum);
//計算總筆數
$total_records = mysql_num_rows($all_RecAlbum);
//計算總頁數=(總筆數/每頁筆數)後無條件進位。
$total_pages = ceil($total_records / $pageRow_records);
?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Skill Swap</title>
    <link href="style.css" rel="stylesheet" type="text/css">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>    
      /* Set black background color, white text and some padding */
      footer {
        background-color: #555;
        color: white;
        padding: 15px;
      }
    </style>
    <script language="javascript">
      function checkForm() {
				if (document.formPost.boardcontent.value == "") {
					alert("請填寫留言內容!");
					document.formPost.boardcontent.focus();
					return false;
				}
			}
    </script>
  </head>

<body>
  
  <header>
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>                        
          </button>
          <a class="navbar-brand" href="#">Skill Swap</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#">Messages</a></li>
          </ul>
          <form class="navbar-form navbar-right" role="search">
            <div class="form-group input-group">
              <input type="text" class="form-control" placeholder="Search..">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">
                  <span class="glyphicon glyphicon-search"></span>
                </button>
              </span>        
            </div>
          </form>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span><?php echo $row_RecMember["m_name"];?></a></li>
            <li><a href="?logout=true"><span>登出</span></a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  
  <main>
    <div class="container text-center">    
      <div class="row">
        <div class="col-sm-3 well">
          <div class="well">
            <p><a href="#">My Profile</a></p>
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
          <p><a href="#">Link</a></p>
          <p><a href="#">Link</a></p>
          <p><a href="#">Link</a></p>
        </div>
        
        <div class="col-sm-7">
        
          <div class="row">
            <div class="col-sm-12">
              <div class="panel panel-default text-left">
                <div class="panel-body">
                  
                  <form action="" method="post" name="formPost" id="formPost" onSubmit="return checkForm();">
                    <div class="form-group">
                      <label for="comment">貼文:</label>
                      <textarea class="form-control" rows="3" name="boardcontent" id="boardcontent"></textarea>
                    </div>

                    <div class="sumit">
                      <input name="action" type="hidden" id="action" value="add">
                      <input type="submit" name="button" id="button" value="送出留言" class="btn btn-default btn-sm">
                      <input type="reset" name="button2" id="button2" value="重設資料" class="btn btn-default btn-sm">
                    </div>
				          </form>
                </div>
              </div>
            </div>
          </div>
          
          <?php	while($row_RecBoard=mysql_fetch_assoc($RecBoard)){ ?>
          <div class="row">
            <div class="col-sm-3">
              <div class="well">
              <p><?php echo $row_RecBoard["boardname"]; ?></p>
              <img src="avatars/<?php echo $row_RecBoard["boardavatar"]; ?>" class="img-circle" height="55" width="55" alt="Avatar">
              </div>
            </div>
            <div class="col-sm-9">
              <div class="well text-left">
                <h4><?php echo $row_RecBoard["boardsubject"]; ?></h4>
                <p><?php echo nl2br($row_RecBoard["boardcontent"]); ?></p>
              </div>
              <div class="text-left">
                <button type="button" class="btn btn-default btn-sm">
                  <span class="glyphicon glyphicon-thumbs-up"></span> Like <?php echo $row_RecBoard["boardlikes"]; ?>
                </button>
                <span class="small text-right">
                  <?php echo $row_RecBoard["boardtime"]; ?>
                </span>
              </div>
            </div>
          </div>
          <?php } ?>
              
          <div id="total-records">
          		<p>資料筆數：<?php echo $total_records; ?></p>
          </div>
          <div id="page">
                <?php if ($num_pages > 1) { // 若不是第一頁則顯示 ?>
                <a href="?page=1">第一頁</a> | <a href="?page=<?php echo $num_pages - 1; ?>">上一頁</a> |
                <?php } ?>
                <?php if ($num_pages < $total_pages) { // 若不是最後一頁則顯示 ?>
                <a href="?page=<?php echo $num_pages + 1; ?>">下一頁</a> | <a href="?page=<?php echo $total_pages; ?>">最末頁</a>
                <?php } ?>
          </div>
        </div>

        <div class="col-sm-2 well">
          <p><a href="myalbum.php" class="btn btn-primary">My album</a></p>
          <p>相簿總數: <?php echo $total_records; ?></p>
          
          <?php	while($row_RecAlbum=mysql_fetch_assoc($RecAlbum)){ ?>
            <div class="thumbnail">
              <a href="albumshow.php?id=<?php echo $row_RecAlbum["album_id"]; ?>"><?php if($row_RecAlbum["albumNum"]==0){?><img src="images/nopic.png" alt="暫無圖片" /><?php }else{ ?><img src="photos/<?php echo $row_RecAlbum["ap_picurl"]; ?>" alt="<?php echo $row_RecAlbum["album_title"]; ?>" /><?php } ?></a>
              <p><a href="albumshow.php?id=<?php echo $row_RecAlbum["album_id"]; ?>"><?php echo $row_RecAlbum["album_title"]; ?></a></p>
              <p class="card-text">共 <?php echo $row_RecAlbum["albumNum"]; ?> 張 </p>
            </div>
          <?php } ?>

          <div>
            <?php if ($num_pages > 1) { // 若不是第一頁則顯示 ?>
              <a href="?page=1">|&lt;</a> <a href="?page=<?php echo $num_pages - 1; ?>">&lt;&lt;</a>
            <?php }else{ ?>
              |&lt; &lt;&lt;
            <?php } ?>
            <?php for ($i = 1; $i <= $total_pages; $i++) {
              if ($i == $num_pages) {
                echo $i . " ";
              } else {
                echo "<a href=\"?page=$i\">$i</a> ";
              }
            }?>
            <?php if ($num_pages < $total_pages) { // 若不是最後一頁則顯示 ?>
                <a href="?page=<?php echo $num_pages + 1; ?>">&gt;&gt;</a> <a href="?page=<?php echo $total_pages; ?>">&gt;|</a>
              <?php }else{ ?>
                &gt;&gt; &gt;|
              <?php } ?>
          </div>
        </div>
      </div>
    </div>

  </main>

  <footer class="container-fluid text-center">
    <p>Footer Text</p>
  </footer>

</body>
</html>
