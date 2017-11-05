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
              <li><a href="member_join.php"><span class="glyphicon glyphicon-user"></span>申請會員</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <main>
      <div class="container">

        <div>
          <?php if(isset($_GET["errMsg"]) && ($_GET["errMsg"]=="1")){?>
            <div class="alert alert-danger"> 登入帳號或密碼錯誤！</div>
          <?php }?>
        </div>

        <h2>登入會員系統</h2>
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
        <p><a href="member_join.php">馬上申請會員</a></p>
      </div>
    </main>
  </body>
</html>
