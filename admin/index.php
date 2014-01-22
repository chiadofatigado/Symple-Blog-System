<?php
//Start Session
session_start();

//Config File
require '../config.php';
//Database Class
require '../classes/database.php';

$database = new Database;

if(isset($_SESSION['logged_in'])){
	?>

	<html>
		<head>
			<title><?php echo BLOG_TITLE." - "."Admin Panel"; ?></title>
			<link rel="stylesheet" href="../css/style.css">
		</head>
		<body>
		<div class="container">
		<a href="index.php" id="logo"><?php echo BLOG_TITLE; ?></a>
		<br>
		<p>Hello <?php echo $_SESSION['username']; ?>!</p>
			<table>
				<tr>
					<td><br>
						<center><p><b>Posts</b></p></center>
						<ul>
							<li><a href="add.php">Add Post</a></li>
							<li><a href="update.php">Update Post</a></li>
							<li><a href="delete.php">Delete Post</a></li>
						</ul>
					</td>
					<td><br>
						<center><p><b>System</b></p></center>
						<ul>
							<li><a href="updateuser.php">Update Admin account</a></li>
							<li><a href="adduser.php">Create new Admin account</a></li>
							<li><a href="logout.php">Logout</a></li>
						</ul>
					</td>
				</tr>
			</table>
		<small>Symple Blog System. Created and maintained by <a href="http://www.sandromilhano.com" target="_blank">Sandro Milhano</a>. Version 0.5</small>
		</div>
		</body>
	</html>

	<?php

}else{

	if(isset($_POST["username"], $_POST["password"])){
		$username = $_POST["username"];
		$password = md5($_POST["password"]);

		if(empty($username) or empty($password)){
			$error = "All field are required!";
		}else{
			$database = new Database;

			$database->query("SELECT * FROM users WHERE user_name = ? and user_password = ?");

			$database->bind(1, $username);
			$database->bind(2, $password);

			$database->execute();
			$row = $database->single();
			$num = $database->rowCount();

			if($num == 1) {
				$_SESSION['logged_in'] = true;
				$_SESSION['username'] = $username;
				$_SESSION['user_id'] = $row["user_id"];

				header('Location: index.php');
				exit();
			}else{
				$error = "Wrong username or password";
			}
		}
	}

	?>
		<html>
			<head>
				<title><?php echo BLOG_TITLE." - "."Admin Panel"; ?></title>
				<link rel="stylesheet" href="../css/style.css">
			</head>
			<body>
			<div class="container">
			<a href="../index.php" id="logo"><?php echo BLOG_TITLE; ?></a>
			<br><br>

			<?php if(isset($error)){ ?>
				<small style="color:#aa0000;"><?php echo $error; ?> </small>
				<br><br>
			<?php } ?>

			<form action="index.php" method="post" autocomplete="off">
			<input type="text" name="username" placeholder="Username">
			<input type="password" name="password" placeholder="Password">
			<input type="submit" value="login">
			</form>

			</div>
			</body>
		</html>
	<?php
}

?>