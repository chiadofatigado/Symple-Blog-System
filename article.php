<?php

//Config File
require 'config.php';
//Database Class
require 'classes/database.php';


if(isset($_GET['id'])) {
	$id = $_GET['id'];
	
	$article = new Database;

	$article->query("SELECT * FROM articles WHERE article_id = :id");
	$article->bind(":id",$id);
	$article->execute();
	$row = $article->single();

	?>
	<html>
		<head>
			<title><?php echo BLOG_TITLE." - ".$row["title"]; ?></title>
			<link rel="stylesheet" href="css/style.css">
		</head>
		<body>
		<div class="container">
		<a href="index.php" id="logo"><?php echo BLOG_TITLE; ?></a>
		<header>
			<p><?php echo BLOG_DESCRIPTION; ?></p>
			</header>
		<h4>
			<?php echo $row["title"]; ?>
		</h4>
		<small>
				<?php echo "Posted ".date('d/m/y', $row['article_timestamp']); ?>
		</small><br><br>
		<p><?php echo $row['content']; ?></p>
		<br>
		<a href="index.php">&larr; Back</a>
		<br>
		<br>
		<small>Symple Blog System. Created and maintained by <a href="http://www.sandromilhano.com" target="_blank">Sandro Milhano</a>. Version 0.5</small>
		</div>
		</body>
	</html>

	<?php



}else{
	header('Location: index.php');
	exit();
}

?>