<?php 

	session_start();
	
	include_once('../includes/connection.php');
	
	if( isset($_SESSION['logged_in'])){
		if (isset($_POST['title'], $_POST['content'])){
			$title = $_POST['title'];
			$content = nl2br($_POST['content']);
			
			if (empty($title) or empty($content)) {
				$error = 'All fields are required!';
			} else {
				$query = $pdo-> prepare('UPDATE articles (article_title, article_content, article_timestamp) VALUE (?, ?, ?)');
				$query-> bindValue(1, $title);
				$query-> bindValue(2, $content);
				$query-> bindValue(3, time());
				
				$query->execute();
				
				header('Location: Index.php');
			}
		}
		
		
		
		
		?>
		
	<!DOCTYPE html>
	<html lang="en">

		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<link rel="stylesheet" href="../style.css" />
			<title>Wenzzi Development</title>
		</head>

		<body>
				
			<div class="container">
			<a href=".." id="logo"> CMS </a> 
			<br />
				
					<h4> Add Article </h4>
					<?php if (isset($error)) { ?>
						<small style="color:#aa0000;"><?php echo $error ?></small> <br /> <br/>
					<?php } ?>
					<form action="add.php" method="post">
						<input type="text" name="title" placeholder="Article title..."/><br /> <br />
						<textarea rows="10" cols="60" name="content" placeholder="Article content..."></textarea> <br />	
						<input type="submit" value="Add article" />
					</form>
				
			</div>
				
		</body>

	</html>
		
		<?php
	} else {
		header('Location: Index.php');
	}

?>