<?php
session_start();

//Config File
require '../config.php';
//Database Class
require '../classes/database.php';

$article = new Database;

$id = $_GET["id"];

if(isset($_SESSION["logged_in"])){
	
	if($_POST["submit_update"]){
					$title = $_POST["title"];
					$content = nl2br($_POST["content"]);

					if(empty($title) or empty($content)){
						$error = "All field are required!";
					}else{
						$database = new Database;

						$database->query("UPDATE articles SET title = ?, content = ? WHERE article_id = ?");

						$database->bind(1, $title);
						$database->bind(2, $content);
						$database->bind(3, $id);

						$database->execute();

						header("Location: update.php?status=updated");
				}	
			}

		$article->query('SELECT * FROM articles WHERE article_id = ?');
		$article->bind(1, $id);
		$row = $article->single();

		?>
			<html>
				<head>
					<title><?php echo BLOG_TITLE." - "."Admin Panel"; ?></title>
					<link rel="stylesheet" href="../css/style.css">
				</head>
				<body>
				<div class="container">
				<a href="index.php" id="logo"><?php echo BLOG_TITLE; ?></a>
				<h4>Edit Post</h4>
				<?php if($_GET["status"] == "updated"){ ?>
					<small style="color:green;"><?php echo $status; ?> </small>
					<br><br>
				<?php } ?>
				<?php if(isset($error)){ ?>
					<small style="color:#aa0000;"><?php echo $error; ?> </small>
					<br><br>
				<?php } ?>
				<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
					<input type="text" name="title" placeholder="Title" size="50" value="<?php echo $row['title']; ?>" ><br>
					<textarea rows="15" cols="50" placeholder="Content" name="content"><?php echo str_replace("<br />", "\n", $row['content']); ?></textarea><br>
					<input type="submit" value="Update post" name="submit_update">
				</form>				
				</div>
				</body>
			</html>
		<?php
?>

<?php
}else{
	header("Location: index.php");
}

?>