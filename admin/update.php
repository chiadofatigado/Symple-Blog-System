<?php

session_start();

//Config File
require '../config.php';
//Database Class
require '../classes/database.php';

$article = new Database;

$status = "Article sucessfully updated!";

if(isset($_SESSION["logged_in"])){

	$article->query("SELECT * FROM articles");
	$articles = $article->resultset();

	if(isset($_GET["id"])){
		$id = $_GET["id"];

		$article->query('SELECT * FROM articles WHERE article_id = ?');
		$article->bind(1, $id);
		$row = $article->single();

		?>
		<?php
		
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
		<h4>Edit Post</h4>
		<?php if($_GET["status"] == "updated"){ ?>
			<small style="color:green;"><?php echo $status; ?> </small>
			<br><br>
		<?php } ?>
		<?php if(isset($error)){ ?>
			<small style="color:#aa0000;"><?php echo $error; ?> </small>
			<br><br>
		<?php } ?>
		<form id="form" action="update2.php" method="get">
			<select id="select" name="id" onchange="this.form.submit()";>
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