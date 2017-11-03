<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("connMysql.php");
if(isset($_POST["action"])&&($_POST["action"]=="join")){
	//找尋帳號是否已經註冊
	$query_RecFindUser = "SELECT `m_username` FROM `memberdata` WHERE `m_username`='".$_POST["m_username"]."'";
	$RecFindUser=mysql_query($query_RecFindUser);
	if (mysql_num_rows($RecFindUser)>0){
		header("Location: member_join.php?errMsg=1&username=".$_POST["m_username"]);
	}else{
	//若沒有執行新增的動作	
		$query_insert = "INSERT INTO `memberdata` (`m_name` ,`m_username` ,`m_passwd` ,`m_sex` ,`m_birthday` ,`m_email`,`m_url`,`m_phone`,`m_address`,`m_jointime`,`m_profilepic`) VALUES (";
		$query_insert .= "'".$_POST["m_name"]."',";
		$query_insert .= "'".$_POST["m_username"]."',";
		$query_insert .= "'".md5($_POST["m_passwd"])."',";
		$query_insert .= "'".$_POST["m_sex"]."',";
		$query_insert .= "'".$_POST["m_birthday"]."',";
		$query_insert .= "'".$_POST["m_email"]."',";
		$query_insert .= "'".$_POST["m_url"]."',";	
		$query_insert .= "'".$_POST["m_phone"]."',";
		$query_insert .= "'".$_POST["m_address"]."',";	
		$query_insert .= "NOW(),";
		$query_insert .= "'" . $_FILES["fileUpload"]["name"] . "')";
		mysql_query($query_insert);
		if($_FILES["fileUpload"]["error"] == 0){
			if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], "avatars/" . $_FILES["fileUpload"]["name"])) {
				// echo "上傳成功<br />";
				// echo "檔案名稱: ".$_FILES["fileUpload"]["name"]."<br />";
				// echo "檔案類型: ".$_FILES["fileUpload"]["type"]."<br />";
				// echo "檔案大小: ".$_FILES["fileUpload"]["size"]."<br />";
			}else{
				die("檔案上傳失敗");
			}
		}
		header("Location: member_join.php?loginStats=1");
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

