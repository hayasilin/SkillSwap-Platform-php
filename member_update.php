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
//重新導向頁面
$redirectUrl="member_center.php";
//執行更新動作
if(isset($_POST["action"])&&($_POST["action"]=="update")){	
	$query_update = "UPDATE `memberdata` SET ";
	//若有修改密碼，則更新密碼。
	if(($_POST["m_passwd"]!="")&&($_POST["m_passwd"]==$_POST["m_passwdrecheck"])){
		$query_update .= "`m_passwd`='".md5($_POST["m_passwd"])."',";
	}
	//若有更新大頭貼，再更新
	if ($_FILES["fileUpload"]["name"]!="") {
		$query_update .= "`m_profilepic`='".$_FILES["fileUpload"]["name"]."', ";	
	}

	$query_update .= "`m_name`='".$_POST["m_name"]."',";	
	$query_update .= "`m_sex`='".$_POST["m_sex"]."',";
	$query_update .= "`m_birthday`='".$_POST["m_birthday"]."',";
	$query_update .= "`m_email`='".$_POST["m_email"]."',";
	$query_update .= "`m_url`='".$_POST["m_url"]."',";
	$query_update .= "`m_phone`='".$_POST["m_phone"]."',";
	$query_update .= "`m_address`='".$_POST["m_address"]."' ";
	
	$query_update .= "WHERE `m_id`=".$_POST["m_id"];	
	mysql_query($query_update);

	if($_FILES["fileUpload"]["error"] == 0 || $_FILES["fileUpload"]["name"]!=""){
			if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], "avatars/" . $_FILES["fileUpload"]["name"])) {
				// echo "上傳成功<br />";
				// echo "檔案名稱: ".$_FILES["fileUpload"]["name"]."<br />";
				// echo "檔案類型: ".$_FILES["fileUpload"]["type"]."<br />";
				// echo "檔案大小: ".$_FILES["fileUpload"]["size"]."<br />";
			}else{
				die("檔案上傳失敗");
			}
		}
	//若有修改密碼，則登出回到首頁。
	if(($_POST["m_passwd"]!="")&&($_POST["m_passwd"]==$_POST["m_passwdrecheck"])){
		unset($_SESSION["loginMember"]);
		unset($_SESSION["memberLevel"]);
		$redirectUrl="index.php";
	}		
	//重新導向
	header("Location: $redirectUrl");
}

//繫結登入會員資料
$query_RecMember = "SELECT * FROM `memberdata` WHERE `m_username`='".$_SESSION["loginMember"]."'";
$RecMember = mysql_query($query_RecMember);	
$row_RecMember=mysql_fetch_assoc($RecMember);
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
        margin-top: 20px;
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
<script language="javascript">
function checkForm(){
	if(document.formJoin.m_passwd.value!="" || document.formJoin.m_passwdrecheck.value!=""){
		if(!check_passwd(document.formJoin.m_passwd.value,document.formJoin.m_passwdrecheck.value)){
			document.formJoin.m_passwd.focus();
			return false;
		}
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
    	<?php include("navigation_section.php")?>
  	</header>

  <main>
		<div class="container text-center">    
			<div class="row">
				
				<div class="col-sm-3 well">
					<?php include("member_section.php")?>
				</div>
		
				<div class="col-sm-7">
				  <h3>修改資料</h3>
				  <div class="text-left">
				  <form action="" method="POST" enctype="multipart/form-data" name="formJoin" id="formJoin" onSubmit="return checkForm();">

				  	<hr size="1" />
					<h3>帳號資料</h3>
					<div class="form-group">
						<strong>使用帳號</strong>：<?php echo $row_RecMember["m_username"];?>
					</div>
					<div class="form-group">
						<label for="m_passwd">使用密碼:</label>
						<input class="form-control" name="m_passwd" type="password" id="m_passwd">
					</div>
					<div class="form-group">
						<label for="m_passwdrecheck">確認密碼:</label>
						<input class="form-control" name="m_passwdrecheck" type="password" id="m_passwdrecheck">
                		<span class="small">若不修改密碼，請不要填寫。若要修改，請輸入密碼二次。若修改密碼，系統會自動登出，請用新密碼登入。</span></p>
					</div>
					<hr size="1" />
					<h3>個人資料</h3>
					<div class="form-group">
						<label for="m_name">真實姓名:</label>
						<input name="m_name" type="text" class="form-control" id="m_name" value="<?php echo $row_RecMember["m_name"];?>">
						<font color="#FF0000">*</font>
					</div>
					<div class="form-check">
						<font color="#FF0000">*</font>
						<label>性別:</label>
						<label><input name="m_sex" type="radio" value="女" <?php if($row_RecMember["m_sex"]=="女") echo "checked";?>> 女</label>
						<label><input name="m_sex" type="radio" value="男" <?php if($row_RecMember["m_sex"]=="男") echo "checked";?>> 男</label>
					</div>
					<br />
					<div class="form-group">
						<label for="m_birthday">生日:</label>
						<input name="m_birthday" type="text" class="form-control" id="m_birthday" value="<?php echo $row_RecMember["m_birthday"];?>">
						<font color="#FF0000">*</font>
						<span class="smalltext">為西元格式(YYYY-MM-DD)。</span>
					</div>
					<div class="form-group">
						<label for="m_email">電子郵件:</label>
						<input name="m_email" type="text" class="form-control" id="m_email" value="<?php echo $row_RecMember["m_email"];?>">
						<font color="#FF0000">*</font>
						<span class="small">請確定此電子郵件為可使用狀態，以方便未來系統使用，如補寄會員密碼信。</span>
					</div>
					<div class="form-group">
						<label for="m_url">個人網頁:</label>
						<input name="m_url" type="text" class="form-control" id="m_url" value="<?php echo $row_RecMember["m_url"];?>">
						<span class="small">請以「http://」 為開頭。</span> </p>
					</div>
					<div class="form-group">
						<label for="m_phone">電話:</label>
						<input name="m_phone" type="text" class="form-control" id="m_phone" value="<?php echo $row_RecMember["m_phone"];?>">
					</div>
					<div class="form-group">
						<label for="m_address">住址:</label>
						<input name="m_address" type="text" class="form-control" id="m_address" value="<?php echo $row_RecMember["m_address"];?>" size="40">
					</div>
					<div class="form-group">
						<label>目前的大頭貼:</label>
						<label><img src="avatars/<?php echo $row_RecMember["m_profilepic"]; ?>" class="img-circle" width="65" length="65" alt="Avatar" /></label>
					</div>
					<div class="form-group">
						<label for="fileUpload">變更大頭貼:</label>
						<input class="form-control" type="file" name="fileUpload" id="fileUpload"/>
					</div>

					<input name="m_id" type="hidden" id="m_id" value="<?php echo $row_RecMember["m_id"];?>">
            		<input name="action" type="hidden" id="action" value="update">
            		<input type="submit" name="Submit2" value="修改資料" class="btn btn-default">
            		<input type="reset" name="Submit3" value="重設資料" class="btn btn-default">
            		<input type="button" name="Submit" value="回上一頁" onClick="window.history.back();" class="btn btn-default">
				
					</form>
					</div>
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
