<?php
header("Content-Type: text/html; charset=utf-8");
require_once ("connMysql.php");

include("check_login.php");

//顯示照片SQL敘述句
$query_RecPhoto = "SELECT `album`.`album_title`,`albumphoto`.* FROM `album`,`albumphoto` WHERE (`album`.`album_id`=`albumphoto`.`album_id`) AND `ap_id`=" . $_GET["id"];
//將SQL敘述句查詢資料到 $result 中
$RecPhoto = mysql_query($query_RecPhoto);
//取得相簿資訊
$row_RecPhoto = mysql_fetch_assoc($RecPhoto);
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
		<h2><?php echo $row_RecPhoto["album_title"]; ?></h2>
		<a href="albumshow.php?id=<?php echo $row_RecPhoto["album_id"]; ?>">回上一頁</a>

		<div class="thumbnail">
			<img src="photos/<?php echo $row_RecPhoto["ap_picurl"]; ?>" />
		</div>
		<div>
			<?php echo $row_RecPhoto["ap_subject"]; ?>
		</div>
	</main>

	<?php include("footer_section.php")?>	
	</body>
</html>
