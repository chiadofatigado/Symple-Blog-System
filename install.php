<?php
//Config File
require 'config.php';
//Database Class
require 'classes/database.php';

$status = "Admin account sucessfully created! Please delete install.php now! Start adding content by going to www.yoursite.com/admin";

if(isset($_POST["username"], $_POST["password"])){
			$username = $_POST["username"];
			$password = $_POST["password"];
			$password2 = $_POST["password2"];
			$enc_password = md5($_POST["password"]);

			$database = new Database;

			if(empty($username) or empty($password)){
				$error = "All field are required!";
			}

			if($password != $password2){
				$error = "The passwords do not match!";
			}
			
			if(empty($error)){
				$database = new Database;

				$database->query("INSERT INTO users(user_name, user_password) VALUES (?,?)");

				$database->bind(1, $username);
				$database->bind(2, $enc_password);

				$database->execute();

				header("Location: install.php?status=created");
		}
	}	

?>
<html>
	<head>
		<title><?php echo BLOG_TITLE; ?></title>
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
	<div class="container">
	<a href="index.php" id="logo"><?php echo BLOG_TITLE; ?></a>
	<br>
	<h3>Use this form to create other admin users.</h3>
	<?php if($_GET["status"] == "created"){ ?>
					<small style="color:green;"><?php echo $status; ?> </small>
					<br>
				<?php } ?>
	<?php if(isset($error)){ ?>
		<small style="color:#aa0000;"><?php echo $error; ?> </small>
		<br>
	<?php } ?>
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
		<h4>Username:</h4>
		<input type="text" name="username" placeholder="Username" value="<?php if($_POST['username'])echo $_POST['username'] ?>">
		<h4>Password:</h4>
		<input type="password" name="password" placeholder="Password"><br>
		<input type="password" name="password2" placeholder="Retype password"><br>
		<input type="submit" value="Create admin account">
	</form>

	</div>
	</body>
</html>