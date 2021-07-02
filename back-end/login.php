
<?php
session_start();
$pageTitle = 'Login';
if(isset($_SESSION['user'])){
    header('Location: index.php');
}
include 'init.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['login'])){

    
    //check if user coming from http post request

    $user = $_POST['username'];
    $pass = $_POST['password'];

    $hashedPass = sha1($pass);

    
    // check if the user exist in DB

    $stmt = $con->prepare("SELECT UserID , Username, Password
     FROM users 
     WHERE 
         Username = ?
      AND 
         Password = ? ");

    $stmt->execute(array($user , $hashedPass));
    $get = $stmt->fetch();
    $count = $stmt->rowCount();

    if($count > 0){
        $_SESSION['Username'] = $user; // Register session name
        $_SESSION['uid'] =$get['UserID']; // Register User Id
        header('Location: index.php');//Redirect to Dashboard page
        exit();
    }
} else{

    $formErrors =$array() ;
    $username=$_POST['username'] ;
    $password=$_POST['password'];
    $password2=$_POST['password2'];
    $email=$_POST['email'];

    if (isset($_POST['username'])) {
        $filterdUser = filter_var($username , FILTER_SANITIZE_STRING);
        if (strlen($filterdUser) < 4){
            $formErrors [] = 'Username must ba larger than 4 characters ' ;
        }
    }

    if (isset($password)  && isset($password2)){

        if(empty ($pass1)) {
            $formErrors[] = 'Sorry Password Cant Be Empty ';

               } 


        $pass1 = sha1($password) ;
        $pass2 = sha1($password2) ;


        

        if(pass1 !== pass2 ){
            $formErrors[] = 'Sorry Password Is Not Match ';


        }

            }


   if (isset($email)) {
      $filterdEmail = filter_var($email , FILTER_SANITIZE_EMAIL);
      if (filter_var($filterdEmail  , FILTER_VALIDATE_EMAIL) !=true){
          $formErrors[] = 'This Email Is Not Valid' ;


      }
 
    }
    		 			// check if No error proceed the User Add  
 
            if(empty($formErrors)){

                $check =  checkItem ("Username" , "users" , $username);

                if ($check == 1){

                    $formErrors[] = 'Sorry This User Is Exists' ;
              
   

   }else{

       $stmt = $con->prepare("INSERT INTO 
                                  users(Username, Password, Email,RegStatus, RegDate)
                                  VALUES(:user, :pass, :mail, 0, now())");
       $stmt->execute(array(
           'user'=>$username,
           'pass'=>$sha1($password),
           'mail'=>$email
           
       )); 

            $successMsg='Congrats You Are Now Register User'  ;       

       }
}		

               
 }
      
}

?>
    <div class="container login-page">
    <h1 class="text-center">
        <span class="selected" data-class="login">Login</span> |
        <span data-class="signUp">Signup</span>
    </h1>
    <!--Start Login Form-->
	     <form class="login " action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
             <div class="input-container">
            <input 
            class="form-control" 
            type="text" 
            name="username" 
            autocomplete="off" 
            placeholder="Type Your username "
            required />
           </div>
           <div class="input-container">
            <input 
            class="form-control"
             type="password"
              name="password"
               autocomplete="new-password" 
            placeholder="Type Your password "
            required />
            </div>

            <input
             class="btn btn-primary btn-block"
             name="login"
             type="submit" 
             value="Login" />
         </form>  
     <!--End Login Form-->
    <!--Start Signup Form-->

      <form class="signUp" method="POST">
         <div class="input-container">
            <input 
            pattern= ".{4,}"
            title="Username Must Between 4 Chars"
            class="form-control" 
            type="text"
            name="username"
            autocomplete="off" 
            placeholder="Type Your username "
            required />
            </div>

            <div class="input-container">

            <input
             minlength="4"
             class="form-control"
             type="password" 
             name="password"
             autocomplete="new-password" 
             placeholder="Type a password" 
             required />
             </div>

        <div class="input-container">
            <input
             minlength="4"
             class="form-control"
             type="password" 
             name="password2"
             autocomplete="new-password" 
             placeholder="Type a password again" 
             required />
             </div>

             <div class="input-container">
            <input
             class="form-control" 
            type="email"
             name="email" 
             placeholder="Type a Valid  email " 
             />
             </div>
            <input 
             class="btn btn-success btn-block"
             name="signup"
             type="submit"
              value="Signup" />
        </form> 
        <div class ="the-errors text-center">
        <?php 
        if (!empty ($formErrors)){
            foreach ($formErrors as $error) {
                echo $error . '<br>' ;
                
            }
        }

        if(isset($successMsg)){
            echo'<div class="msg success" >' .$successMsg .'</div>';
        }
        ?>
        </div>	 
    </div>	 

    <?php 
    include $tpl . 'footer.php';
    ob_end_flush() ;
    ?>



