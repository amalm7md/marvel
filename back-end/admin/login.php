<?php
include 'init.php';

?>
    <div class="container login-page">
    <h1 class="text-center">
        <span class="login">Login</span> | <span class="signup">Signup</span>
    </h1>
	     <form class="login">
            <input 
            class="form-control" 
            type="text" 
            name="username" 
            autocomplete="off" 
            placeholder="Type Your username " />
            <input 
            class="form-control"
             type="password"
              name="password"
               autocomplete="new-password" 
            placeholder="Type Your password " />
            <input
             class="btn btn-primary btn-block"
             type="submit" 
             value="Login" />
         </form>  
      <form class="signup">
            <input 
            class="form-control" 
            type="text"
            name="username"
            autocomplete="off" 
            placeholder="Type Your username " />
            <input
             class="form-control"
             type="password" 
             name="password"
             autocomplete="new-password" 
             placeholder="Type a password" />
            <input
             class="form-control"
             type="password" 
             name="password2"
             autocomplete="new-password" 
             placeholder="Type a password again" />
            <input
             class="form-control" 
            type="email"
             name="email" 
             placeholder="Type a Valid  email " />
            <input 
             class="btn btn-success btn-block"
             type="submit"
              value="Signup" />
        </form> 
    </div>	 

    <?php include $tpl . 'footer.php'; ?>


