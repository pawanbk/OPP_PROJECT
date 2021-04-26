<?php
require_once '../core/init.php';
require_once "{$config['path']['p3']}header.php";
if(Input::exists())
{
  $validation = $v->check($_POST,
  array(
    'firstname' => array (
      'required' => true,
      'min'      => '2',
      'max'      => '20'
    ),
    'lastname' => array (
      'required' => true,
      'min'      => '2',
      'max'      => '20'
    ),
    'email' => array (
      'required' => true,
      'min'      => '5',
      'max'      => '100',
      'unique'   => 'users'
    ),
    'password' => array(
      'required' => true,
      'min'    => '6'
    ),
    'repeat_password' => array(
      'required' => true,
      'matches' => 'password'
    )

  ));
  if($validation->passed())
  {
    $user = new User();
    try{

      $u->create(array(
        'f_name' => Input::get('firstname'),
        'l_name' => Input::get('lastname'),
        'email'  => Input::get('email'),
        'user_pass'=>Hash::make(Input::get('password')),
        'date' => date("Y-m-d")
      ));
      Session::flash('success', 'You registered succesfully. Please login');
      Redirect::to($config['path']['p1']);

    } catch(PDOException $e){
      die($e->getMessage());
    }
  }
  else{
      foreach($validation->getError() as $error){
        echo $error.'<br>';
    }

  }
}

?>
<div class="container"> 
    <div class="wrapper">
      <h3 align="center">Create an Account</h3>
      <form method="post">
        <div class="form-group">
          <label>First name</label>
          <input name="firstname"  value= "<?php echo(Input::get('firstname')); ?>" type="text" class="form-control">
        </div>
        <div class="form-group">
          <label>lastname</label>
          <input name="lastname"  value= "<?php echo(Input::get('lastname')); ?>" type="text" class="form-control">
        </div>
        <div class="form-group">
          <label>Email</label>
          <input name="email"  value= "<?php echo(Input::get('email')); ?>" type="text" class="form-control">
        </div>

        <div class="form-group">
          <label for="">Password</label>
          <input name="password" type="password" class="form-control">
        </div>
        <div class="form-group">
          <label for="">Re-enter Password</label>
          <input name="repeat_password" type="password" class="form-control">
        </div>

        <div class="form-group">
          <input type="submit" value="Register" class="form-control btn btn-primary"> 
        </div>  
        <div class='links'>
          <strong> Already have an Account? <a href="<?php echo $config['path']['p1']?>">Login</a></strong>
        </div>  
        <p>By creating an account, you agree to the Terms of Service. For more information about GitHub's privacy practices, see the GitHub Privacy Statement. We'll occasionally send you account-related emails.</p> 
      </form>
  </div>
</div>

