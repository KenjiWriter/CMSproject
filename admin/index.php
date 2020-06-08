<?php 

	session_start();
	
	include_once('../includes/connection.php');
	
	if (isset($_SESSION['logged_in'])) {
		?>
		
	<!DOCTYPE html>
	<html lang="en">

		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<link rel="stylesheet" href="../style.css" />
			<title>Wenzzi development</title>
		</head>

		<body>
				
			<div class="container">
				<a href=".." id="logo"> CMS </a> <br />
				
				<ol>
					<li>
						<a href="add.php">
							Add Article
						</a>
					</li>					
					
					<li>
						<a href="remove.php">
							Remove Article
						</a>
					</li>					
					
					<li>
						<a href="Edit.php">
							Edit Article
						</a>
					</li>
					<li>
						<a href="logout.php">
							Logout
						</a>
					</li>
				</ol>
				
				
			</div>
				
		</body>

	</html>
		
		
		
		
		<?php
	} else {
		
		if(isset($_POST['username'], $_POST['password'])) {
			$username = $_POST['username'];
			$password = md5($_POST['password']);
		}
		
		if (empty($username) or empty($password)) {
			$error = 'All fields are required!';
		} else {
			$query = $pdo->prepare("SELECT * FROM users WHERE user_login= ? AND user_password= ?");
			
			$query->bindValue(1, $username);
			$query->bindValue(2, $password);
			
			$query->execute();
			
			$num = $query->rowCount();
			
			if ($num == 1) {
				
				$_SESSION['logged_in'] = true;
				header('Location: Index.php');
				exit();
				
			} else {
				$error= 'Incorrect Details!';
			}
		}
		
		?>
		<!DOCTYPE html>
		<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="../style.css" />
		<title>Wenzzi development</title>
	</head>

		<body>
			
			<div class="container">
			<a href=".." id="logo"> CMS </a> <br /> <br />
			
				<?php if (isset($error)) { ?>
				
					<small style="color:#aa0000;"><?php echo $error ?></small>
					<br />
				<?php } ?>
				<form action="index.php" method="post" autocomplete="off">
					<input type="text" name="username" placeholder="Username" />
					<input type="password" name="password" placeholder="Password" />
					<input type="submit" value="login" />
				
				</form>
			</div>
			
		</body>

	</html>
		<?php
	
	}
?>
