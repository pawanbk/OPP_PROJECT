<?php
require_once 'core/init.php';
require_once 'links.php';
if(Session::exists('success')){
	echo '<div class="alert alert-success" role="alert">'
          .Session::flash('success').
         '</div>';
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<?php include 'nav.php'; ?>

</body>
</html>



