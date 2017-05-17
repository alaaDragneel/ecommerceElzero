<?php 
	session_start();
	if (isset($_SESSION['userName'])) {

		$pageTitle = 'Dashboard';
		
		include 'init.php';
		//the number of the limit and users
		$latestUser = 5;
		// the dynamic latest function
		$latest = getLatest("*", "users", "userId", $latestUser);

		//the number of the limit and items
		$latestItem = 5;
		// the dynamic latest function
		$latestItems = getLatest("*", "items", "item_ID", $latestItem);

		//the number of the limit and items
		$latestcomments = 5;
		
		/* start dashbard page */


		?>

		<div class='container home-stats text-center'>
			<h1>Dashboard</h1>
			<div class='row'>
				<div class='col-md-3'>
					<div class='stat st-members'>
						<i class="fa fa-users"></i> total members
						<span><a href='members.php'><?php echo countItem('userId', 'users') ?></a></span>
					</div>
				</div>
				<div class='col-md-3'>
					<div class='stat st-pending'>
						<i class="fa fa-user-plus"></i> pending members
						<span><a href='members.php?do=manage&page=pending'><?php echo checkItme('regStatuse', 'users', 0) ?></a></span>
					</div>
				</div>
				<div class='col-md-3'>
					<div class='stat st-items'>
						<i class="fa fa-tag"></i> total item
						<span><a href='items.php'><?php echo countItem('item_ID', 'items') ?></a></span>
					</div>
				</div>
				<div class='col-md-3'>
					<div class='stat st-comment'>
						<i class="fa fa-comments"></i> total comments
						<span><a href='comments.php'><?php echo countItem('c_ID', 'comments') ?></a></span>
					</div>
				</div>
			</div>
		</div>
		<div class='container latest'>
			<div class='row'>
				<div class='col-sm-6'>
					<div class='panel panel-default'>
							<div class='panel-heading'>
								<i class='fa fa-users'></i> lastest
								<?php echo $latestUser?> registerd users
								<span class="toggle-info pull-right">
									<i class="fa fa-plus"></i>
								</span>
							</div>
							<div class='panel-body'>
								<ul class="list-unstyled latest-users">
									<?php
										foreach ($latest as $user) {
											echo '<li>' . $user["userName"] . 
													' <a href="members.php?do=edit&id='.$user["userId"].'">
														<span class="btn btn-info pull-right">
														<i class="fa fa-edit"></i>Edit';
													echo"<a href='members.php?do=delete&id=".$user["userId"]."' class='btn btn-danger pull-right confirm'><i class='fa fa-close'></i> delete</a>";	
														if ($user['regStatuse'] == 0) {
														  	echo "<a href='members.php?do=activate&id=".$user['userId']."' class='btn btn-primary pull-right activate'>
														  	<i class='fa fa-check'></i> activate</a>";
														}

												echo'	</span>
													  </a>
												  </li> 
												';
										}
									?>
								</ul>
							</div>
					</div>
				</div>
				<div class='col-sm-6'>
					<div class='panel panel-default'>
							<div class='panel-heading'>
								<i class='fa fa-tag'></i>
								lastest <?php echo $latestItem; ?>  items
								<span class="toggle-info pull-right">
									<i class="fa fa-plus"></i>
								</span>
							</div>
							<div class='panel-body'>
								<ul class="list-unstyled latest-users">
									<?php
									if(!empty ($latestItems)){
										foreach ($latestItems as $item) {
											echo '<li>' . $item["itemName"] . 
													' <a href="items.php?do=edit&id='.$item["item_ID"].'">
														<span class="btn btn-info pull-right">
														<i class="fa fa-edit"></i>Edit';
											echo"<a href='items.php?do=delete&id=".$item['item_ID']."' class='btn btn-danger pull-right confirm'><i class='fa fa-close'></i> delete</a>";
											if ($item['itemApprove'] == 0) {
														  	echo "<a href='items.php?do=approve&id=".$item['item_ID']."' class='btn btn-primary pull-right activate'>
														  	<i class='fa fa-check'></i> Approve</a>";
														}
												echo'	</span>
													  </a>
												  </li> 
												';
										}
									}else{
										echo "<div class='alert alert-warning'> there is no item to show</div>";
									}
									?>
								</ul>
							</div>
					</div>
				</div>
			</div>
			<!--start latest commetnts-->
			<div class='row'>
				<div class='col-sm-6'>
					<div class='panel panel-default'>
							<div class='panel-heading'>
								<i class='fa fa-comments-o'></i> lastest <?php echo $latestcomments; ?>
								 comments
								<span class="toggle-info pull-right">
									<i class="fa fa-plus"></i>
								</span>
							</div>
							<div class='panel-body'>
								<ul class="list-unstyled latest-users">
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
																ORDER BY C_ID DESC	
																LIMIT $latestcomments	

															  ");
										//execute the statement
										$stmt->execute();

										//assign to variable

										$rows = $stmt->fetchAll();
										
										if(!empty($rows)){
											foreach($rows as $com){
												echo '<div class="comment-box"> ';
													echo "<a href='members.php?do=edit&id=".$com['userId']."' ><span class='member-n' >" . $com["User_Name"] . "</span></a>";
													echo "<p class='member-c' >" . $com["commentName"] . "</p>";

													echo "<div class='controls text-center'> ";
														echo ' <a href="comments.php?do=edit&c_id='.$com["c_ID"].'">
																<span class="btn btn-info ">
																<i class="fa fa-edit"></i>Edit';
													echo"<a href='comments.php?do=delete&c_id=".$com['c_ID']."' class='btn btn-danger confirm activate'><i class='fa fa-close'></i> delete</a>";
													if ($com['commentStatuse'] == 0) {
																  	echo "<a href='comments.php?do=approve&c_id=".$com['c_ID']."' class='btn btn-primary activate'>
																  	<i class='fa fa-check'></i> Approve</a>";
																}
														echo'	</span>
															  </a>
														  </li> 
														';
													echo'</div>';

												echo '</div>';

											}
										}else{
											echo "<div class='alert alert-warning'> there is no comments to show</div>";
										}
									?>
								</ul>
							</div>
					</div>
				</div>
			</div>
			<!-- end latest comments-->
		</div>
		<?php

		/* end dashbard page */

		include $tpl . "footer.php";

	}else {
		header('location: index.php');
		 
		exit();
	}