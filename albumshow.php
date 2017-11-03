<?php
header("Content-Type: text/html; charset=utf-8");
require_once ("connMysql.php");

include("check_login.php");

//計算點閱數
if (isset($_GET["action"]) && ($_GET["action"] == "hits")) {
	$query_hits = "UPDATE `albumphoto` SET `ap_hits`=`ap_hits`+1 WHERE `ap_id`=" . $_GET["id"];
	mysql_query($query_hits);
	header("Location: albumphoto.php?id=" . $_GET["id"]);
}
//顯示相簿資訊SQL敘述句
$query_RecAlbum = "SELECT * FROM `album` WHERE `album_id`=" . $_GET["id"];
//顯示照片SQL敘述句
$query_RecPhoto = "SELECT * FROM `albumphoto` WHERE `album_id`=" . $_GET["id"] . " ORDER BY `ap_date` DESC";
//將二個SQL敘述句查詢資料儲存到 $RecAlbum、$RecPhoto 中
$RecAlbum = mysql_query($query_RecAlbum);
$RecPhoto = mysql_query($query_RecPhoto);
//計算照片總筆數
$total_records = mysql_num_rows($RecPhoto);
//取得相簿資訊
$row_RecAlbum = mysql_fetch_assoc($RecAlbum);
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
		<?php include("navigation_section.php")?>
	</header>

		<main>
			<div class="container text-center">    
				<div class="row">
					<div class="col-sm-3 well">
						<?php include("member_section.php")?>
					</div>
		
				<div class="col-sm-7">
					<h4>相簿</h4>
					<h3><?php echo $row_RecAlbum["album_title"]; ?></h3>
					<h5>照片總數：<?php echo $total_records; ?></h5>

					<div class="album-info">
						<p><strong>拍攝時間</strong>：<?php echo $row_RecAlbum["album_date"]; ?> <strong>拍攝地點</strong>：<?php echo $row_RecAlbum["album_location"]; ?></p>
						<p><?php echo nl2br($row_RecAlbum["album_desc"]); ?></p>
					</div>
					<div>
						<?php while($row_RecPhoto=mysql_fetch_assoc($RecPhoto)){?>
						<div class="col-md-4 col-sm-6">
							<div class="thumbnail">
								<a href="?action=hits&id=<?php echo $row_RecPhoto["ap_id"]; ?>"><img src="photos/<?php echo $row_RecPhoto["ap_picurl"]; ?>" alt="<?php echo $row_RecPhoto["ap_subject"]; ?>" width="170" height="160" border="0" /></a></a>
								<a href="?action=hits&id=<?php echo $row_RecPhoto["ap_id"]; ?>"><?php echo $row_RecPhoto["ap_subject"]; ?></a><br />
								點閱次數：<?php echo $row_RecPhoto["ap_hits"]; ?>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</main>

<footer class="footer">
	<div class="container">
		<span class="text-muted">Place sticky footer content here.</span>
	</div>
</footer>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</body>
</html>
