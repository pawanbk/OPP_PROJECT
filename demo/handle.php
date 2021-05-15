<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
	<title></title>
</head>
<body>
	<div class="container">
  <h2 class="title">Registration</h2>
  <form action="#" name="registration">

    <label for="firstname">First Name</label>
    <input type="text" name="firstname" id="firstname" placeholder="John">

    <label for="lastname">Last Name</label>
    <input type="text" name="lastname" id="lastname" placeholder="Doe">

    <label for="email">Email</label>
    <input type="email" name="email" id="email" placeholder="john@doe.com">

    <label for="password">Password</label>
    <input type="password" name="password" id="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;">

    <button type="submit">Register</button>
  </form>

  <div class="article-reference">
    This example is part of the article
    <a href="https://www.sitepoint.com/basic-jquery-form-validation-tutorial/" target="_blank">Basic jQuery Form Validation Example</a> on <a href="http://sitepoint.com/" target="_blank">SitePoint</a> by
    <a href="https://github.com/julmot" target="_blank">Julian Motz</a>.
  </div>
</div>
<script type="text/javascript">
	HTML CSS JSResult Skip Results Iframe
EDIT ON
// Wait for the DOM to be ready
$(function() {
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  $("form[name='registration']").validate();
  
});
</script>

</body>
</html>
