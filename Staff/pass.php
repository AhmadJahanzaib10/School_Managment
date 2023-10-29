<?php 
session_start();
if (isset($_SESSION['staff_id']) && 
    isset($_SESSION['role'])){

    if ($_SESSION['role'] == 'Staff') {      	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher - Change Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../img/logo111.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

	<?php 
		include "inc/navbar.php";
	 ?>
	 <div class="d-flex justify-content-center align-items-center flex-column">
		<form method="post"
			  class="shadow p-3 my-5 form-w"
		      action="req/teacher-change.php"
		      id="change_password">	
		  <h3>Change Password</h3><hr>
				<?php if (isset($_GET['perror'])) { ?>
					<div class="alert alert-danger" role="alert">
				  		<?=$_GET['perror']?>
					</div>
				<?php } ?>
				<?php if (isset($_GET['psuccess'])) { ?>
					<div class="alert alert-success" role="alert">
				  		<?=$_GET['psuccess']?>
					</div>
				<?php } ?>	 	 	   	      
	  <div class="mb-3">
			  <div class="mb-3">
			    <label class="form-label">Old password</label>
			    	<input type="password" 
			    		   class="form-control"
			    		   name="old_pass">
			  </div>
	    <label class="form-label">New password</label>
	    <div class="input-group mb-3">
	    	<input type="text" 
	    		   class="form-control"
	    		   name="new_pass"
	    		   id="passInput">
	    	<button class="btn btn-secondary"
	    			id="gBtn">
	    			Random</button>
	    </div>
	  </div>	
	  <div class="mb-3">
	    <label class="form-label">Confirm new password</label>
	    	<input type="text" 
	    		   class="form-control"
	    		   name="c_new_pass"
	    		   id="passInput2">
	  </div>
	  <button type="submit" class="btn btn-primary">Change</button>
	</form>	 	

	 </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script> 
	$(document).ready(function(){
		$("#navLinks li:nth-child(6) a").addClass('active');
		  });

	function makePass(length) {
		    let result = '';
		    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		    const charactersLength = characters.length;
		    let counter = 0;
		    while (counter < length) {
		      result += characters.charAt(Math.floor(Math.random() * charactersLength));
		      counter += 1;
		    }
		    var passInput = document.getElementById('passInput');
		    var passInput2 = document.getElementById('passInput2');
		    passInput.value = result;
		    passInput2.value = result;
		}
		var gBtn = document.getElementById('gBtn');
    	gBtn.addEventListener('click', function(e){
    		e.preventDefault();
    		makePass(7);
    	});
	</script>

</body>
</html>
<?php 
    }else{
        header("location: ../login.php");
        exit;
    } 
}else{
    header("location: ../login.php");
    exit;
} 
?>
