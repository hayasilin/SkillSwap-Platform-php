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

      <form class="navbar-form navbar-right" role="search" name="searchForm" action="search_result.php" method="post" onSubmit="return checkSearchForm();">
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
        <li><a href="member_update.php"><span class="glyphicon glyphicon-user"></span><?php echo $row_RecMember["m_name"];?></a></li>
        <li><a href="?logout=true"><span>登出</span></a></li>
      </ul>
    </div>
  </div>
</nav>