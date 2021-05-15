<?php
if(Input::exists())
{
  $validation = $v->check($_POST, array('email'=> array('required' => true),'password'=> array('required'=> true)));
  if($validation->passed())
  {
    $user = $u->login(Input::get('email'), Input::get('password'));
    if($user)
    {
      if(Input::get('rememberme'))
      {
        Cookie::put('emailCookie',Input::get('email'));
        Cookie::put('passwordCookie',Input::get('password'));
        Redirect::to($config['base_url'].'index.php');
      }
      else
      {
        Redirect::to($config['base_url'].'index.php'); 
      }
      
    }
    else
    {
      Session::flash('errors','Invalid email or password');
    }
  }
  else
  {
      foreach($validation->getError() as $error)
      Session::put('errors',$error);
  }
} 
?>
   
<div class='box'>
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
        <input name="email" value = "<?php if(Cookie::exists('emailCookie')){echo Cookie::get('emailCookie');}?>" type="text" class="form-control"> 
      </div>

      <div class="form-group">
        <label>Password</label>
        <input name="password" type="password" class="form-control" value="<?php if(Cookie::exists('passwordCookie')){echo Cookie::get('passwordCookie');}?>">
      </div>
      <div class="form-group">
        <input name="rememberme" type="checkbox"> <strong> Remember me</strong>
      </div>
      <div class="form-group">
        <button type="submit" class="form-control btn btn-info">Login</button>
      </div>   
    </form>
    <div class='links'>
      <strong> New Here? <a href="<?php echo base_url('user/register.php')?>">Register</a></strong>
    </div> 
  </div>
</div>
    
    