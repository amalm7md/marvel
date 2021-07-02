<!DOCTYPE html>
<!DOCTYPE html>

<html>
<head>
	<meta charset="utf-8">
	<title><?php getTitle() ?></title>
	<link rel="stylesheet" href="<?php echo $css ?>bootstrap.min.css" />
	<link rel="stylesheet" href="<?php echo $css ?>font-awesome.min.css" />
	<link rel="stylesheet" href="<?php echo $css ?>jquery-ui.css" />
	<link rel="stylesheet" href="<?php echo $css ?>jquery.selectBoxIt.css" />
	<link rel="stylesheet" href="<?php echo $css ?>front.css" />

</head>
<body>
<div class="upper-bar">
    <div class="container">
		<?php 
		if(isset($_SESSION['user'])){ ?>
		'<img class= "my-image img-thumbnail img-circle" src="img.png" alt="" />'

		<div class="btn-group my-info ">
			<span class = "btn btn-default dropdown-toggle" data-toggle="dropdown" >
				<?php echo $sessionUser ?>
				<span class = "caret"></span>
		</span>
				<ul class ="dropdown-menu">
					<li><a href = "profile.php">My Profile</a></li>
					<li><a href = "newAd.php">New Item</a></li>
					<li><a href = "profile.php#my-ads">My Items</a></li>
					<li><a href = "logout.php">Logout</a></li>

		</ul>
		</div>
		<?php 
			
	

		if(isset($_SESSION['user'])){
			echo 'Welcome' . $sessionUser . ' ' ;
			echo '<a href ="profile.php">My Profile</a>';
			echo '< a href="newAd.php">New Ad</a>';
			echo '<a href ="logout.php">Logout</a>';

			

			$userStatus =checkUserStatus($sessionUser);
			  if($userStatus == 1){
				  //user is not active
				 // echo 'Your Membership Need To Activiate By Admin';
			  }
				} else {

?>
			
	 <a href="login.php">
	 <span class="pull-right">Login/Signup</span>
	 </a>

	 <?php } ?>	 
</div>
</div>	

	<nav class="navbar "><!---navbar-inverse-->
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed"  data-toggle="collapse" data-target="#app-nav"  aria-expanded="false">
				<span class="sr-only">Toggle Navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php"> Home </a>
		</div>
		<div class="collapse navbar-collapse" id="app-nav">
			<ul class="nav navbar-nav-right">
						<?php
			foreach( getcat() as $cat){
					echo '<li><a href ="categories.php?pageid='. $cat['ID'] .' ">
					'. $cat['Name'] . ' 
					</a>
					</li>';
			}
			?>
				
				
			</ul>
		</div>
	</div>
	</nav> 

</body>