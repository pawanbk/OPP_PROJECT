<?php
require_once 'core/init.php';
require_once 'header.php';
$user = new User();
if(Input::exists())
{
  $validate = new Validate();
  $validation = $validate -> check($_POST, array('username'=> array('required' => true),'password'=> array('required'=> true)));
  if($validation->passed())
  {
    $user = $user->login(Input::get('username'), Input::get('password'));
    if($user)
    {
      Redirect::to('index.php');
    }
    else
    {
      echo 'invalid username or password';
    }
  }
  else
  {
    foreach($validation->getError() as $error){
      echo $error."<br>";
    }
  }
} 
?>
    <h2>Login</h2>
    <div class="wrapper">
      <form method="post">
            <div class="form-group">
               <label for="exampleInputEmail1">Username</label>
               <input name="username" id = 'username' value = "<?php echo(Input::get('username'));?>" type="text" class="form-control">
              
           </div>

           <div class="form-group">
               <label for="exampleInputPassword1">Password</label>
               <input name="password" type="password" class="form-control" id="exampleInputPassword1">
          </div>
           
           <div class="form-group">
              <button type="submit" class="form-control btn btn-success">Login</button>
          </div>
          <div class='links'>
                <strong> Create a new Account? <a href="index.php">Register Now </a></strong>
          </div>
             
          </form>

    </div>
    
    