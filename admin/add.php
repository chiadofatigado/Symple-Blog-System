<?php

session_start();

//Config File
require '../config.php';
//Database Class
require '../classes/database.php';

$status = "Article sucessfully added!";

if(isset($_SESSION["logged_in"])){
		if(isset($_POST["title"], $_POST["content"])){
			$title = $_POST["title"];
			$content = nl2br($_POST["content"]);

			if(empty($title) or empty($content)){
				$error = "All field are required!";
			}else{
				$database = new Database;

				$database->query("INSERT INTO articles(title, content, article_timestamp) VALUES (?,?,?)");

				$database->bind(1, $title);
				$database->bind(2, $content);
				$database->bind(3, time());

				$database->execute();

				header("Location: add.php?status=added");
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
				<a href="index.php" id="logo"><?php echo BLOG_TITLE; ?></a>
				<h4>Add Post</h4>
				<?php if($_GET["status"] == "added"){ ?>
					<small style="color:green;"><?php echo $status; ?> </small>
					<br><br>
				<?php } ?>
				<?php if(isset($error)){ ?>
					<small style="color:#aa0000;"><?php echo $error; ?> </small>
					<br><br>
				<?php } ?>
				<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
					<input type="text" name="title" size="50" placeholder="Title"><br>
					<textarea rows="15" cols="50" placeholder="Content" name="content"></textarea><br>
					<input type="submit" value="Add Post">
				</form>
				</div>
				</body>
		</html>
	<?php
	}else{
		header("Location: index.php");
	}

?>