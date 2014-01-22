<?php

session_start();

//Config File
require '../config.php';
//Database Class
require '../classes/database.php';

$article = new Database;

if(isset($_SESSION["logged_in"])){
	if(isset($_GET["id"])){
		$id = $_GET["id"];

		$article->query("DELETE FROM articles WHERE article_id = ?");
		$article->bind(1, $id);

		$article->execute();

		header("Location: delete.php?status=deleted");
	}
	$article->query("SELECT * FROM articles");
	$articles = $article->resultset();
	?>
	<html>
		<head>
			<title><?php echo BLOG_TITLE." - "."Admin Panel"; ?></title>
			<link rel="stylesheet" href="../css/style.css">

			<script>
				function confirmDelete()
				{
					var box = confirm("Are you sure you want to delete that post?");
					if (box == true)
					  {
					  	document.getElementById("form").submit();
					  }
					else
					  {
					  	return false;
					  }
				}
			</script>
		</head>
		<body>
		<div class="container">
		<a href="index.php" id="logo"><?php echo BLOG_TITLE; ?></a>
		<br>
		<h4>Select a post to delete</h4>
		<p>Select the post you want to delete.</p>
		<?php if($_GET["status"] == "deleted"){ ?>
				<small style="color:red;">
					<?php echo "Article deleted!"; ?> 
				</small>
				<br><br>
		<?php } ?>
		<form id="form" action="delete.php" method="get">
			<select id="select" name="id" onchange="confirmDelete()";>
				<option selected="selected" disabled="true">--Select Post--</option>
				<?php foreach ($articles as $article) { ?>
					<option value="<?php echo $article["article_id"]; ?>">
						<?php echo $article["title"]; ?>
					</option>
				<?php } ?>
			</select>
		</form>
		</div>
		</body>
	</html>


<?php
	}else{
		header("Location: index.php");
	}
?>