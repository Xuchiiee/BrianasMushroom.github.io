<?php
	include('includes/config.php');
	$reqErr = $loginErr = "";
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		if(!empty($_POST['txtUsername']) && !empty($_POST['txtPassword']) && isset($_POST['login_type'])){
			session_start();
			$username = $_POST['txtUsername'];
			$password = $_POST['txtPassword'];
			$_SESSION['sessLogin_type'] = $_POST['login_type'];
			if($_SESSION['sessLogin_type'] == "retailer") {
				//pag tama yung selected na retailer
				$query_selectRetailer = "SELECT retailer_id,username,password FROM retailer WHERE username='$username' AND password='$password'";
				$result = mysqli_query($con,$query_selectRetailer);
				$row = mysqli_fetch_array($result);
				if($row) {
					$_SESSION['retailer_id'] =  $row['retailer_id'];
					$_SESSION['sessUsername'] = $_POST['txtUsername'];
					$_SESSION['sessPassword'] = $_POST['txtPassword'];
					$_SESSION['retailer_login'] = true;
					header('Location:retailer/index.php');
				}
				else {
					$loginErr = "* Username or Password is incorrect.";
				}
			}
			else if($_SESSION['sessLogin_type'] == "manufacturer") {
				//pag tama yung selected na manuf
				$query_selectManufacturer = "SELECT man_id,username,password FROM manufacturer WHERE username='$username' AND password='$password'";
				$result = mysqli_query($con,$query_selectManufacturer);
				$row = mysqli_fetch_array($result);
				if($row) {
					$_SESSION['manufacturer_id'] =  $row['man_id'];
					$_SESSION['sessUsername'] = $_POST['txtUsername'];
					$_SESSION['sessPassword'] = $_POST['txtPassword'];
					$_SESSION['manufacturer_login'] = true;
					header('Location:manufacturer/index.php');
				}
				else {
					$loginErr = "* Username or Password is incorrect.";
				}
			}
			else if($_SESSION['sessLogin_type'] == "admin") {
				//pag amats
				$query_selectAdmin = "SELECT username,password FROM admin WHERE username='$username' AND password='$password'";
				$result = mysqli_query($con,$query_selectAdmin);
				$row = mysqli_fetch_array($result);
					if($row) {
						$_SESSION['admin_login'] = true;
						$_SESSION['sessUsername'] = $_POST['txtUsername'];
						$_SESSION['sessPassword'] = $_POST['txtPassword'];
						header('Location:admin/index.php');
					}
					else {
						$loginErr = "* Username or Password is incorrect.";
					}
				}
			
				else if ($_SESSION['sessLogin_type'] == "distributor") {
					// pag tama distributor
					$query_selectDistributor = "SELECT dist_name,dist_id FROM distributor WHERE dist_name='$username' AND password='$password'";
					$result = mysqli_query($con, $query_selectDistributor);
					$row = mysqli_fetch_array($result);
					if ($row) {
						$_SESSION['dist_id'] = $row['dist_id'];  // Corrected session variable
						$_SESSION['sessUsername'] = $_POST['txtUsername'];
						$_SESSION['sessPassword'] = $_POST['txtPassword'];
						$_SESSION['distributor_login'] = true;  // Set a session variable to indicate distributor login
						header('Location:distributor/index.php');
						exit();  // Make sure to exit after header redirection
					} else {
						$loginErr = "* Username or Password is incorrect.";
					}
				} else {
					$reqErr = "* All fields are required.";
				}
	}
	}
	
?>
<!DOCTYPE html>
<html>
<head><center>
<img src="../scm-mastermushroom/images/Logoimage.png" alt="Logoimage.png" >
<center>
    <title>Login</title>
    <link rel="stylesheet" href="includes/main_style.css">
	


</head>
<body class="login-box">
	

    <h1>LOGIN</h1>
    <form action="" method="POST" class="login-form">
        <ul class="form-list">
	<li>
		<div class="label-block"> <label for="login:username">Username</label> </div>
		<div class="input-box"> <input type="text" id="login:username" name="txtUsername" placeholder="Username" /> </div>
	</li>
	<li>
		<div class="label-block"> <label for="login:password">Password</label> </div>
		<div class="input-box"> <input type="password" id="login:password" name="txtPassword" placeholder="Password" /> </div>
	</li>
	<li>
		<div class="label-block"> <label for="login:type">Login Type</label> </div>
		<div class="input-box">
		<select name="login_type" id="login:type">
		<option value="" disabled selected>-- Select Type --</option>
		<option value="retailer">Retailer</option>
		<option value="manufacturer">Manufacturer</option>
		<option value="distributor">Distributor</option>
		<option value="admin">Admin</option>
		</select>
		</div>
	</li>
	<li>
		<input type="submit" value="Login" class="submit_button" /> <span class="error_message"> <?php echo $loginErr; echo $reqErr; ?> </span>
	</li>
	</ul>
	</form>
</body>
</html>