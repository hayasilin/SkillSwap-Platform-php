<?php
header("Content-Type: text/html; charset=utf-8");
require_once("connMysql.php");

include("check_login.php");

//執行刪除動作
if(isset($_POST["action"])&&($_POST["action"]=="delete")){	
	$sql_query = "DELETE FROM `board` WHERE `boardid`=".$_POST["boardid"];	
	mysql_query($sql_query);
	//重新導向回到主畫面
	header("Location: member_profile.php");
}
$query_RecBoard = "SELECT * FROM `board` WHERE `boardid`=".$_GET["id"];
$RecBoard = mysql_query($query_RecBoard);
$row_RecBoard=mysql_fetch_assoc($RecBoard);
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
				  <h2>刪除貼文</h2>
          <form name="form1" method="post" action="">
            <p><strong>標題</strong>：<?php echo $row_RecBoard["boardsubject"];?></p> 
            <p><strong>姓名</strong>：<?php echo $row_RecBoard["boardname"];?></p>
            <p><strong>性別</strong>：<?php echo $row_RecBoard["boardsex"];?></p>
            <p><strong>郵件</strong>：<?php echo $row_RecBoard["boardmail"];?></p>
            <p><strong>網站</strong>：<?php echo $row_RecBoard["boardweb"];?></p>
            <p><?php echo nl2br($row_RecBoard["boardcontent"]);?></p>

            <input name="boardid" type="hidden" id="boardid" value="<?php echo $row_RecBoard["boardid"];?>">
            <input name="action" type="hidden" id="action" value="delete">
            <input type="submit" name="button" id="button" value="確定刪除資料" class="btn btn-default btn-sm">
            <input type="button" name="button3" id="button3" value="回上一頁" onClick="window.history.back();" class="btn btn-default btn-sm">    
          </form>
				</div>
			</div>  
		</div>
	</div>

</main>

<?php include("footer_section.php")?>	

</body>
</html>
