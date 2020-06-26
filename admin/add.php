<?php 

	session_start();
	include_once('../includes/connection.php');
	
	if( isset($_SESSION['logged_in'])){
		if (isset($_POST['title'], $_POST['content'])){
			$title = $_POST['title'];
			$content = nl2br($_POST['content']);
            $image = $_FILES['image']['name'];
            $target = "../images/";
            $target_dir = $target . basename($_FILES["image"]["name"]);
            $imageFileType = pathinfo($target_dir, PATHINFO_EXTENSION);
            $valid_ext = array('PNG','jpeg','jpg','gif','png','JPEG','JPG','GIF');
            $file_size = $_FILES["image"]["size"];
            $imageTemp = $_FILES["image"]["tmp_name"];
			
			if (empty($title) or empty($content)) {
				$error = 'All fields are required!';
			} else {
                if(empty($image)){
                    $query = $pdo-> prepare('INSERT INTO articles (article_title, article_content, article_timestamp) VALUES (?, ?, ?)');
                    $query-> bindValue(1, $title);
                    $query-> bindValue(2, $content);
                    $query-> bindValue(3, time());
                    $query->execute();

                    header('Location: ../index.php');
                } else {
                    function compress($source, $destination, $quality){
                        $imgInfo = getimagesize($source);
                        $mime = $imgInfo['mime'];
                        
                        switch($mime){
                                case 'image/jpeg';
                                    $image = imagecreatefromjpeg($source);
                                    break;                      
                                case 'image/png';
                                    $image = imagecreatefrompng($source);
                                    break;                            
                                case 'image/gif';
                                    $image = imagecreatefromgif($source);
                                    break;
                            default:
                                    $image = imagecreatefromjpeg($source);

                                
                        }
                        imagejpeg($image, $destination, $quality);
                            
                        return $destination;   
                    }
                    if(in_array($imageFileType, $valid_ext)){
                        $compressedImage = compress($imageTemp, $target_dir, 50);
                        
                    if($compressedImage){
                        $compressedImageSize = filesize($compressedImage);
                        $query = $pdo-> prepare('INSERT INTO articles (article_title, article_content, article_timestamp, article_image) VALUES (?, ?, ?, ?)');
                        $query-> bindValue(1, $title);
                        $query-> bindValue(2, $content);
                        $query-> bindValue(3, time());
                        $query-> bindValue(4, $image);
                        $query->execute();
                        header('Location: ../index.php');
                        }
                    }else {
                        $error = 'Sorry, this file extension is not allowed. Plase use: png, jpeg, jpg or gif!';
                    }
                }
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
        <b><small style="color:#aa0000;"><?php echo $error ?></small></b><br><br>
        <?php } ?>
        <form action="add.php" method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Article title..." /><br /> <br />
            <textarea rows="10" cols="60" name="content" placeholder="Article content..."></textarea><br> <br>
            Select image to upload:
            <input type="file" name="image" id="image"> <br> <br>
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
