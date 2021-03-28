
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">OPP Project</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <?php
        require_once 'core/init.php';
        $user = new user();
        if($user->isLoggedIn()){
           ?>
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> logout</a></li>
        <?php } else{?>
         <li><a href="Register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
         <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> login</a></li>
       <?php }?>
    </ul>
  </div>
</nav>