<?php
session_start();
$pageTitle = 'Login';
if(isset($_SESSION['user'])){
    header('Location: index.php');
}
include 'init.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['login'])){

    
    //check if user coming from http post request

    $user = $_POST['username'];
    $pass = $_POST['password'];
    $hashedPass = sha1($password);
    
    // check if the user exist in DB

    $stmt = $con->prepare("SELECT  Username, Password
     FROM users 
     WHERE 
         Username = ?
      AND 
         Password = ? ");

    $stmt->execute(array($user , $hashedPass));
    $count = $stmt->rowCount();

    if($count > 0){
        $_SESSION['Username'] = $user; // Register session name
        header('Location: index.php');//Redirect to Dashboard page
        exit();
    }
} else{

    $formErrors =$array() ;
    if (isset($_POST['username'])) {
        $filterdUser = filter_var($_POST['username'] , FILTER_SANITIZE_STRING);
        if (strlen($filterdUser) < 4){
            $formErrors [] = 'Username must ba larger than 4 characters ' ;
        }
    }

    if (isset($_POST['password'])  && isset($_POST['password2'])){

        if(empty ($pass1)) {
            $formErrors[] = 'Sorry Password Cant Be Empty ';

               } 


        $pass1 = sha1($_POST['password']) ;
        $pass2 = sha1($_POST['password2']) ;


        

        if(pass1 !== pass2 ){
            $formErrors[] = 'Sorry Password Is Not Match ';


        }

            }


   if (isset($_POST['email'])) {
      $filterdEmail = filter_var($_POST['email'] , FILTER_SANITIZE_EMAIL);
      if (filter_var($filterdEmail  , FILTER_VALIDATE_EMAIL) !=true){
          $formErrors[] = 'This Email Is Not Valid' ;


      }
    
 }           
               
 }
      
}

?>
    <div class="container login-page">
    <h1 class="text-center">
        <span class="selected" data-class="login">Login</span> |
        <span data-class="signup">Signup</span>
    </h1>
    <!--Start Login Form-->
	     <form class="login " action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
             <div class="input-container">
            <input 
            class="form-control" 
            type="text" 
            name="username" 
            autocomplete="off" 
            placeholder="Type Your username "
            required />
           </div>
           <div class="input-container">
            <input 
            class="form-control"
             type="password"
              name="password"
               autocomplete="new-password" 
            placeholder="Type Your password "
            required />
            </div>

            <input
             class="btn btn-primary btn-block"
             name="login"
             type="submit" 
             value="Login" />
         </form>  
     <!--End Login Form-->
    <!--Start Signup Form-->

      <form class="signup"><?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
         <div class="input-container">
            <input 
            pattern= ".{4,}"
            title="Username Must Between 4 Chars"
            class="form-control" 
            type="text"
            name="username"
            autocomplete="off" 
            placeholder="Type Your username "
            required />
            </div>

            <div class="input-container">

            <input
             minlength="4"
             class="form-control"
             type="password" 
             name="password"
             autocomplete="new-password" 
             placeholder="Type a password" 
             required />
             </div>

        <div class="input-container">
            <input
             minlength="4"
             class="form-control"
             type="password" 
             name="password2"
             autocomplete="new-password" 
             placeholder="Type a password again" 
             required />
             </div>

             <div class="input-container">
            <input
             class="form-control" 
            type="email"
             name="email" 
             placeholder="Type a Valid  email " 
             />
             </div>
            <input 
             class="btn btn-success btn-block"
             name="signup"
             type="submit"
              value="Signup" />
        </form> 
        <div class ="the-errors text-center">
        <?php 
        if (!empty ($formErrors)){
            foreach ($formErrors as $error) {
                echo $error . '<br>' ;
                
            }
        }
        ?>
        </div>	 
    </div>	 

    <?php 
    include $tpl . 'footer.php';
    ob_end_flush() ;
    ?>



