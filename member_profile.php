<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("connMysql.php");

include("check_login.php");

//重新導向頁面
$redirectUrl="member_center.php";

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
//$query_RecBoard = "SELECT * FROM `board` ORDER BY `boardtime` DESC";

//本人留言的內容
$query_RecBoard = "SELECT * FROM `board` WHERE `boardname`='".$row_RecMember["m_name"]."' ORDER BY `boardtime` DESC";

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
	//重新導向回到主畫面
  header("Location: index.php");
}

if (isset($_POST["action"]) && ($_POST["action"] == "like")) {
  $query_RecLikeUpdate = "UPDATE `board` SET `boardlikes`=`boardlikes`+1 WHERE `boardid`='".$_POST["boardid"]."'"; 
  mysql_query($query_RecLikeUpdate);
  header("Location: index.php");
}

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
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h3>My Profile</h3>
                                    <p><a href="member_update.php">編輯Profile</a></p>

                                    <img src="avatars/<?php echo $row_RecMember["m_profilepic"]; ?>" class="img-circle" width="65" length="65" alt="Avatar" />

                                    <p><?php echo $row_RecMember["m_username"];?></p>
                                    <p>姓名：<?php echo $row_RecMember["m_name"];?></p>
                                    <p>性別：<?php echo $row_RecMember["m_sex"]?></p>
                                    <p>生日：<?php echo $row_RecMember["m_birthday"]?></p>
                                    <p>電子郵件：<?php echo $row_RecMember["m_mail"]?></p>
                                    <p>個人網頁：<?php echo $row_RecMember["m_url"]?></p>
                                    <p>電話：<?php echo $row_RecMember["m_phone"]?></p>
                                    <p>地址：<?php echo $row_RecMember["m_address"]?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <h3>我的貼文</h3>
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
                                <form action="">
                                    <!-- <input name="boardid" type="hidden" id="boardid" value="<?php echo $row_RecBoard["boardid"]; ?>"> -->
                                    <span class="glyphicon glyphicon-thumbs-up"></span> Like <?php echo $row_RecBoard["boardlikes"]; ?>
                                    &nbsp; | &nbsp;
                                    <?php echo $row_RecBoard["boardmail"]; ?>
                                    &nbsp; | &nbsp;
                                    <span class="small">
                                    <?php echo $row_RecBoard["boardtime"]; ?>
                                    </span>
                                    &nbsp; | &nbsp;
                                    <input type="button" class="btn btn-default btn-sm" onclick="location.href='boarddelete.php?id=<?php echo $row_RecBoard["boardid"];?>';" value="刪除" />
                                </form>
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
                    <?php include("album_section.php")?>
                </div>
			</div>  
		</div>
	</div>

</main>

<?php include("footer_section.php")?>
       
</body>
</html>
