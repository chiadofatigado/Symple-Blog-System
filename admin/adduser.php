<?php
//Start Session
session_start();

//Config File
require '../config.php';
//Database Class
require '../classes/database.php';

$status = "Admin account sucessfully created!";

if(isset($_SESSION["logged_in"])){
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
				
				/* Check to see if username has been used */

				//Query
				$database->query('SELECT user_name FROM users WHERE user_name = ?');
				$database->bind(1, $username);
				//Execute
				$database->execute();
				if($database->rowCount() > 0){
					$error = "Sorry, that username is taken";
				}
				
				if(empty($error)){
					$database = new Database;

					$database->query("INSERT INTO users(user_name, user_password) VALUES (?,?)");

					$database->bind(1, $username);
					$database->bind(2, $enc_password);

					$database->execute();

					header("Location: adduser.php?status=created");
			}
		}	

	?>
	<html>
		<head>
			<title><?php echo BLOG_TITLE; ?></title>
			<link rel="stylesheet" href="../css/style.css">
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

<?php
	}else{
		header("Location: index.php");
	}

?>