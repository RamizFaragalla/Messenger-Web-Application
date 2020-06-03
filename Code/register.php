<!DOCTYPE html>
<html>

	<head>
		<title>Messenger Register</title>
		<style>
			.error{
				color: red;
			}

			.button{
				color:green;
			}

			* {
      			font-family: consolas;
      			font-size: 30px;
      			background-color: #1b1b1c;
      			color: white;
    		}
		</style>
	</head>

	<body>

		<!-- error processing -->
		<?php

			if(isset($_GET['error'])){
				if($_GET['error'] == 'emptyfields'){
					echo '<p class="error">';
					echo 'Please fill in all fields';
					echo '</p>';

				} 

				else if($_GET['error'] == 'usernameExists'){
					echo '<p class="error">';
					echo 'Username already exists';
					echo '</p>';
				}
			} 
		?>

		
		<form action="includes/register.inc.php" method="post">
			
			<legend><p></P>Please fill this form:<br><br></legend>
			<br>
			<!-- name field -->
			<p align = "center">
				<label>Username: <input type="text" name="username" size="20" maxlength="40" placeholder="Username"
					value="<?php echo isset($_GET['username']) ? $_GET['username'] : ''?>">
				</label>
			</p>

			<!-- password field -->
			<p align = "center">
				<label>Password: <input type="password" name="password" size="20" maxlength="60" placeholder="Password"> 
				</label>
			</p>

			<br>

			<!-- register button -->
			<p align="center">
				<input type="submit" name="register" value="Register" class="button">
			</p>

		</form>
	</body>	
</html>

