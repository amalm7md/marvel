<?php 

ob_start();
session_start();
$pageTitle = 'Categories';

if(isset($_SESSION['Username'])){

    include 'init.php';

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


    if($do == 'Manage'){ //Categories Home Page


    	$sort = "ASC";

    	$sort_array = array('ASC','DESC');

        if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){
            $sort =$_GET['sort'];
        }


    	$stmt2 = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
	    $stmt2->execute();
	    $cats = $stmt2->fetchAll();  ?>

	    <h1 class="text-center">Manage Categories</h1>
	    <div class="container categories">
	    	<div class="panel panel-defult">
	    		<div class="panel-heading">

	    			<i class="fa fa-edit"></i>Manage Categories
	    			<div class="option pull-right">
	    				<i class="fa fa-sort"></i>Ordering: []
	    				<a class="<?php if($sort =='ASC'){ echo 'active'; } ?>" href="?sort=ASC">ASC</a> | 
	    				<a class="<?php if($sort =='DESC'){ echo 'active'; } ?>" href="?sort=DESC">DESC</a> ]
	    				<i class="fa fa-eye"></i>View: [
	    				<span class="active" data-view="full">Full</span> | 
	    				<span data-view="classic">Classic</span> ]
	    				
	    			</div>

	    		</div>
	    		<div class="panel-body"></div>
	    	
	    			<?php

	    			foreach ($cats as $cat) {
	    				echo "<div class='cat'>";
	    					echo "<div class='hidden-buttons'>";
	    						echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
                             	echo "<a href='categories.php?do=Delete&catid=" . $cat['ID'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete</a>";
	    					echo "</div>";
		    				echo '<h3>' . $cat['Name'] . '</h3>';

		    				echo "<div class='full-view'>";
		    					echo "<p>";
		    					if( $cat['Description']  == '') {
                              		echo 'This category has no description';
	                          	}else{ 
	                          		echo $cat['Description'] ;  
	                          	} 
	                          	echo "</p>";
		                        if($cat['Visibility'] == 1) { 
		                        	echo '<span class="visibility"><i class="fa fa-eye"></i> Hidden</span>';
		                    	}
		                        if($cat['Allow_Comments'] == 1) { 
		                        	echo '<span class="commenting"><i class="fa fa-close"></i> Comments Disabled</span>';
		                    	}
		                        if($cat['Allow_Ads'] == 1) { 
		                        	echo '<span class="advertises"><i class="fa fa-close"></i> Ads Disabled</span>';
		                    	}	
		             		echo "</div>";

	    				echo "</div>";
	    				echo "<hr>";
	    			}
	    		?>
	    	</div>
	    	<a class="add-category btn btn-primary" href="categories.php?do=Add"><i class="fa fa-plus"></i> New Category</a>
	    </div>


	 <?php   
    }elseif($do == 'Add'){ ?>

    	<h1 class="text-center">Add New Category</h1>
    		<div class="container">
    			<form class="form-horizontal" action="?do=Insert" method="POST">

    				<input type="hidden" name="catid" value="<?php echo $catid ?>"/>

    				<!---Name field--->
    				<div class="form-group form-group-lg">
    					<label class="col-sm-2 control-label">Name</label>
    					<div class="col-sm-10 col-md-6">
    						<input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Name Of The Category"/>
    					</div>
    				</div>

    				<!---Description field--->
    				<div class="form-group form-group-lg">
    					<label class="col-sm-2 control-label">Description</label>
    					<div class="col-sm-10 col-md-6">
    						<input type="text" name="description" class="password form-control" placeholder="Describe The Category" />
    					</div>
    				</div>

    				<!---Ordering field--->
    				<div class="form-group form-group-lg">
    					<label class="col-sm-2 control-label">Ordering</label>
    					<div class="col-sm-10 col-md-6">
    						<input type="text" name="ordering" class="form-control" placeholder="Number To Arrange The Categories" />
    					</div>
    				</div>

    				<!---Visibility field--->
    				<div class="form-group form-group-lg">
    					<label class="col-sm-2 control-label">Visibile</label>
    					<div class="col-sm-10 col-md-6">
    						<div>
    							<input id="vis-yes" type="radio" name="visibility" value="0" checked />
    							<label for="vis-yes">Yes</label>
    						</div>
    						<div>
    							<input id="vis-no" type="radio" name="visibility" value="1"/>
    							<label for="vis-no">No</label>
    						</div>
    					</div>
    				</div>

    				<!---Commenting field--->
    				<div class="form-group form-group-lg">
    					<label class="col-sm-2 control-label">Allow Commenting</label>
    					<div class="col-sm-10 col-md-6">
    						<div>
    							<input id="com-yes" type="radio" name="commenting" value="0" checked />
    							<label for="com-yes">Yes</label>
    						</div>
    						<div>
    							<input id="com-no" type="radio" name="commenting" value="1"/>
    							<label for="com-no">No</label>
    						</div>
    					</div>
    				</div>

    				<!---Ads field--->
    				<div class="form-group form-group-lg">
    					<label class="col-sm-2 control-label">Allow Ads</label>
    					<div class="col-sm-10 col-md-6">
    						<div>
    							<input id="ads-yes" type="radio" name="ads" value="0" checked />
    							<label for="ads-yes">Yes</label>
    						</div>
    						<div>
    							<input id="ads-no" type="radio" name="ads" value="1"/>
    							<label for="ads-no">No</label>
    						</div>
    					</div>
    				</div>

    				
    				<!---save button--->
    				<div class="form-group form-group-lg">
    					<div class="col-sm-offset-2 col-sm-10">
    						<input type="submit" value="Add Category" class="btn btn-primary btn-lg"/>
    					</div>
    				</div>
    			</form>
    		</div>

    <?php	

    }elseif($do == 'Insert'){

    	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		 			echo " <h1 class='text-center'>Update Member</h1> ";
		 			echo "<div class='container'>";

		 			// get Variables from the Form 

		 			$name 		= $_POST['name'];
		 			$desc 		= $_POST['description'];
		 			$order 		= $_POST['ordering'];  
		 			$visible 	= $_POST['visibility'];
		 			$comment 	= $_POST['commenting'];
		 			$ads 	= $_POST['ads'];


		 			//check if category exists in BD

	 				$check =  checkItem ("Name" , "categories" , $name);

	 				if ($check == 1){

	 					$theMsg = "<div class='alert alert-success'>sorry this Category is exist</div>";
			            echo "<div class='container'>";
						redirectHome($theMsg ,'back');
						echo "</div>";
			        

			        }else{

			        	$stmt = $con->prepare("INSERT INTO 
           						categories(Name, Description, Ordering ,Visibility  ,Allow_Comments, Allow_Ads)
           						VALUES(:name, :descript, :order, :visible, :comment, :ads)");
                    	$stmt->execute(array(
	                        'name'=>$name,
	                        'descript'=>$desc ,
	                        'order'=>$order,
	                        'visible'=>$visible,
	                        'comment'=>$comment,
	                        'ads'=>$ads
	                    )); 

	                    echo "<div class='container'>";
						$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
						redirectHome($theMsg , 'back',3);
				        echo "</div>";	
			        		
						}	

		 		}else{

		 			echo "<div class='container'>";
		 			$theMsg = '<div class="alert alert-success">Sorry You Cant Browse This Page Directly</div>';
		 			redirectHome($theMsg , 'back',3);
		 			echo "</div>";
		 		}

		 		echo "</div>";





    }elseif($do == 'Edit'){

    	$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;

				$stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");

				$stmt->execute(array($catid));
				$cat = $stmt->fetch();
				$count = $stmt->rowCount();

				if($count > 0){  ?>

		    		<h1 class="text-center">Add New Category</h1>
		    		<div class="container">
		    			<form class="form-horizontal" action="?do=Update" method="POST">

		    				<!---Name field--->
		    				<div class="form-group form-group-lg">
		    					<label class="col-sm-2 control-label">Name</label>
		    					<div class="col-sm-10 col-md-6">
		    						<input type="text" name="name" value="<?php echo $cat['Name'] ?>" class="form-control"  required="required" placeholder="Name Of The Category"/>
		    					</div>
		    				</div>

		    				<!---Description field--->
		    				<div class="form-group form-group-lg">
		    					<label class="col-sm-2 control-label">Description</label>
		    					<div class="col-sm-10 col-md-6">
		    						<input type="text" name="description" class="password form-control" placeholder="Describe The Category" value="<?php echo $cat['Description'] ?>"/>
		    					</div>
		    				</div>

		    				<!---Ordering field--->
		    				<div class="form-group form-group-lg">
		    					<label class="col-sm-2 control-label">Ordering</label>
		    					<div class="col-sm-10 col-md-6">
		    						<input type="text" name="ordering" class="form-control" placeholder="Number To Arrange The Categories"  value="<?php echo $cat['Ordering'] ?>"/>
		    					</div>
		    				</div>

		    				<!---Visibility field--->
		    				<div class="form-group form-group-lg">
		    					<label class="col-sm-2 control-label">Visibile</label>
		    					<div class="col-sm-10 col-md-6">
		    						<div>
		    							<input id="vis-yes" type="radio" name="visibility" value="0" <?php if($cat['Visibility'] == 0){echo "checked";} ?> />
		    							<label for="vis-yes">Yes</label>
		    						</div>
		    						<div>
		    							<input id="vis-no" type="radio" name="visibility" value="1" <?php if($cat['Visibility'] == 1){echo "checked";} ?>/>
		    							<label for="vis-no">No</label>
		    						</div>
		    					</div>
		    				</div>

		    				<!---Commenting field--->
		    				<div class="form-group form-group-lg">
		    					<label class="col-sm-2 control-label">Allow Commenting</label>
		    					<div class="col-sm-10 col-md-6">
		    						<div>
		    							<input id="com-yes" type="radio" name="commenting" value="0" <?php if($cat['Allow_Comments'] == 0){echo "checked";} ?>/>
		    							<label for="com-yes">Yes</label>
		    						</div>
		    						<div>
		    							<input id="com-no" type="radio" name="commenting" value="1" <?php if($cat['Allow_Comments'] == 1){echo "checked";} ?> />
		    							<label for="com-no">No</label>
		    						</div>
		    					</div>
		    				</div>

		    				<!---Ads field--->
		    				<div class="form-group form-group-lg">
		    					<label class="col-sm-2 control-label">Allow Ads</label>
		    					<div class="col-sm-10 col-md-6">
		    						<div>
		    							<input id="ads-yes" type="radio" name="ads" value="0" <?php if($cat['Allow_Ads'] == 0){echo "checked";} ?> />
		    							<label for="ads-yes">Yes</label>
		    						</div>
		    						<div>
		    							<input id="ads-no" type="radio" name="ads" value="1" <?php if($cat['Allow_Ads'] == 1){echo "checked";} ?> />
		    							<label for="ads-no">No</label>
		    						</div>
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

					echo "<div class='container'>";
		 			$theMsg = '<div class="alert alert-danger">Theres No Such ID</div>';
		 			redirectHome($theMsg , 'back',3);
		 			echo "</div>";

				}


    } elseif($do == 'Update'){ 


    	echo " <h1 class='text-center'>Update Category</h1> ";
	 		echo "<div class='container'>";

	 		if($_SERVER['REQUEST_METHOD'] == 'POST'){

	 			// get Variables from the Form 

	 			$id 		= $_POST['catid'];
	 			$name 		= $_POST['name'];
	 			$desc 		= $_POST['description'];
	 			$order 		= $_POST['ordering'];
	 			$visible 	= $_POST['visibility'];
	 			$comment 	= $_POST['commenting'];
	 			$ads 		= $_POST['ads'];


	 			// Validate Fields


	 			// Update Database with this info

 				$stmt = $con->prepare("UPDATE 
 											categories 
										SET 
										Name = ?,
										Description = ?,
										Ordering = ?, 
										Visibility = ?,
										Allow_Comments = ?,
										Allow_Ads = ? 
										WHERE 
										ID = ? ");

				$stmt->execute(array( $name, $desc, $order, $visible, $comment , $ads ,$id ));

				$theMsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

				echo "<div class='container'>";
				redirectHome($theMsg , 'back',3);
		        echo "</div>";

	 		}else{

	 			echo "<div class='container'>";
	 			$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
	 			redirectHome($theMsg);
	 			echo "</div>";

	 			//echo "cant browsedirectly";
	 		}

	 		echo "</div>";


    } elseif($do == 'Delete'){ 


    	echo " <h1 class='text-center'>Delete Category</h1> ";
	 		echo "<div class='container'>";

		 		$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;

				//$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

				$check = checkItem('ID' , 'categories' , $catid);


				if($check > 0){ 

					$stmt = $con->prepare("DELETE FROM categories WHERE ID = :id");
					$stmt->bindParam(":id", $catid);
					$stmt->execute();

					echo "<div class='container'>";
					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
					redirectHome($theMsg ,'back');
		 			echo "</div>";

				}else{
					echo "<div class='container'>";
	 				$theMsg = '<div class="alert alert-danger">There Is No Such ID</div>';
		 			redirectHome($theMsg, 'back');
		 			echo "</div>";
					}

			echo '</div>';

    }
    
    include $tpl .'footer.php';
    }else{
        header('Location: index.php');
        exit();
    }
  ob_get_flush();
?>