<script language="javascript">
function checkForm(){
	if(document.formJoin.m_username.value==""){		
		alert("請填寫帳號!");
		document.formJoin.m_username.focus();
		return false;
	}else{
		uid=document.formJoin.m_username.value;
		if(uid.length<5 || uid.length>12){
			alert( "您的帳號長度只能5至12個字元!" );
			document.formJoin.m_username.focus();
			return false;
		}
		if(!(uid.charAt(0)>='a' && uid.charAt(0)<='z')){
			alert("您的帳號第一字元只能為小寫字母!" );
			document.formJoin.m_username.focus();
			return false;
		}
		for(idx=0;idx<uid.length;idx++){
			if(uid.charAt(idx)>='A'&&uid.charAt(idx)<='Z'){
				alert("帳號不可以含有大寫字元!" );
				document.formJoin.m_username.focus();
				return false;
			}
			if(!(( uid.charAt(idx)>='a'&&uid.charAt(idx)<='z')||(uid.charAt(idx)>='0'&& uid.charAt(idx)<='9')||( uid.charAt(idx)=='_'))){
				alert( "您的帳號只能是數字,英文字母及「_」等符號,其他的符號都不能使用!" );
				document.formJoin.m_username.focus();
				return false;
			}
			if(uid.charAt(idx)=='_'&&uid.charAt(idx-1)=='_'){
				alert( "「_」符號不可相連 !\n" );
				document.formJoin.m_username.focus();
				return false;				
			}
		}
	}
	if(!check_passwd(document.formJoin.m_passwd.value,document.formJoin.m_passwdrecheck.value)){
		document.formJoin.m_passwd.focus();
		return false;
	}	
	if(document.formJoin.m_name.value==""){
		alert("請填寫姓名!");
		document.formJoin.m_name.focus();
		return false;
	}
	if(document.formJoin.m_birthday.value==""){
		alert("請填寫生日!");
		document.formJoin.m_birthday.focus();
		return false;
	}
	if(document.formJoin.m_email.value==""){
		alert("請填寫電子郵件!");
		document.formJoin.m_email.focus();
		return false;
	}
	if(!checkmail(document.formJoin.m_email)){
		document.formJoin.m_email.focus();
		return false;
	}
	return confirm('確定送出嗎？');
}
function check_passwd(pw1,pw2){
	if(pw1==''){
		alert("密碼不可以空白!");
		return false;
	}
	for(var idx=0;idx<pw1.length;idx++){
		if(pw1.charAt(idx) == ' ' || pw1.charAt(idx) == '\"'){
			alert("密碼不可以含有空白或雙引號 !\n");
			return false;
		}
		if(pw1.length<5 || pw1.length>10){
			alert( "密碼長度只能5到10個字母 !\n" );
			return false;
		}
		if(pw1!= pw2){
			alert("密碼二次輸入不一樣,請重新輸入 !\n");
			return false;
		}
	}
	return true;
}
function checkmail(myEmail) {
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if(filter.test(myEmail.value)){
		return true;
	}
	alert("電子郵件格式不正確");
	return false;
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
            <a class="navbar-brand" href="index.php">Skill Swap</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
              <li class="active"><a href="index.php">Home</a></li>
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

	<?php if(isset($_GET["loginStats"]) && ($_GET["loginStats"]=="1")){?>
	<script language="javascript">
	alert('會員新增成功\n請用申請的帳號密碼登入。');
	window.location.href='index.php';		  
	</script>
	<?php }?>
	
	<div class="container">
		<div class="row">
			<div class="col-md-2">
			<!-- none -->
			</div>
			<div class="col-md-6">
				<h2>加入會員</h2>

				<?php if(isset($_GET["errMsg"]) && ($_GET["errMsg"]=="1")){?>
          			<div class="alert alert-danger">帳號 <?php echo $_GET["username"];?> 已經有人使用！</div>
          		<?php }?>

				<form action="" enctype="multipart/form-data" method="POST" name="formJoin" id="formJoin" onSubmit="return checkForm();">
					<hr size="1" />
					<h3>帳號資料</h3>
					<div class="form-group">
						<label for="m_username">使用帳號:</label>
						<input class="form-control" name="m_username" type="text" id="m_username">
						<font color="#FF0000">*</font>
                		<span class="smalltext">請填入5~12個字元以內的小寫英文字母、數字、以及_ 符號。</span></p>
					</div>
					<div class="form-group">
						<label for="m_passwd">使用密碼:</label>
						<input class="form-control" name="m_passwd" type="password" id="m_passwd">
						<font color="#FF0000">*</font>
                		<span class="smalltext">請填入5~10個字元以內的英文字母、數字、以及各種符號組合，</span></p>
					</div>
					<div class="form-group">
						<label for="m_passwdrecheck">確認密碼:</label>
						<input class="form-control" name="m_passwdrecheck" type="password" id="m_passwdrecheck">
						<font color="#FF0000">*</font>
                		<span class="smalltext">再輸入一次密碼</span></p>
					</div>
					<hr size="1" />
					<h3>個人資料</h3>
					<div class="form-group">
						<label for="m_name">真實姓名:</label>
						<input class="form-control" name="m_name" type="text" id="m_name">
						<font color="#FF0000">*</font>
					</div>
					<div class="form-check">
						<font color="#FF0000">*</font>
						<label>性別:</label>
						<label><input name="m_sex" type="radio" value="女" checked> 女</label>
						<label><input name="m_sex" type="radio" value="男"> 男</label>
					</div>
					<br />
					<div class="form-group">
						<label for="m_birthday">生日:</label>
						<input class="form-control" name="m_birthday" type="text" id="m_birthday">
						<font color="#FF0000">*</font>
						<span class="smalltext">為西元格式(YYYY-MM-DD)。</span>
					</div>
					<div class="form-group">
						<label for="pwd">電子郵件:</label>
						<input class="form-control" name="m_email" type="text" id="m_email">
						<font color="#FF0000">*</font>
						<span class="small">請確定此電子郵件為可使用狀態，以方便未來系統使用，如補寄會員密碼信。</span>
					</div>
					<div class="form-group">
						<label for="pwd">個人網頁:</label>
						<input class="form-control" name="m_url" type="text" id="m_url">
						<span class="small">請以「http://」 為開頭。</span> </p>
					</div>
					<div class="form-group">
						<label for="pwd">電話:</label>
						<input class="form-control" name="m_phone" type="text" id="m_phone">
					</div>
					<div class="form-group">
						<label for="pwd">住址:</label>
						<input class="form-control" name="m_address" type="text" id="m_address" size="40">
					</div>
					<div class="form-group">
						<label for="pwd">上傳大頭貼:</label>
						<input class="form-control" type="file" name="fileUpload" id="fileUpload"/>
					</div>
					<p> <font color="#FF0000">*</font> 表示為必填的欄位</p>

					<input name="action" type="hidden" id="action" value="join">
            		<input type="submit" name="Submit2" value="送出申請" class="btn btn-primary">
            		<input type="reset" name="Submit3" value="重設資料">
            		<input type="button" name="Submit" value="回上一頁" onClick="window.history.back();" class="btn btn-default">
				</form>
			</div>
			<div class="col-md-4">
				<p><strong>填寫資料注意事項：</strong></p>
				<ol>
					<li> 請提供您本人正確、最新及完整的資料。 </li>
					<li> 在欄位後方出現「*」符號表示為必填的欄位。</li>
					<li>填寫時請您遵守各個欄位後方的補助說明。</li>
					<li>關於您的會員註冊以及其他特定資料，本系統不會向任何人出售或出借你所填寫的個人資料。</li>
					<li>在註冊成功後，除了「使用帳號」外您可以在會員專區內修改您所填寫的個人資料。</li>
				</ol>
			</div>
		</div>
	</div>
	
</body>
</html>
