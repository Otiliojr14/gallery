<?php 

require_once("./includes/header.php");

if (isset($_GET['close_session'])) {
	$session->logout();
}

if ($session->is_signed_in()) {
    redirect("index.php");
}

?>


<div class="col-md-4 col-md-offset-3">

<h4 class="bg-danger"></h4>
	
<form id="login-id" action="" method="post">
	
<div class="form-group">
	<label for="username">Username</label>
	<input type="text" class="form-control" name="username" id="username">

</div>

<div class="form-group">
	<label for="password">Password</label>
	<input type="password" class="form-control" name="password" id="password">
	
</div>


<div class="form-group">
<input type="submit" name="submit" value="Submit" class="btn btn-primary">

</div>


</form>


</div>

<script src="js/sweetalert2.all.min.js"></script>
<script src="./js/login.js" type="module"></script>