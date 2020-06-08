<?php 

	session_start();
	
	include_once('../includes/connection.php');
    include_once('../includes/article.php');

    $article = new Article;
	$articles = $article->fetch_all();
	
	if (isset($_SESSION['logged_in'])) {
		?>
		
	<!DOCTYPE html>
	<html lang="en">

		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<link rel="stylesheet" href="../style.css" />
			<title>Wenzzi Developnet</title>
		</head>

		<body>
			
			<div class="container">
				<a href="index.php" id="logo"> CMS </a>
				<ol>
					<?php foreach ($articles as $article) { ?>
					<li>
						<a href="editarticle.php?id=<?php echo $article['article_id']; ?>">
							<?php echo $article['article_title']; ?>
						</a>
						- <small>
							
						</small>
					</li>
					<?php } ?>
				</ol>
				<br />
				
				<small>
					<a href="admin">
						Control Panel
					</a>
				</small>
			</div>
			
		</body>

	</html>
		
		<?php
	} else {
		header('Location: index.php');
	}
	





?>