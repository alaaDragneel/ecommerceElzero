<?php

	/*
	=========================================
	== items Page
	=========================================
	*/
	ob_start(); //output buffring start
	session_start();
	if (isset($_SESSION['userName'])) {

		$pageTitle = 'Items';
		
		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'manage';

		//start manage page

		if ($do == 'manage') { // mange items page 

			//select the data from users table execpt the admin
			$items = $conn->prepare("SELECT 
										items.*, 
										categories.catName  AS category_name, 
										users.userName 		AS user_name 
									FROM 
										items 
									INNER JOIN 
										categories 
									ON 
										categories.cat_ID = items.cat_ID 
									INNER JOIN 
										users 
									ON 
										users.userId = items.userId
									ORDER BY item_ID DESC	
");
			//execute the statement
			$items->execute();

			//assign to variable

			$rows = $items->fetchAll();
			if(!empty($rows)){
			?>
			<h1 class='text-center'>manage  items</h1>
			<div class='container'>
				<div class='table-responsive'>
					<table class='main-table text-center table table-bordered table-hover'>
						<tr>
							<td>#ID</td>
							<td>item name</td>
							<td>item description</td>
							<td>item price</td>
							<td>adding date</td>
							<td>country Made</td>
							<td>item statuse</td>
							<td>Category</td>
							<td>Adding user</td>
							<td>control</td>

						</tr>
						<?php
							foreach ($rows as $row) {
								echo "<tr>";
									echo "<td>" . $row['item_ID'] . "</td>";
									echo "<td>" . $row['itemName'] . "</td>";
									echo "<td>" . $row['itemDesc'] . "</td>";
									echo "<td>" . $row['itemPrice'] . "</td>";
									echo "<td>" . $row['itemAddingDate'] . "</td>";
									echo "<td>" . $row['itemCountryMade'] . "</td>";
									echo "<td>" . $row['itemStatuse'] . "</td>";
									echo "<td>" . $row['category_name'] . "</td>";
									echo "<td>" . $row['user_name'] . "</td>";


									echo "<td>
											<a href='items.php?do=edit&id=".$row['item_ID']."' class='btn btn-info btn-block'><i class='fa fa-edit'></i> edit</a>
											<a href='items.php?do=delete&id=".$row['item_ID']."' class='btn btn-danger btn-block confirm'><i class='fa fa-close'></i> delete</a>";
										if ($row['itemApprove'] == 0) {
										  
										  	echo "<a href='items.php?do=approve&id=".$row['item_ID']."' class='btn btn-primary btn-block '><i class='fa fa-check'></i> approve</a>";

										  }	
										  echo "</td>";
								echo "</tr>";

							}
						?>
					</table>
				</div>
				<a href='?do=add' class='addCatgory btn btn-success '>
					<i class='fa fa-plus'></i> new items
				</a>
			</div>			
<?php   }else{
			echo '
				 	 <div 
				  		class	=	"container text-center" 
						style	=	"
										position: absolute;
										margin-top: 20px;
										background-color: #fff;
										left: 94px;
										top: 156px;
										padding: 40px;
										border-radius: 10px;
										box-shadow: 1px 4px 19px #eee;
									">
						 ';
			echo'<div class="alert alert-warning">there is no items to show</div> ';
			
			echo"</div>";
		}
		} elseif ($do == 'add') { //add page ?>
			<h1 class='text-center'>add new item</h1>
			<div class='container'>
				<div class='center'>
					<form class='form-horizontal formValidation' action="?do=insert" method='post'>
					<fieldset class='col-sm-10 col-md-12'>
						<legend>Main Information</legend>
						<!-- start item name field -->
							<div class='form-group form-group-lg'>
								<label class='col-sm-2 control-label'>item name</label>
								<div class='col-sm-10 col-md-4'>
									<input 
										type='text' 
										name='itemName' 
										class='form-control inputValidation' 
										placeholder="item name" />
								</div>
							</div>	
							<!-- end item name field -->

							<!-- start item description field -->
							<div class='form-group form-group-lg'>
								<label class='col-sm-2 control-label'>item description</label>
								<div class='col-sm-10 col-md-4'>
									<input 
										type='text' 
										name='itemDesc' 
										class='form-control inputValidation' 
										placeholder="item description" />
								</div>
							</div>	
							<!-- end item description field -->

							<!-- start item price field -->
							<div class='form-group form-group-lg'>
								<label class='col-sm-2 control-label'>item price</label>
								<div class='col-sm-10 col-md-4'>
									<input 
										type='text' 
										name='itemPrice' 
										class='form-control inputValidation' 
										placeholder="item price" />
								</div>
							</div>	
							<!-- end item price field -->

							<!-- start item country field -->
							<div class='form-group form-group-lg'>
								<label class='col-sm-2 control-label'>item counctry</label>
								<div class='col-sm-10 col-md-4'>
									<input 
										type='text' 
										name='itemCountry' 
										class='form-control inputValidation' 
										placeholder="item country" />
								</div>
							</div>	
							<!-- end item country field -->

							<!-- start item statuse field -->
							<div class='form-group form-group-lg'>
								<label class='col-sm-2 control-label'>item status</label>
								<div class='col-sm-10 col-md-4'>
									<select name="status">
										<option value="0" >....</option>
										<option value="1" >New</option>
										<option value="2" >Like New</option>
										<option value="3" >Used</option>
										<option value="4" >Old</option>
									</select>
								</div>
							</div>	
							<!-- end item statuse field -->

							<!-- start item member field -->
							<div class='form-group form-group-lg'>
								<label class='col-sm-2 control-label'>member</label>
								<div class='col-sm-10 col-md-4'>
									<select name="member">
										<option value="0" >....</option>
										<?php
											// prepare the query
											$users = $conn->prepare("SELECT * FROM users");
											// execute the query
											$users->execute();
											// fetch the data
											$rows = $users->fetchAll();
											//loop
											foreach($rows as $row) {
												echo '<option value="'.$row["userId"].'" >'.$row["userName"].'</option>';
											}
										
										?>
									</select>
								</div>
							</div>	
							<!-- end item member field -->

							<!-- start item category field -->
							<div class='form-group form-group-lg'>
								<label class='col-sm-2 control-label'>category</label>
								<div class='col-sm-10 col-md-4'>
									<select name="category">
										<option value="0" >....</option>
										<?php
											// prepare the query
											$cat = $conn->prepare("SELECT * FROM categories");
											//execute the query
											$cat->execute();
											// fetch the data
											$rows = $cat->fetchAll();
											//loop
											foreach($rows as $row) {
												echo '<option value="'.$row["cat_ID"].'" >'.$row["catName"].'</option>';
											}
										
										?>
									</select>
								</div>
							</div>	
							<!-- end item category field -->

							<div class='errorMessage'></div>
						</fieldset>
						<fieldset class='col-sm-10 col-md-12''>
							<legend>options</legend>
							<!-- start submit button -->
							<div class='form-group form-group-lg'>
								<div class='col-sm-offset-2 col-sm-10 col-md-4'>
									<input type='submit' class='btn btn-primary ' value='add item' />
								</div>
							</div>	
							<!-- end submit button -->
							<!-- start clear button -->
							<div class='form-group form-group-lg'>
								<div class='col-sm-offset-2 col-sm-10 col-md-4'>
									<input type='reset' class='btn btn-danger ' value='clear' />
								</div>
							</div>	
							<!-- end clear button -->	
						</fieldset>	
					</form>
				</div>
			</div>
<?php   } elseif ($do == 'insert') {//insert page

			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h1 class='text-center'>add new item</h1>";
				//get varibles from the form

				$itemName 		= trim(strip_tags($_POST['itemName']));
				$itemDesc 		= trim(strip_tags($_POST['itemDesc']));
				$itemPrice 		= trim(strip_tags($_POST['itemPrice']));
				$itemCountry 	= trim(strip_tags($_POST['itemCountry']));
				$status 		= trim(strip_tags($_POST['status']));
				$member 		= trim(strip_tags($_POST['member']));
				$category 		= trim(strip_tags($_POST['category']));


				//validate the form

				$formErrors = array();

				if (empty($itemName)) {
					$formErrors[] = 'item name can\'t be empty';
				}
				if (empty($itemDesc)) {
					$formErrors[] = 'item description can\'t be empty';
				} 
				if (empty($itemPrice)) {
					$formErrors[] = 'price can\'t be empty';
				}
				if (empty($itemCountry)) {
					$formErrors[] = 'item country can\'t be empty';
				}
				if ($status == 0) {
					$formErrors[] = 'statuse must be choosen';
				}
				if ($member == 0) {
					$formErrors[] = 'member must be choosen';
				}
				if ($category == 0) {
					$formErrors[] = 'category must be choosen';
				}



				if(!empty($formErrors)){
					//the result of the validation and inputs
					echo '
				 	 <div 
				  		class	=	"container text-center" 
						style	=	"
										position: absolute;
										margin-top: 20px;
										background-color: #fff;
										left: 94px;
										top: 156px;
										padding: 40px;
										border-radius: 10px;
										box-shadow: 1px 4px 19px #eee;
									">
						 ';
					//start loop to get the errors
					foreach ($formErrors as $error) {
							
						echo '<div class="alert alert-danger"><strong>' . $error . '</strong></div>';
					
					}//end loop
					
					echo '</div>';
					
				}

				//if the array is empty compelete the query
				if (empty($formErrors)) {

					//insert user information into the database

					$stmt = $conn->prepare("INSERT INTO 
													items(itemName, itemDesc, itemPrice, itemCountryMade, itemStatuse, itemAddingDate, cat_ID, userId) 
											VALUES(:iname, :idesc, :iprice, :icun, :ista, now(), :icat, :iuser) ");

					$stmt->execute(array(

						'iname' 	 => $itemName,
						'idesc' 	 => $itemDesc,
						'iprice'	 => $itemPrice,
						'icun' 	 	 => $itemCountry,
						'ista' 	 	 => $status,
						'icat' 	 	 => $category,
						'iuser' 	 => $member

					));

					//echo success massage

					echo '
				 	 <div 
				  		class	=	"container text-center" 
						style	=	"
										position: absolute;
										margin-top: 20px;
										background-color: #fff;
										left: 94px;
										top: 156px;
										padding: 40px;
										border-radius: 10px;
										box-shadow: 1px 4px 19px #eee;
									">
						 ';
						$msg = '<div class="alert alert-success" style="font-family: cursive; font-size: 17px;"><strong>' .
						$stmt->rowCount() . " Recourd inserted </strong></div>";

						 redirect($msg, 'backPage', 'prev');
				}

			} else {
				echo '
				 	 <div 
				  		class	=	"container text-center" 
						style	=	"
										position: absolute;
										margin-top: 20px;
										background-color: #fff;
										left: 94px;
										top: 156px;
										padding: 40px;
										border-radius: 10px;
										box-shadow: 1px 4px 19px #eee;
									">
								 ';
				$msg = "<div class='alert alert-danger' style='font-family: cursive; font-size: 17px;'><strong>you can\'t browes this page directlly </srtrong></div>";
				redirect($msg);
			}
			echo '</div>'; 

		} elseif ($do == 'edit') {	//edit page

			//check if the item id is numeric and get the integer value
			$itemId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

			//select all data depend on the id
			$item = $conn->prepare("SELECT * FROM items WHERE item_ID = ? LIMIT 1");
			//excute he data
			$item->execute(array($itemId));
			//fetch the data
			$rowItem = $item->fetch();
			//row count
			$count = $item->rowCount();
			//if there is such id show form
			if ($count > 0) { ?>	

				<h1 class='text-center'>Edit items</h1>
				<div class='container'>
					<div class='center'>
						<form class='form-horizontal formValidation' action="?do=update" method='post'>
						<input type='hidden' name='itemId' value='<?php echo $itemId; ?>' />
						<fieldset class='col-sm-10 col-md-12'>
							<legend>Main Information</legend>
							<!-- start item name field -->
								<div class='form-group form-group-lg'>
									<label class='col-sm-2 control-label'>item name</label>
									<div class='col-sm-10 col-md-4'>
										<input 
											type='text' 
											name='itemName' 
											class='form-control inputValidation' 
											placeholder="item name" value="<?php echo $rowItem["itemName"]?>" />
									</div>
								</div>	
								<!-- end item name field -->

								<!-- start item description field -->
								<div class='form-group form-group-lg'>
									<label class='col-sm-2 control-label'>item description</label>
									<div class='col-sm-10 col-md-4'>
										<input 
											type='text' 
											name='itemDesc' 
											class='form-control inputValidation' 
											placeholder="item description" value="<?php echo $rowItem["itemDesc"]?>"/>
									</div>
								</div>	
								<!-- end item description field -->

								<!-- start item price field -->
								<div class='form-group form-group-lg'>
									<label class='col-sm-2 control-label'>item price</label>
									<div class='col-sm-10 col-md-4'>
										<input 
											type='text' 
											name='itemPrice' 
											class='form-control inputValidation' 
											placeholder="item price" value="<?php echo $rowItem["itemPrice"]?>"/>
									</div>
								</div>	
								<!-- end item price field -->

								<!-- start item country field -->
								<div class='form-group form-group-lg'>
									<label class='col-sm-2 control-label'>item counctry</label>
									<div class='col-sm-10 col-md-4'>
										<input 
											type='text' 
											name='itemCountry' 
											class='form-control inputValidation' 
											placeholder="item country" value="<?php echo $rowItem["itemCountryMade"]?>"/>
									</div>
								</div>	
								<!-- end item country field -->

								<!-- start item statuse field -->
								<div class='form-group form-group-lg'>
									<label class='col-sm-2 control-label'>item status</label>
									<div class='col-sm-10 col-md-4'>
										<select name="status">
											<option value="1" <?php if($rowItem["itemStatuse"] == 1){echo "selected";} ?> >New</option>
											<option value="2" <?php if($rowItem["itemStatuse"] == 2){echo "selected";} ?> >Like New</option>
											<option value="3" <?php if($rowItem["itemStatuse"] == 3){echo "selected";} ?> >Used</option>
											<option value="4" <?php if($rowItem["itemStatuse"] == 4){echo "selected";} ?> >Old</option>
										</select>
									</div>
								</div>	
								<!-- end item statuse field -->

								<!-- start item member field -->
								<div class='form-group form-group-lg'>
									<label class='col-sm-2 control-label'>member</label>
									<div class='col-sm-10 col-md-4'>
										<select name="member">
											<?php
												// prepare the query
												$users = $conn->prepare("SELECT * FROM users");
												// execute the query
												$users->execute();
												// fetch the data
												$rows = $users->fetchAll();
												//loop
												foreach($rows as $row) {
													echo '<option value="'.$row["userId"].'"';
													if( $rowItem["userId"] == $row["userId"]){echo "selected";}
													echo'>'.$row["userName"].'</option>';
												}
											
											?>
										</select>
									</div>
								</div>	
								<!-- end item member field -->

								<!-- start item category field -->
								<div class='form-group form-group-lg'>
									<label class='col-sm-2 control-label'>category</label>
									<div class='col-sm-10 col-md-4'>
										<select name="category">
											<?php
												// prepare the query
												$cat = $conn->prepare("SELECT * FROM categories");
												//execute the query
												$cat->execute();
												// fetch the data
												$rows = $cat->fetchAll();
												//loop
												foreach($rows as $row) {
													echo '<option value="'.$row["cat_ID"].'"';
													if( $rowItem["cat_ID"] == $row["cat_ID"]){echo "selected";}
													echo' >'.$row["catName"].'</option>';
												}
											
											?>
										</select>
									</div>
								</div>	
								<!-- end item category field -->

								<div class='errorMessage'></div>
							</fieldset>
							<fieldset class='col-sm-10 col-md-12''>
								<legend>options</legend>
								<!-- start submit button -->
								<div class='form-group form-group-lg'>
									<div class='col-sm-offset-2 col-sm-10 col-md-4'>
										<input type='submit' class='btn btn-primary ' value='update item' />
									</div>
								</div>	
								<!-- end submit button -->
								<!-- start clear button -->
								<div class='form-group form-group-lg'>
									<div class='col-sm-offset-2 col-sm-10 col-md-4'>
										<input type='reset' class='btn btn-danger ' value='clear' />
									</div>
								</div>	
								<!-- end clear button -->	
							</fieldset>	
						</form>
					</div>
				<?php

				//select the data from users table execpt the admin
				$stmt = $conn->prepare("SELECT 
											comments.* ,
											users.userName AS User_Name
										FROM 
										 	comments

										INNER JOIN
										 	users
										ON 
											users.userId = comments.userId

										WHERE
											item_ID = ?	

									  ");
				//execute the statement
				$stmt->execute(array($itemId));

				//assign to variable

				$rows = $stmt->fetchAll();

				if(! empty($rows)) {
			?>

				<h1 class='text-center'>manage [ <?php echo $rowItem["itemName"]?> ] comments</h1>
					<div class='table-responsive'>
						<table class='main-table text-center table table-bordered table-hover'>
							<tr>
								<td>comment</td>
								<td>member name</td>
								<td>added Date</td>
								<td>control</td>
							</tr>
							<?php
								foreach ($rows as $row) {
									echo "<tr>";
										echo "<td>" . $row['commentName'] . "</td>";
										echo "<td>" . $row['User_Name'] . "</td>";
										echo "<td>" . $row['commentDate'] . "</td>";
										echo "<td>
												<a href='comments.php?do=edit&c_id=".$row['c_ID']."' class='btn btn-info'><i class='fa fa-edit'></i> edit</a>
												<a href='comments.php?do=delete&c_id=".$row['c_ID']."' class='btn btn-danger confirm'><i class='fa fa-close'></i> delete</a>";

											  if ($row['commentStatuse'] == 0) {
											  
											  	echo "<a href='comments.php?do=approve&c_id=".$row['c_ID']."' class='btn btn-primary activate'><i class='fa fa-check'></i> Approve</a>";

											  }

											  echo "</td>";
									echo "</tr>";

								}
							?>
						</table>
					</div>
					<?php }?>
				</div>
			<?php 

				} else {//if there is no such id do't show the form
				echo '
						 	 <div 
						  		class	=	"container text-center" 
								style	=	"
												position: absolute;
												margin-top: 20px;
												background-color: #fff;
												left: 94px;
												top: 156px;
												padding: 40px;
												border-radius: 10px;
												box-shadow: 1px 4px 19px #eee;
											">
								 ';

					$msg =  "<div class='alert alert-danger' style='font-family: cursive; font-size: 17px;'><strong>there is no such ID[ ". $itemId ." ]</strong></div>";

					redirect($msg);

					echo "</div>";
				}

		} elseif ($do == 'update') { //updaye page
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h1 class='text-center'>update item</h1>";

				//get varibles from the form

				$itemId 		= $_POST['itemId'];
				$itemName 		= trim(strip_tags($_POST['itemName']));
				$itemDesc 		= trim(strip_tags($_POST['itemDesc']));
				$itemPrice 		= trim(strip_tags($_POST['itemPrice']));
				$itemCountry 	= trim(strip_tags($_POST['itemCountry']));
				$status 		= trim(strip_tags($_POST['status']));
				$member 		= trim(strip_tags($_POST['member']));
				$category 		= trim(strip_tags($_POST['category']));


				//validate the form

				$formErrors = array();

				if (empty($itemName)) {
					$formErrors[] = 'item name can\'t be empty';
				}
				if (empty($itemDesc)) {
					$formErrors[] = 'item description can\'t be empty';
				} 
				if (empty($itemPrice)) {
					$formErrors[] = 'price can\'t be empty';
				}
				if (empty($itemCountry)) {
					$formErrors[] = 'item country can\'t be empty';
				}
				if ($status == 0) {
					$formErrors[] = 'statuse must be choosen';
				}
				if ($member == 0) {
					$formErrors[] = 'member must be choosen';
				}
				if ($category == 0) {
					$formErrors[] = 'category must be choosen';
				}



				if(!empty($formErrors)){
					//the result of the validation and inputs
					echo '
				 	 <div 
				  		class	=	"container text-center" 
						style	=	"
										position: absolute;
										margin-top: 20px;
										background-color: #fff;
										left: 94px;
										top: 156px;
										padding: 40px;
										border-radius: 10px;
										box-shadow: 1px 4px 19px #eee;
									">
						 ';
					//start loop to get the errors
					foreach ($formErrors as $error) {
							
						echo '<div class="alert alert-danger"><strong>' . $error . '</strong></div>';
					
					}//end loop
					
					echo '</div>';
					
				}

				//if the array is empty compelete the query
				if (empty($formErrors)) {

					//update the database

					$stmt = $conn->prepare("UPDATE
											 	items
											SET 
												itemName 		 = ?, 
					
												itemDesc		 = ?, 
					
												itemPrice 		 = ?, 

												itemCountryMade  = ?, 

												itemStatuse 	 = ?, 
												
												cat_ID 			 = ?, 

												userId      	 = ? 
											
											WHERE 
												item_ID = ?
											");

					$stmt->execute(array($itemName, $itemDesc, $itemPrice, $itemCountry, $status, $category, $member, $itemId));

					//echo success massage

					echo '
				 	 <div 
				  		class	=	"container text-center" 
						style	=	"
										position: absolute;
										margin-top: 20px;
										background-color: #fff;
										left: 94px;
										top: 156px;
										padding: 40px;
										border-radius: 10px;
										box-shadow: 1px 4px 19px #eee;
									">
						 ';
						$msg = '<div class="alert alert-success" style="font-family: cursive; font-size: 17px;"><strong>' .
						 $stmt->rowCount() . " Recourd updated </strong></div>";
						 redirect($msg, 'backPage', 'prev');
				}
			} else {
			echo '
				 <div 
					class	=	"container text-center" 
					style	=	"
								position: absolute;
								margin-top: 20px;
								background-color: #fff;
								left: 94px;
								top: 156px;
								padding: 40px;
								border-radius: 10px;
								box-shadow: 1px 4px 19px #eee;
							">
				 ';
				$msg =  '<div class="alert alert-danger" style="font-family: cursive; font-size: 17px;"><strong>you can\'t browes this page directlly</storng></div> ';
				redirect($msg);
				echo "</div>";
			}
	
		} elseif ($do == 'delete') { //delete page
			echo "<h1 class='text-center'>delete items page</h1>";
			//check if the user id is numeric and get the integer value
			$itemId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

			//select all data depend on the id

			$check = checkItme( 'item_ID', 'items', $itemId);
			//if there is such id show form
			if ($check > 0) { 

				$stmt = $conn->prepare("DELETE FROM items WHERE item_ID = :item");
				$stmt->bindParam(":item", $itemId);
				$stmt->execute();

				//echo success massage

					echo '
				 	 <div 
				  		class	=	"container text-center" 
						style	=	"
										position: absolute;
										margin-top: 20px;
										background-color: #fff;
										left: 94px;
										top: 156px;
										padding: 40px;
										border-radius: 10px;
										box-shadow: 1px 4px 19px #eee;
									">
						 ';
						$msg = '<div class="alert alert-success" style="font-family: cursive; font-size: 17px;"><strong>' .
						 $stmt->rowCount() . " Recourd deleted </strong></div>";
						 redirect($msg, 'manage', 'manage');
				} else {
					echo '
				 	 <div 
				  		class	=	"container text-center" 
						style	=	"
										position: absolute;
										margin-top: 20px;
										background-color: #fff;
										left: 94px;
										top: 156px;
										padding: 40px;
										border-radius: 10px;
										box-shadow: 1px 4px 19px #eee;
									">';
				$msg =  '<div class="alert alert-danger" style="font-family: cursive; font-size: 17px;"><strong>this id not exist</storng></div> ';
				redirect($msg);
				echo "</div>";
			
			}
		
		} elseif ($do == 'approve') {

			echo "<h1 class='text-center'>approve item page</h1>";
			//check if the user id is numeric and get the integer value
			$itemId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

			//select all data depend on the id

			$check = checkItme( 'item_ID', 'items', $itemId);
			//if there is such id show form
			if ($check > 0) { 

				$stmt = $conn->prepare("UPDATE items SET itemApprove = 1 WHERE item_ID = ?");
				$stmt->execute(array($itemId));

				//echo success massage

					echo '
				 	 <div 
				  		class	=	"container text-center" 
						style	=	"
										position: absolute;
										margin-top: 20px;
										background-color: #fff;
										left: 94px;
										top: 156px;
										padding: 40px;
										border-radius: 10px;
										box-shadow: 1px 4px 19px #eee;
									">
						 ';
						$msg = '<div class="alert alert-success" style="font-family: cursive; font-size: 17px;"><strong>' .
						 $stmt->rowCount() . " item Approved </strong></div>";
						 redirect($msg, 'approvePage', 'Approve Item');
				} else {
					echo '
				 	 <div 
				  		class	=	"container text-center" 
						style	=	"
										position: absolute;
										margin-top: 20px;
										background-color: #fff;
										left: 94px;
										top: 156px;
										padding: 40px;
										border-radius: 10px;
										box-shadow: 1px 4px 19px #eee;
									">';
				$msg =  '<div class="alert alert-danger" style="font-family: cursive; font-size: 17px;"><strong>this id not exist</storng></div> ';
				redirect($msg);
				echo "</div>";
			}
		
		}	

		include $tpl . "footer.php";

	} else {
		header('location: index.php');
		 
		exit();
	}

	ob_end_flush();
