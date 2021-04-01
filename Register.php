
<?php
require_once 'core/init.php';
require_once 'links.php';
include 'nav.php';

if(Input::exists()){
  $validate = new Validate();
  $validation = $validate->check($_POST,
    array(
      'username' => array (
        'required' => true,
        'min'      => '5',
        'max'      => '20',
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
  if($validation->passed()){
    $user = new User();
    try{

      $user->create(array(
      'username'=>Input::get('username'),
      'user_pass'=>Hash::make(Input::get('password')),
      'date' => date("Y-m-d")
    ));
      Session::flash('success', 'You registered succesfully. Please login');
      Redirect::to('index.php');
      
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
    <h2 align="center">Create an Account</h2>
		<div class="wrapper">
			<form method="post">
            <div class="form-group">
               <label for="exampleInputEmail1">Username</label>
               <input name="username" id = 'username' value= "<?php echo(Input::get('username')); ?>" type="text" class="form-control">
              
           </div>

           <div class="form-group">
               <label for="exampleInputPassword1">Password</label>
               <input name="password" type="password" class="form-control" id="exampleInputPassword1">
          </div>
          <div class="form-group">
               <label for="exampleInputPassword1">Re-enter Password</label>
               <input name="repeat_password" type="password" class="form-control" id="exampleInputPassword1">
          </div>
           
           <div class="form-group">
              <input type="submit" value="Register" class="form-control btn btn-primary"> 
          </div>    
          <p>By creating an account, you agree to the Terms of Service. For more information about GitHub's privacy practices, see the GitHub Privacy Statement. We'll occasionally send you account-related emails.</p> 
          </form>


		</div>
	