<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title><?php getTitle(); ?></title>
		<link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css" />
		<link rel="stylesheet" href="<?php echo $css; ?>jquery-ui-1.10.4.custom.css" />
		<link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css" />
		<link rel="stylesheet" href="<?php echo $css; ?>frontend.css" />
	</head>
	<body>
		<div class="upper-bar">
			<div class="container">
			<?php

				if (isset($_SESSION["user"])) { //check if isset the user session
					
					echo "Welcome " . $sessionUser; //user session

					echo " <a href='profile.php'>profile</a> - ";

					echo " <a href='logout.php'>log out</a>";

					$usrStatuse = checkUserStatuse($sessionUser); //check if the user statuse  not activete

					if($usrStatuse == 1) { //check if the user statuse  not activete
						

					}

				}else{?>
				<a href="login.php">
					<span class="pull-right">Login/SginUp</span>
				</a>
			<?php }?>	
			</div>
		</div>
		<nav class="navbar navbar-inverse">
		  <div class="container">
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="index.php">Home page</a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse navbar-right" id="app-nav">
		      <ul class="nav navbar-nav">
		      <?php
			      	$categories = getCat();

					foreach ($categories as $cat ) {
						echo 
							"<li>
								<a href='categories.php?pageid=". $cat["cat_ID"] ."&pagename=". str_replace(" ", "-", $cat["catName"]) ."'> 
									" . $cat["catName"] . 
								"</a>
							</li>";
					}
				?>
		      </ul>
		    </div>
		  </div>
		</nav>