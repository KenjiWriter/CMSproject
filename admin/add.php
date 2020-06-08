<?php 

	session_start();
	
	include_once('../includes/connection.php');
	
	if( isset($_SESSION['logged_in'])){
		if (isset($_POST['title'], $_POST['content'])){
			$title = $_POST['title'];
			$content = nl2br($_POST['content']);
            $image = $_FILES['photo']['name'];
			
			if (empty($title) or empty($content)) {
				$error = 'All fields are required!';
			} else {
				$query = $pdo-> prepare('INSERT INTO articles (article_title, article_content, article_timestamp, article_image) VALUES (?, ?, ?, ?)');
				$query-> bindValue(1, $title);
				$query-> bindValue(2, $content);
				$query-> bindValue(3, time());
				$query-> bindValue(4, $image);
				
				$query->execute(); 
                
                $target = "images/".basename($image);
                
                if(move_uploaded_file($_FILES['name']['tmp_name'],$target)){
                } else {
                    $error = "There was a problem uploading image";
                }
                
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
        <small style="color:#aa0000;"><?php echo $error ?></small> <br /> <br />
        <?php } ?>
        <form action="add.php" method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Article title..." /><br /> <br />
            <textarea rows="10" cols="60" name="content" placeholder="Article content..."></textarea><br> <br>
            Select image to upload:
            <input type="file" name="photo" id="photo"> <br> <br>
            <input type="submit" value="Add article" name="submit" />
        </form>


    </div>

</body>

</html>

<?php
	} else {
		header('Location: Index.php');
	}

?>
