<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("connMysql.php");

include("check_login.php");

//刪除相簿
if(isset($_GET["action"])&&($_GET["action"]=="delete")){	
	//刪除所屬相片
	$query_delphoto = "SELECT * FROM albumphoto WHERE `album_id`=".$_GET["id"];
	$delphoto = mysql_query($query_delphoto);
	while($row_delphoto=mysql_fetch_assoc($delphoto)){
		unlink("photos/".$row_delphoto["ap_picurl"]);
	}
	//刪除相簿
	$query_del1 = "DELETE FROM `album` WHERE `album_id`=".$_GET["id"];
	$query_del2 = "DELETE FROM `albumphoto` WHERE `album_id`=".$_GET["id"];
	mysql_query($query_del1);
	mysql_query($query_del2); 
	//重新導向回到主畫面
	header("Location: album_update.php");
}
//預設每頁筆數
$pageRow_records = 8;
//預設頁數
$num_pages = 1;
//若已經有翻頁，將頁數更新
if (isset($_GET['page'])) {
  $num_pages = $_GET['page'];
}
//本頁開始記錄筆數 = (頁數-1)*每頁記錄筆數
$startRow_records = ($num_pages -1) * $pageRow_records;
//未加限制顯示筆數的SQL敘述句
//$query_RecAlbum = "SELECT `album`.`album_id` , `album`.`album_date` , `album`.`album_location` , `album`.`album_title` , `album`.`album_desc` , `albumphoto`.`ap_picurl`, count( `albumphoto`.`ap_id` ) AS `albumNum` FROM `album` LEFT JOIN `albumphoto` ON `album`.`album_id` = `albumphoto`.`album_id` GROUP BY `album`.`album_id` , `album`.`album_date` , `album`.`album_location` , `album`.`album_title` , `album`.`album_desc` ORDER BY `album_date` DESC";
//本人的相簿
$query_RecAlbum = "SELECT `album`.`album_id` , `album`.`album_date` , `album`.`album_location` , `album`.`album_title` , `album`.`album_desc` , `albumphoto`.`ap_picurl`, count( `albumphoto`.`ap_id` ) AS `albumNum` FROM `album` LEFT JOIN `albumphoto` ON `album`.`album_id` = `albumphoto`.`album_id` WHERE `album`.`m_id`='".$row_RecMember["m_id"]."' GROUP BY `album`.`album_id` , `album`.`album_date` , `album`.`album_location` , `album`.`album_title` , `album`.`album_desc` ORDER BY `album_date` DESC";

//加上限制顯示筆數的SQL敘述句，由本頁開始記錄筆數開始，每頁顯示預設筆數
$query_limit_RecAlbum = $query_RecAlbum." LIMIT ".$startRow_records.", ".$pageRow_records;
//以加上限制顯示筆數的SQL敘述句查詢資料到 $RecAlbum 中
$RecAlbum = mysql_query($query_limit_RecAlbum);
//以未加上限制顯示筆數的SQL敘述句查詢資料到 $all_RecAlbum 中
$all_RecAlbum = mysql_query($query_RecAlbum);
//計算總筆數
$total_records = mysql_num_rows($all_RecAlbum);
//計算總頁數=(總筆數/每頁筆數)後無條件進位。
$total_pages = ceil($total_records/$pageRow_records);
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
<script language="javascript">
function deletesure(){
    if (confirm('\n您確定要刪除整個相簿嗎?\n刪除後無法恢復!\n')) return true;
    return false;
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
				<h2>相簿管理</h2>
				<h4>相簿總數: <?php echo $total_records;?></h4>
				<a href="albumadd.php">新增相簿</a>
				<span> | </span>
				<a href="myalbum.php">回到我的相簿</a>

					<div class="row">
						<?php while($row_RecAlbum=mysql_fetch_assoc($RecAlbum)){ ?>
							<div class="col-md-4 col-sm-6">
								<div class="thumbnail">	
									<a href="albumfix.php?id=<?php echo $row_RecAlbum["album_id"];?>"><?php if($row_RecAlbum["albumNum"]==0){?><img src="images/nopic.png" alt="暫無圖片" width="120" height="120" border="0" /><?php }else{?><img src="photos/<?php echo $row_RecAlbum["ap_picurl"];?>" alt="<?php echo $row_RecAlbum["album_title"];?>" width="120" height="120" border="0" /><?php }?></a>
									<a href="albumfix.php?id=<?php echo $row_RecAlbum["album_id"]; ?>"><?php echo $row_RecAlbum["album_title"]; ?></a><br/>
									共 <?php echo $row_RecAlbum["albumNum"];?> 張<br/>
									<a href="?action=delete&id=<?php echo $row_RecAlbum["album_id"];?>" class="smalltext" onClick="javascript:return deletesure();">(刪除相簿)</a>
								</div>
							</div>
						<?php }?>
					</div>
					
					<div>
						<?php if ($num_pages > 1) { // 若不是第一頁則顯示 ?>
							<a href="?page=1">|&lt;</a> <a href="?page=<?php echo $num_pages-1;?>">&lt;&lt;</a>
						<?php }else{?>
							|&lt; &lt;&lt;  
						<?php }?>
							<?php
						for($i=1;$i<=$total_pages;$i++){
							if($i==$num_pages){
								echo $i." ";
							}else{
								echo "<a href=\"?page=$i\">$i</a> ";
							}
						}
						?>
						<?php if ($num_pages < $total_pages) { // 若不是最後一頁則顯示 ?>
						<a href="?page=<?php echo $num_pages+1;?>">&gt;&gt;</a> <a href="?page=<?php echo $total_pages;?>">&gt;|</a>
						<?php }else{?>
						&gt;&gt; &gt;|
						<?php }?>
					</div>	
				</div>  
			</div>
		</div>

	</main>

<?php include("footer_section.php")?>   
           
</body>
</html>
