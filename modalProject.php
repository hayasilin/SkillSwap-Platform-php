<?php 
require_once("connMysql.php");
include("check_login.php");

//繫結登入會員資料
$query_RecMember = "SELECT * FROM `memberdata` WHERE `m_username`='".$_GET['id']."'";
$RecMember = mysql_query($query_RecMember);	
$row_RecMember=mysql_fetch_assoc($RecMember);
?>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="btn btn-default"> <span aria-hidden="true" class="glyphicon glyphicon-bookmark"> 追蹤 </button>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        </div>
        <div class="modal-body"> 
            <h3>Profile Information</h3>

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