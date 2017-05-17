<?php
	session_start(); 
	include "init.php";?>

<div class="container">
	<h1 class="text-center"><?php echo str_replace( "-", " ", $_GET["pagename"]);?></h1>
	<div class="row">
			<?php
				$cat_ID = $_GET["pageid"];
			  	$items = getItems('cat_ID', $cat_ID);

				foreach ($items as $item ) {
					echo "<div class='col-sm-6 col-md-3'> ";
						echo "<div class='thumbnail item-box'> ";
							echo "<span class='price'>". $item["itemPrice"] ."</span>";
							echo "<img class='img-responsive' src='avatar.jpg' alt='' />";
							echo "<div class='captions' >";
								echo "<h3 class='text-center' >" . $item["itemName"] . "</h3>";
								echo "<p>" . $item["itemDesc"] . "</p>";
							echo "</div>";
						echo "</div>";
					echo "</div>";	
				}
			?>
	</div>
</div>

<?php include $tpl . "footer.php";?>