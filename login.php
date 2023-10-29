<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,
	initial-scale=1.0">
	<title>Login - SmartSafeEDU!.</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="icon" href="img/logo111.png">
</head>
<body class="body-login">
	<div class="black-fill"> <br /> <br />
		<div class="d-flex justify-content-center align-items-center flex-column">
			<form class="login"
				  method="post"
				  action="req/login.php">
				<div class="text-center">
					<img src="img/logo123.png"
						 width="100">
				</div>
				<h3>LOGIN</h3>
				<?php if (isset($_GET['error'])) { ?>
    			<div class="alert alert-danger" role="alert">
			  		<?=$_GET['error']?>
				</div>
				<?php } ?>
			  <div class="mb-3">
			    <label for="exampleInputEmail1" class="form-label">ID</label>
			    <input type="text" 
			    	   class="form-control"
			    	   name="uname">
			  </div>
			  <div class="mb-3">
			    <label for="exampleInputEmail1" class="form-label">Password</label>
			    <input type="Password" 
			    	   class="form-control"
			    	   name="pass">
			  </div>

			  	<div class="mb-3">
			    	<label class="form-label">Login As</label>
					    <select class="form-control"
					    		name="role">
						    <option value="1">Admin</option>
						    <option value="2">Staff</option>
						    <option value="3">Student or Parents</option>
						    <option value="4">Registrar Office</option>
						</select>
			  </div>
			  <button type="submit" class="btn btn-primary">Login</button>
			  <a href="index.php" class ="text-decoration-none">Home</a>
			</form>
		<br /> <br />
		<div class="text-center text-light">
			Copyright &copy; 2023 SmartSafeEDU. All rights reserved.
		</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>