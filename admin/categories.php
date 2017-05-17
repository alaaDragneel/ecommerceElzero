
<?php

	/*
	======================================================
	== category Page
	== Can Add | Delete | Edit categories From This Page 
	======================================================
	*/
	ob_start(); //output buffring start
	session_start();
	if (isset($_SESSION['userName'])) {

		$pageTitle = 'Categories';
		
		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'manage';

		//start manage page

		if ($do == 'manage') { // mange member page 
			
			$sort = 'ASC';
			$sort_array = array("ASC", "DESC");
			if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {

				$sort = $_GET['sort'];	

			}
			$selectCat = $conn->prepare("SELECT * FROM categories ORDER BY catOrdring $sort");
			$selectCat->execute();

			$cats = $selectCat->fetchAll();?>
				<h1 class='text-center'>manage Categories</h1>
				<div class='container'>
					<div class="panel panel-default">
						<div class="panel-heading cat">
						Manage Category
							<div class='ordring pull-right'>
								<i class="fa fa-sort"></i> Ordring:
								<a class="<?php if($sort == 'ASC') { echo "active";}?>" href="?sort=ASC">ASC</a>
								 | 
								<a class="<?php if($sort == 'DESC') { echo "active";}?>" href="?sort=DESC">DESC</a>
							</div>
						</div>
						<div class="panel-body catbody">
							<div class='table-responsive'>
								<table class='main-table cat-table text-center table table-bordered table-hover'>
									<tr>
										<td>category name</td>
										<td>Describtion</td>
										<td>visabilty</td>
										<td>commenting</td>
										<td>Ads</td>
										<td>Actions</td>
									</tr>
							<?php 
								foreach($cats as $cat) {
								echo "<tr>";
									echo"<td>" . $cat["catName"] . "</td> ";
									echo"<td>";if($cat["catDesc"] == ''){echo "<span class='disabled' >category has no description</span>";}else{echo $cat["catDesc"];} echo "</td> ";
									if($cat["catVisabilty"] == 1) {echo"<td> the visabilty is <span class='disabled'>hidden</span></td>";} else{echo"<td> the visabilty is <span class='enabled'>show</span></td>";}
									if($cat["catAllowComment"] == 1) {echo"<td> the commenting is <span class='disabled'>disabled</span></td>";} else{echo"<td> the commenting is <span class='enabled'>enabled</span></td>";}
									if($cat["catAllowAds"] == 1) {echo"<td> the ads is <span class='disabled'>disabled</span></td>";} else{echo"<td> the ads is <span class='enabled'>enabled</span></td>";}
									echo "<td>
											<a href='categories.php?do=edit&catId=".$cat["cat_ID"]."' class='btn btn-xs btn-info btn-block'><i class='fa fa-edit'></i> edit</a>
											<a href='categories.php?do=delete&catId=".$cat["cat_ID"]."' class='btn btn-xs btn-danger btn-block confirm'><i class='fa fa-close'></i> delete</a>";
											echo "</td>";
								echo "</tr>";	
								}
							?>
								</table>
							</div>	
							<a href='?do=add' class='addCatgory btn btn-success '>
								<i class='fa fa-plus'></i> new category
							</a>
						</div>
					</div>
				</div>
				<?php

			} elseif ($do == 'add') { //add page?>
				<h1 class='text-center'>add new category</h1>
				<div class='container'>
					<div class='center'>
						<form class='form-horizontal formValidation' action="?do=insert" method='post'>
						<fieldset class='col-sm-10 col-md-12'>
							<legend>Main Information</legend>
							<!-- start category name field -->
								<div class='form-group form-group-lg'>
									<label class='col-sm-2 control-label'>category name</label>
									<div class='col-sm-10 col-md-4'>
										<input type='text' name='catName' class='form-control inputValidation' autocomplete='off' placeholder="category name" />
									</div>
								</div>	
								<!-- end category name field -->

								<!-- start description field -->
								<div class='form-group form-group-lg'>
									<label class='col-sm-2 control-label'>description</label>
									<div class='col-sm-10 col-md-4'>
										<input type='text' name='description' class='form-control'  autocomplete="off" placeholder="the category description"  />
									</div>
								</div>	
								<!-- end description field -->

								<!-- start ordring field -->
								<div class='form-group form-group-lg'>
									<label class='col-sm-2 control-label'>ordring</label>
									<div class='col-sm-10 col-md-4'>
										<input type='text' name='ordring' class='form-control' placeholder="number to arrange the categories"/>
									</div>
								</div>	
								<!-- end ordring field -->

								<!-- start viasplity field -->
								<div class='form-group form-group-lg'>
									<label class='col-sm-2 control-label'>visible</label>
									<div class='col-sm-10 col-md-4'>
										<div>
											<input id="vYes" type="radio" name="visabil" value="0" checked />
											<lable for="vYes">yes</lable>
										</div>
										<div>
											<input id="vNo" type="radio" name="visabil" value="1" />
											<lable for="vNo">no</lable>
										</div>

									</div>
								</div>	
								<!-- end viasplity field -->
								<!-- start commenting field -->
								<div class='form-group form-group-lg'>
									<label class='col-sm-2 control-label'>Allow Commenting</label>
									<div class='col-sm-10 col-md-4'>
										<div>
											<input id="cYes" type="radio" name="commenting" value="0" checked />
											<lable for="cYes">yes</lable>
										</div>
										<div>
											<input id="cNo" type="radio" name="commenting" value="1" />
											<lable for="cNo">no</lable>
										</div>

									</div>
								</div>	
								<!-- end commenting field -->
								<!-- start ads field -->
								<div class='form-group form-group-lg'>
									<label class='col-sm-2 control-label'>Allow Ads</label>
									<div class='col-sm-10 col-md-4'>
										<div>
											<input id="aYes" type="radio" name="ads" value="0" checked />
											<lable for="aYes">yes</lable>
										</div>
										<div>
											<input id="aNo" type="radio" name="ads" value="1" />
											<lable for="aNo">no</lable>
										</div>

									</div>
								</div>	
								<!-- end ads field -->
								<div class='errorMessage'></div>
							</fieldset>
							<fieldset class='col-sm-10 col-md-12''>
								<legend>options</legend>
								<!-- start submit button -->
								<div class='form-group form-group-lg'>
									<div class='col-sm-offset-2 col-sm-10 col-md-4'>
										<input type='submit' class='btn btn-primary btn-lg btn-block' value='add category' />
									</div>
								</div>	
								<!-- end submit button -->
								<!-- start clear button -->
								<div class='form-group form-group-lg'>
									<div class='col-sm-offset-2 col-sm-10 col-md-4'>
										<input type='reset' class='btn btn-danger btn-lg btn-block' value='clear' />
									</div>
								</div>	
								<!-- end clear button -->	
							</fieldset>	
						</form>
					</div>
				</div>
			<?php
			} elseif ($do == 'insert') { //insert page

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					echo "<h1 class='text-center'>add new Category</h1>";
					//get varibles from the form

					$catName 			= trim(strip_tags($_POST['catName']));
					$description 		= trim(strip_tags($_POST['description']));
					$ordring 			= trim(strip_tags($_POST['ordring']));
					$visabil 			= trim(strip_tags($_POST['visabil']));
					$commenting 		= trim(strip_tags($_POST['commenting']));
					$ads 				= trim(strip_tags($_POST['ads']));


					//validate the form

					$formErrors = array();

					if (empty($catName)) {
						$formErrors[] = 'category name can\'t be empty';
					}
					if (trim(strip_tags($_POST['catName'])) === false) {
						$formErrors[] = 'please use a validate characters in the category name field';
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

						//check if category exist in database
						$check = checkItme("catName", "categories", $catName);
						if ($check == 1) {
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
							$msg = '<div class="alert alert-danger"><strong>sorry this Category is exist</strong></div>';
							redirect($msg, 'prev', 'prev');
						
						echo '</div>';

						} else {

							//insert categories information into the database

							$stmt = $conn->prepare("INSERT INTO 
															categories(catName, catDesc, catOrdring, catVisabilty, catAllowComment, catAllowAds) 
													VALUES(:zcName, :zcDesc, :zcOrd, :zcVis, :zcCom, :zcAds) ");

							$stmt->execute(array(

								'zcName' 	 => $catName,
								'zcDesc' 	 => $description,
								'zcOrd'	 	 => $ordring,
								'zcVis'	 	 => $visabil,
								'zcCom'	 	 => $commenting,
								'zcAds'	 	 => $ads

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
					redirect($msg, 'backPage');
				}
				echo '</div>';

			} elseif ($do == 'edit') {		//edit page

			//check if the cat id is numeric and get the integer value
			$catId = isset($_GET['catId']) && is_numeric($_GET['catId']) ? intval($_GET['catId']) : 0;

			//select all data depend on the id
			$stmt = $conn->prepare("SELECT * FROM categories WHERE cat_ID = ?");
			//excute he data
			$stmt->execute(array($catId));
			//fetch the data
			$cat = $stmt->fetch();
			//row count
			$count = $stmt->rowCount();
			//if there is such id show form
			if ($count > 0) { ?>	
				<h1 class='text-center'>edit category</h1>
				<div class='container'>
					<div class='center'>
						<form class='form-horizontal formValidation' action="?do=update" method='post'>
						<input type='hidden' name='catId' value='<?php echo $catId; ?>' />
						<fieldset class='col-sm-10 col-md-12'>
							<legend>Main Information</legend>
							<!-- start category name field -->
								<div class='form-group form-group-lg'>
									<label class='col-sm-2 control-label'>category name</label>
									<div class='col-sm-10 col-md-4'>
										<input type='text' name='catName' class='form-control inputValidation' value="<?php echo $cat["catName"]?>" />
									</div>
								</div>	
								<!-- end category name field -->

								<!-- start description field -->
								<div class='form-group form-group-lg'>
									<label class='col-sm-2 control-label'>description</label>
									<div class='col-sm-10 col-md-4'>
										<input type='text' name='description' class='form-control' value="<?php echo $cat["catDesc"]?>" />
									</div>
								</div>	
								<!-- end description field -->

								<!-- start ordring field -->
								<div class='form-group form-group-lg'>
									<label class='col-sm-2 control-label'>ordring</label>
									<div class='col-sm-10 col-md-4'>
										<input type='text' name='ordring' class='form-control' value="<?php echo $cat["catOrdring"]?>"/>
									</div>
								</div>	
								<!-- end ordring field -->

								<!-- start viasplity field -->
								<div class='form-group form-group-lg'>
									<label class='col-sm-2 control-label'>visible</label>
									<div class='col-sm-10 col-md-4'>
										<div>
											<input id="vYes" type="radio" name="visabil" value="0" <?php if($cat["catVisabilty"] == 0 ) {echo "checked";}?>/>
											<lable for="vYes">yes</lable>
										</div>
										<div>
											<input id="vNo" type="radio" name="visabil" value="1" <?php if($cat["catVisabilty"] == 1 ) {echo "checked";}?>/>
											<lable for="vNo">no</lable>
										</div>

									</div>
								</div>	
								<!-- end viasplity field -->
								<!-- start commenting field -->
								<div class='form-group form-group-lg'>
									<label class='col-sm-2 control-label'>Allow Commenting</label>
									<div class='col-sm-10 col-md-4'>
										<div>
											<input id="cYes" type="radio" name="commenting" value="0" <?php if($cat["catAllowComment"] == 0 ) {echo "checked";}?>/>
											<lable for="cYes">yes</lable>
										</div>
										<div>
											<input id="cNo" type="radio" name="commenting" value="1" <?php if($cat["catAllowComment"] == 1 ) {echo "checked";}?>/>
											<lable for="cNo">no</lable>
										</div>

									</div>
								</div>	
								<!-- end commenting field -->
								<!-- start ads field -->
								<div class='form-group form-group-lg'>
									<label class='col-sm-2 control-label'>Allow Ads</label>
									<div class='col-sm-10 col-md-4'>
										<div>
											<input id="aYes" type="radio" name="ads" value="0" <?php if($cat["catAllowAds"] == 0 ) {echo "checked";}?>/>
											<lable for="aYes">yes</lable>
										</div>
										<div>
											<input id="aNo" type="radio" name="ads" value="1" <?php if($cat["catAllowAds"] == 1 ) {echo "checked";}?>/>
											<lable for="aNo">no</lable>
										</div>

									</div>
								</div>	
								<!-- end ads field -->
								<div class='errorMessage'></div>
							</fieldset>
							<fieldset class='col-sm-10 col-md-12''>
								<legend>options</legend>
								<!-- start submit button -->
								<div class='form-group form-group-lg'>
									<div class='col-sm-offset-2 col-sm-10 col-md-4'>
										<input type='submit' class='btn btn-primary btn-lg btn-block' value='add category' />
									</div>
								</div>	
								<!-- end submit button -->
								<!-- start clear button -->
								<div class='form-group form-group-lg'>
									<div class='col-sm-offset-2 col-sm-10 col-md-4'>
										<input type='reset' class='btn btn-danger btn-lg btn-block' value='clear' />
									</div>
								</div>	
								<!-- end clear button -->	
							</fieldset>	
						</form>
					</div>
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

				$msg =  "<div class='alert alert-danger' style='font-family: cursive; font-size: 17px;'><strong>there is no such ID[ ". $catId ." ]</strong></div>";

				redirect($msg);

				echo "</div>";
			}

			} elseif ($do == 'update') { //updaye page
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					echo "<h1 class='text-center'>update category</h1>";
					//get varibles from the form

					$catId 				= trim(strip_tags($_POST['catId']));
					$catName 			= trim(strip_tags($_POST['catName']));
					$description 		= trim(strip_tags($_POST['description']));
					$ordring 			= trim(strip_tags($_POST['ordring']));
					$visabil 			= trim(strip_tags($_POST['visabil']));
					$commenting 		= trim(strip_tags($_POST['commenting']));
					$ads 				= trim(strip_tags($_POST['ads']));

					//update the database

					$stmt = $conn->prepare("UPDATE 
												categories
											SET 
												catName = ?, 
												catDesc = ?, 
												catOrdring = ?, 
												catVisabilty = ?, 
												catAllowComment = ?, 
												catAllowAds = ? 
											WHERE 
												cat_ID = ?");
					$stmt->execute(array($catName, $description, $ordring, $visabil, $commenting, $ads, $catId));

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
				echo "<h1 class='text-center'>delete category page</h1>";
			//check if the category id is numeric and get the integer value
			$catId = isset($_GET['catId']) && is_numeric($_GET['catId']) ? intval($_GET['catId']) : 0;

			//select all data depend on the id

			$check = checkItme( 'cat_ID', 'categories', $catId);
			//if there is such id show form
			if ($check > 0) { 

				$stmt = $conn->prepare("DELETE FROM categories WHERE cat_ID = :zcat");
				$stmt->bindParam(":zcat", $catId);
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
					$stmt->rowCount() . " Recourd deleted </strong></div>
				";
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
		}

		include $tpl . "footer.php";

	} else {
		header('location: index.php');
		 
		exit();
	}

	ob_end_flush();
