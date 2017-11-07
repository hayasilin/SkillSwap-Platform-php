<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("connMysql.php");
session_start();
//檢查是否經過登入，若有登入則重新導向
if(isset($_SESSION["loginMember"]) && ($_SESSION["loginMember"]!="")){
  //若帳號等級為 member 則導向會員中心
	if($_SESSION["memberLevel"]=="member"){
	  header("Location: member_center.php");
	//否則則導向管理中心
	}else{
		header("Location: member_admin.php");	
	}
}
//執行會員登入
if(isset($_POST["username"]) && isset($_POST["passwd"])){		
	//繫結登入會員資料
	$query_RecLogin = "SELECT * FROM `memberdata` WHERE `m_username`='".$_POST["username"]."'";
	$RecLogin = mysql_query($query_RecLogin);		
	//取出帳號密碼的值
	$row_RecLogin=mysql_fetch_assoc($RecLogin);
	$username = $row_RecLogin["m_username"];
	$passwd = $row_RecLogin["m_passwd"];
	$level = $row_RecLogin["m_level"];
	//比對密碼，若登入成功則呈現登入狀態
	if(md5($_POST["passwd"])==$passwd){
		//計算登入次數及更新登入時間
		$query_RecLoginUpdate = "UPDATE `memberdata` SET `m_login`=`m_login`+1, `m_logintime`=NOW() WHERE `m_username`='".$_POST["username"]."'";	
		mysql_query($query_RecLoginUpdate);
		//設定登入者的名稱及等級
		$_SESSION["loginMember"]=$username;
		$_SESSION["memberLevel"]=$level;
		//使用Cookie記錄登入資料
		if(isset($_POST["rememberme"])&&($_POST["rememberme"]=="true")){
			setcookie("remUser", $_POST["username"], time()+365*24*60);
			setcookie("remPass", $_POST["passwd"], time()+365*24*60);
		}else{
			if(isset($_COOKIE["remUser"])){
				setcookie("remUser", $_POST["username"], time()-100);
				setcookie("remPass", $_POST["passwd"], time()-100);
			}
		}
		//若帳號等級為 member 則導向會員中心
		if($_SESSION["memberLevel"]=="member"){
			header("Location: member_center.php");
		//否則則導向管理中心
		}else{
			header("Location: member_admin.php");	
		}
	}else{
		header("Location: index.php?errMsg=1");
	}
}

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

$searchTitle = "";
if (isset($_POST["keyword"]) && ($_POST["keyword"] != "")) {
  $query_RecBoard = "SELECT * FROM `board` WHERE `boardcontent` LIKE '%" .$_POST["keyword"]. "%' ORDER BY `boardtime` DESC";
  $searchTitle = "<h3>" .$_POST["keyword"]. "：的搜尋結果</h3>";
}else{
  $searchTitle = "";
}

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

  <script>
    function checkSearchForm(){
      if(document.searchForm.keyword.value==""){
      alert("請填寫關鍵字!");
      document.searchForm.keyword.focus();
      return false;
      }
    }
  </script>

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
            <a class="navbar-brand" href="index.php">Skill Swap</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
              <li class="active"><a href="index.php">Home</a></li>
              <li><a href="#">Messages</a></li>
            </ul>
            <form class="navbar-form navbar-right" role="search" name="searchForm" action="" method="post" onSubmit="return checkSearchForm();">
              <div class="form-group input-group">
                <input name="keyword" type="text" class="form-control" placeholder="Search..">
                <span class="input-group-btn">
                  <button class="btn btn-default" type="submit" name="ok" value="開始搜尋">
                    <span class="glyphicon glyphicon-search"></span>
                  </button>
                </span>        
              </div>
            </form>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="member_join.php"><span class="glyphicon glyphicon-user class="navbar-text""></span>訪客</a></li>
              <li class="active"><a href="member_join.php"><span class="active "></span>加入會員</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <main>
      <div class="container text-center">    
        <div class="row">
          <div class="col-sm-3 well">
            <div>
              <?php if(isset($_GET["errMsg"]) && ($_GET["errMsg"]=="1")){?>
                <div class="alert alert-danger"> 登入帳號或密碼錯誤！</div>
              <?php }?>
            </div>

            <h3>登入</h3>
            <form name="form1" method="post" action="">
              <div class="form-group">
                <label for="email">Username:</label>
                <input class="form-control" placeholder="Enter email" name="username" type="text" class="logintextbox" id="username" value="<?php if(isset($_COOKIE["remUser"])){echo $_COOKIE["remUser"];}?>">
              </div>
              <div class="form-group">
                <label for="pwd">Password:</label>
                <input class="form-control" placeholder="Enter password" name="passwd" type="password" class="logintextbox" id="passwd" value="<?php if(isset($_COOKIE["remPass"])){echo $_COOKIE["remPass"];}?>">
              </div>
              <div class="checkbox">
                <label><input name="rememberme" type="checkbox" id="rememberme" value="true" checked> Remember me</label>
              </div>
              <button type="submit" class="btn btn-default" name="button" id="button" value="登入系統">登入系統</button>
            </form>

            <p><a href="admin_passmail.php">忘記密碼，補寄密碼信。</a></p>
            <hr />
            <p>還沒有會員帳號?</p>
            <p>註冊帳號免費又容易</p>
            <p><a href="member_join.php" class="btn btn-default">馬上加入會員</a></p>

          </div>
          
          <div class="col-sm-7">
          
            <div class="row">
              <div class="col-sm-12">
                <div class="panel panel-default text-left">
                  <div class="panel-body">
                    
                    <h3 class="text-center">加入會員後即可貼文！</h3>
                  </div>
                </div>
              </div>
            </div>
            
            <?php echo $searchTitle ?>
            <?php while($row_RecBoard=mysql_fetch_assoc($RecBoard)){ ?>
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
                  <span class="small">
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
              <h3>加入會員即可使用我的相簿</h3>
          </div>
        </div>
      </div>
    </main>

    <?php include("footer_section.php")?>

  </body>
</html>
