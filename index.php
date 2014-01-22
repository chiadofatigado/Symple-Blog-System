<?php
//Config File
require 'config.php';
//Database Class
require 'classes/database.php';

$article = new Database;
$article->query("SELECT * FROM articles ORDER BY article_id DESC");
$articles = $article->resultset();

?>
<html>
	<head>
		<title><?php echo BLOG_TITLE; ?></title>
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
	<div class="container">
	<a href="index.php" id="logo"><?php echo BLOG_TITLE; ?></a>
	<header>
	<p><?php echo BLOG_DESCRIPTION; ?></p>
	</header>
	<ul>
		<?php foreach ($articles as $article) { ?>
		<li>
			<a href="article.php?id=<?php echo $article['article_id']; ?>">
			<?php echo $article['title']; ?></a><br>
			<small>
				<?php echo "Posted ".date('d/m/y', $article['article_timestamp']); ?>
			</small><br>
			<?php echo $article['content']; ?><br><br><hr>
		</li>
		<?php } ?>
	</ul>
	<small>Symple Blog System. Created and maintained by <a href="http://www.sandromilhano.com" target="_blank">Sandro Milhano</a>. Version 0.5</small>
	</div>
	</body>
</html>