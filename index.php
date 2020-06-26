<?php 

    include_once('includes/connection.php');
    include_once('includes/article.php');

    $article = new Article;
    $articles = $article->fetch_all();
	
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>Wenzzi Development</title>
</head>

<body>

    <div class="container">
        <a href="index.php" id="logo"> CMS </a>
        <ol>
            <?php foreach ($articles as $article) { ?>
            <li>
                <a href="article.php?id=<?php echo $article['article_id']; ?>">
                    <?php echo $article['article_title']; ?>
                </a>
                - <small>
                    posted <?php echo date('l jS', $article['article_timestamp']); ?>
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
