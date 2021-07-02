<?php 
	session_start();

	$pageTitle = 'Members';

	if(isset($_SESSION['Username'])){

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if($do == 'Manage' ) { //Manage Members Page 


			$query = '';
			if (isset($_GET['page']) && $_GET['page'] == 'Pending') {
				$query = 'AND RegStatus = 0';
			}


			$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query");
			$stmt->execute();
			$rows = $stmt->fetchAll();

			?>


			<h1 class="text-center">Manage Members</h1>
    		<div class="container">
    			<div class="table-responsive">
    				<table class="main-table text-center table table-bordered">
    					<tr>
    						<td>#ID</td>
    						<td>Username</td>
    						<td>Email</td>
    						<td>Full Name</td>
    						<td>Registered Date</td>
    						<td>Control</td>
    					</tr>

    					<?php

    					foreach ($rows as $row) {
    						echo "<tr>";
    							echo "<td>" . $row['UserID'] . "</td>";
    							echo "<td>" . $row['Username'] . "</td>";
    							echo "<td>" . $row['Email'] . "</td>";
    							echo "<td>" . $row['Fullname'] . "</td>";
    							echo "<td>" . $row['RegDate'] . "</td>"; 
    							echo "<td>
    									<a href='members.php?do=Edit&userid=" . $row['UserID'] ."' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
    									<a href='members.php?do=Delete&userid=" . $row['UserID'] ."' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";

    									if ($row['RegStatus'] == 0) {
    										echo "<a href='members.php?do=Activate&userid=" . $row['UserID'] ."' class='btn btn-info activate'><i class='fa fa-check'></i> Activate </a>";
    									}

    								echo "</td>";
    						echo "</tr>";
    					}

    					?>

    				</table>
    			</div>
    			<a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>
    		</div>	

    		

<?php	}elseif($do == 'Add'){ // Add Members Page ?>

			<h1 class="text-center">Add New Member</h1>
    		<div class="container">
    			<form class="form-horizontal" action="?do=Insert" method="POST">

    				<!---username field--->
    				<div class="form-group form-group-lg">
    					<label class="col-sm-2 control-label">Username</label>
    					<div class="col-sm-10 col-md-6">
    						<input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Username To Login Into Shop"/>
    					</div>
    				</div>

    				<!---passeord field--->
    				<div class="form-group form-group-lg">
    					<label class="col-sm-2 control-label">Password</label>
    					<div class="col-sm-10 col-md-6">
    						<input type="Password" name="password" class="password form-control" autocomplete="new-password" required="required" placeholder="Password Must Be Hard & Complex" />
    						<i class="show-pass fa fa-eye fa-2x" ></i>
    					</div>
    				</div>

    				<!---email field--->
    				<div class="form-group form-group-lg">
    					<label class="col-sm-2 control-label">Email</label>
    					<div class="col-sm-10 col-md-6">
    						<input type="email" name="email" class="form-control" required="required" placeholder="Email Must Be Valid" />
    					</div>
    				</div>

    				<!---full name field--->
    				<div class="form-group form-group-lg">
    					<label class="col-sm-2 control-label">Full Name</label>
    					<div class="col-sm-10 col-md-6">
    						<input type="text" name="fullname" class="form-control" required="required" placeholder="Full Name Appear In Your Profile Page"/>
    					</div>
    				</div>

    				<!---save button--->
    				<div class="form-group form-group-lg">
    					<div class="col-sm-offset-2 col-sm-10">
    						<input type="submit" value="Add Member" class="btn btn-primary btn-lg"/>
    					</div>
    				</div>
    			</form>
    		</div>


 <?php

 			}elseif ($do == 'Insert') { // Insert Member Page
 				

		 		if($_SERVER['REQUEST_METHOD'] == 'POST'){

		 			echo " <h1 class='text-center'>Insert Member</h1> ";
		 			echo "<div class='container'>";

		 			// get Variables from the Form 

		 			$user = $_POST['username'];
		 			$pass = $_POST['password'];
		 			$email = $_POST['email'];
		 			$name = $_POST['fullname'];

		 			$hashedPass = sha1($_POST['password']);


		 			// Validate Fields

		 			$formErrors = array();


		 			if(strlen($user) < 4){
		 				$formErrors[] = 'Username cant be less than <strong>4 Characters</strong>' ;
		 			}
		 			if(strlen($user) > 20){
		 				$formErrors[] = 'Username cant be more than <strong>20 Characters</strong>' ;
		 			}
		 			if(empty($name)){
		 				$formErrors[] = 'Full Name cant be <strong>Empty</strong>';
		 			}
		 			if(empty($pass)){
		 				$formErrors[] = 'Password cant be <strong>Empty</strong>';
		 			}
		 			if(empty($email)){
		 				$formErrors[] ='Email cant be <strong>Empty</strong>';
		 			}
		 			foreach ($formErrors as $error) {
		 				echo '<div class="alert alert-danger">' . $error . '</div>';
		 			}


		 			// Insert User Info To Database 

		 			if(empty($formErrors)){

		 				$check =  checkItem ("Username" , "users" , $user);

		 				if ($check == 1){

		 					$theMsg = "<div class='alert alert-success'>sorry this user is exist</div>";
				            echo "<div class='container'>";
							redirectHome($theMsg ,'back');
							echo "</div>";
				        

				        }else{

				        	$stmt = $con->prepare("INSERT INTO 
                               						users(Username, Password, Email, Fullname,RegStatus, RegDate)
                               						VALUES(:user, :pass, :mail, :name,1, now())");
	                    	$stmt->execute(array(
		                        'user'=>$user,
		                        'pass'=>$hashedPass ,
		                        'mail'=>$email,
		                        'name'=>$name
		                    )); 

		                    echo "<div class='container'>";
							$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
							redirectHome($theMsg , 'back',3);
					        echo "</div>";	
				        		
							}
					}		

		 		}else{

		 			echo "<div class='container'>";

		 			$theMsg = '<div class="alert alert-success">Sorry You Cant Browse This Page Directly</div>';
		 			redirectHome($theMsg);

		 			echo "</div>";

		 			//$errorMsg = 'Sorry You Cant Browse This Page Directly ' ;
		 			//redirectHome($errorMsg , 6);
		 		}

		 		echo "</div>";
 			
			}elseif($do == 'Edit') { // Edit Page    

				$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;

				$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

				$stmt->execute(array($userid));
				$row = $stmt->fetch();
				$count = $stmt->rowCount();

				if($count > 0){  ?>

		    		<h1 class="text-center">Edit Member</h1>
		    		<div class="container">
		    			<form class="form-horizontal" action="?do=Update" method="POST">

		    				<input type="hidden" name="userid" value="<?php echo $userid ?>"/>

		    				<!---username field--->
		    				<div class="form-group form-group-lg">
		    					<label class="col-sm-2 control-label">Username</label>
		    					<div class="col-sm-10 col-md-6">
		    						<input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>" autocomplete="off" required="required"/>
		    					</div>
		    				</div>

		    				<!---passeord field--->
		    				<div class="form-group form-group-lg">
		    					<label class="col-sm-2 control-label">Password</label>
		    					<div class="col-sm-10 col-md-6">
		    						<input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>" />
		    						<input type="Password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Dont Want To Change" />
		    					</div>
		    				</div>

		    				<!---email field--->
		    				<div class="form-group form-group-lg">
		    					<label class="col-sm-2 control-label">Email</label>
		    					<div class="col-sm-10 col-md-6">
		    						<input type="email" name="email" class="form-control" value="<?php echo $row['Email'] ?>" required="required" />
		    					</div>
		    				</div>

		    				<!---full name field--->
		    				<div class="form-group form-group-lg">
		    					<label class="col-sm-2 control-label">Full Name</label>
		    					<div class="col-sm-10 col-md-6">
		    						<input type="text" name="fullname" class="form-control" value="<?php echo $row['Fullname'] ?>" required="required" />
		    					</div>
		    				</div>

		    				<!---save button--->
		    				<div class="form-group form-group-lg">
		    					<div class="col-sm-offset-2 col-sm-10">
		    						<input type="submit" value="Save" class="btn btn-primary btn-lg"/>
		    					</div>
		    				</div>
		    			</form>
		    		</div>


			<?php

				}else{

					echo "no id ";
				}
	 	}elseif($do == 'Update'){ //Update Page

	 		echo " <h1 class='text-center'>Update Member</h1> ";
	 		echo "<div class='container'>";

	 		if($_SERVER['REQUEST_METHOD'] == 'POST'){

	 			// get Variables from the Form 

	 			$id = $_POST['userid'];
	 			$user = $_POST['username'];
	 			$email = $_POST['email'];
	 			$name = $_POST['fullname'];

	 			// Password Trick

	 			$pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']) ;

	 			// Validate Fields

	 			$formErrors = array();


	 			if(strlen($user) < 4){
		 				$formErrors[] = 'Username cant be less than <strong>4 Characters</strong>' ;
		 			}
		 			if(strlen($user) > 20){
		 				$formErrors[] = 'Username cant be more than <strong>20 Characters</strong>' ;
		 			}
		 			if(empty($name)){
		 				$formErrors[] = 'Full Name cant be <strong>Empty</strong>';
		 			}
		 			if(empty($email)){
		 				$formErrors[] ='Email cant be <strong>Empty</strong>';
		 			}
		 			foreach ($formErrors as $error) {
		 				echo '<div class="alert alert-danger">' . $error . '</div>';
		 			}



	 			// Update Database with this info

	 			if(empty($formErrors)){

	 				$stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, Fullname = ?, Password = ? WHERE UserID = ? ");

					$stmt->execute(array( $user, $email, $name, $pass, $id));

					$theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

					echo "<div class='container'>";
					redirectHome($theMsg , 'back',3);
			        echo "</div>";
					

	 			}
	 			

	 		}else{

	 			echo "<div class='container'>";
	 			$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
	 			redirectHome($theMsg);
	 			echo "</div>";

	 			//echo "cant browsedirectly";
	 		}

	 		echo "</div>";


	 	}elseif ($do == 'Delete') { // Delete Page

	 		echo " <h1 class='text-center'>Delete Member</h1> ";
	 		echo "<div class='container'>";

		 		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;

				//$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

				$check = checkItem('userid' , 'users' , $userid);
				//echo $check;

				//$stmt->execute(array($userid));
				//$count = $stmt->rowCount();

				if($check > 0){ 

					$stmt = $con->prepare("DELETE FROM users WHERE UserID = :userid");
					$stmt->bindParam(":userid", $userid);
					$stmt->execute();

					echo "<div class='container'>";
					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
					redirectHome($theMsg);
		 			echo "</div>";

				}else{
					echo "<div class='container'>";
	 				$theMsg = '<div class="alert alert-danger">There Is No Such ID</div>';
		 			redirectHome($theMsg);
		 			echo "</div>";
					}

			echo '</div>';


			
	 	}elseif($do == 'Activate'){

	 		echo " <h1 class='text-center'>Activate Member</h1> ";
	 		echo "<div class='container'>";

		 		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0 ;


				$check = checkItem('userid' , 'users' , $userid);

				if($check > 0){ 

					$stmt = $con->prepare("UPDATE users SET RegStatus = 1  WHERE UserID = ?");

					$stmt->execute(array($userid));

					echo "<div class='container'>";
					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Activated</div>';
					redirectHome($theMsg);
		 			echo "</div>";

				}else{
					echo "<div class='container'>";
	 				$theMsg = '<div class="alert alert-danger">There Is No Such ID</div>';
		 			redirectHome($theMsg);
		 			echo "</div>";
					}

			echo '</div>';

	 	}

		include $tpl . 'footer.php';

	}else{

		header('Location: index.php');

		exit();
	}