<?php
if(Input::exists())
{
  $validation = $v->check($_POST, array('email'=> array('required' => true),'password'=> array('required'=> true)));
  if($validation->passed())
  {
    $user = $u->login(Input::get('email'), Input::get('password'));
    if($user)
    {
      Redirect::to('index.php');
    }
    else
    {
      Session::flash('errors','Invalid email or password');
    }
  }
  else
  {
      Session::put('errors','All fields are required.');
  }
} 
?>
   
<div class='conatiner'>
  <div class="wrapper">
    <form method="post">
      <h3 align="center">Login</h3>
      <?php if (Session::exists('errors'))
          {
            echo "<div class='error-flash'><p>"
            .Session::flash('errors').
            "</p></div>";
          }?>
      <div class="form-group">
        <label >Email</label>
        <input name="email" value = "<?php echo(Input::get('email'));?>" type="text" class="form-control"> 
      </div>

      <div class="form-group">
        <label>Password</label>
        <input name="password" type="password" class="form-control" id="exampleInputPassword1">
      </div>

      <div class="form-group">
        <button type="submit" class="form-control btn btn-info">Login</button>
      </div>   
    </form>
    <div class='links'>
      <strong> New Here? <a href="../user/register.php">Register</a></strong>
    </div> 
  </div>
</div>
    
    