<?php 
session_start();
$pageTitle = 'Create New Item';
include 'init.php';
if(isset($_SESSION ['user'])) {
 if ($_SERVER['REQUEST_METHOD']=='POST'){
     $formErrors = array();

     $name =filter_var($_POST['name'], FILTER_SANITIZE_STRING);
     $desc = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
     $price =filter_var( $_POST['price'], FILTER_SANITIZE_NUMBER_INT);
     $country =filter_var( $_POST['country'], FILTER_SANITIZE_STRING);
     $status =filter_var( $_POST['status'], FILTER_SANITIZE_NUMBER_INT);
     $category =filter_var( $_POST['category'], FILTER_SANITIZE_NUMBER_INT);

     if(strlen($name) <4 ){
         $formErrors[] = 'Item Title Must Be At Least 4 Characters';
     }
     if(strlen($desc) <10 ){
        $formErrors[] = 'Item Description Must Be At Least 4 Characters';
    }
    if(strlen($country) <2 ){
        $formErrors[] = 'Item Title Must Be At Least 2 Characters';
    }
    if(empty($price) ){
        $formErrors[] = 'Item price Must Be Not Empty';
    }
    if(empty($status) ){
        $formErrors[] = 'Item status Must Be Not Empty';
    }
    if(empty($category) ){
        $formErrors[] = 'Item category Must Be Not Empty';
    }

    if(empty($formErrors)){

        $stmt = $con->prepare("INSERT INTO 
                items(Name, Description, Price, Country_Made,Status, Add_Date, Cat_ID, Member_ID)
                VALUES(:name, :description, :price, :country, :status, now(), :cat, :member)");

        $stmt->execute(array(
            'name'=>$name,
            'description'=>$desc,
            'price'=>$price,
            'country'=>$country,
            'status'=>$status,
            'cat'=>$category,
            'member'=>$_SESSION['uid']
        )); 

        //Echo Success Message
          if($stm){
            $successMsg = 'Item Has Been Added';

          }
                
    } 
 

 }
?>
          <h1 class="text-center"><?php echo $pageTitle ?></h1>
        <div class ="create-ad block">
        <div class ="container">
        <div class ="panel panel-primary">
        <div class ="panel-heading"><?php echo $pageTitle ?></div>
        <div class ="panel-body">
         <div class ="row">   
            <div class ="col-md-8">  
                <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">

                <!---Name field--->
                <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Name</label>
                    <div class="col-sm-10 col-md-9">
 
                        <input 
                        pattern=".{4,}" 
                        title="This Field Require At Least 4 Characters" 
                        type="text" 
                        name="name" 
                        class="form-control live-name"  
                         placeholder="Name Of The Item"
                         data-class =".live-title"
                         required/>

                        <input type="text" name="name" class="form-control live-name"  required="required" placeholder="Name Of The Item"/>

                    </div>
                </div>

                <!---Description field--->
                <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Description</label>
                    <div class="col-sm-10 col-md-9">
                        <input 
                        pattern=".{10,}" 
                        title="This Field Require At Least 10 Characters" 
                        type="text" 
                        name="desc" 
                        class="form-control live-desc" 
                        placeholder="Description Of The Item"
                        data-class =".live-desc"
                         required/>

                        <input type="text" name="desc" class="form-control live-desc" required="required"
                         placeholder="Description Of The Item"/>
                    </div>
                </div>

                <!---Price field--->
                <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Price</label>
                    <div class="col-sm-10 col-md-9">
 
                        <input 
                        type="text" 
                        name="price" 
                        class="form-control live-price"
                         placeholder="Price Of The Item"
                         data-class =".live-price"
                         required/>

                        <input type="text" name="price" class="form-control live-price" required="required" placeholder="Price Of The Item"/>

                    </div>
                </div>

                <!---Country field--->
                <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Country</label>
                    <div class="col-sm-10 col-md-9">
                        <input 
                        type="text" 
                        name="country" 
                        class="form-control" 
                        placeholder="Country of Made"
                        required/>

                        <input type="text" name="country" class="form-control" required="required" placeholder="Country of Made"/>
 
                    </div>
                </div>

                <!---Status selectbox--->
                <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Status</label>
                    <div class="col-sm-10 col-md-9">
                        <select name="status"  required >

                            <option value="">...</option>
                            <option value="1">New</option>
                            <option value="2">Like New</option>
                            <option value="3">Used</option>
                            <option value="4">Very Old</option>
                        </select>
                    </div>
                </div>


                <!---Category selectbox--->
                <div class="form-group form-group-lg">
                    <label class="col-sm-3 control-label">Category</label>
                    <div class="col-sm-10 col-md-9">
                        <select name="category" required >
                            <option value="">...</option>
                            <?php
                            $cats = getAllFrom('categories' , 'ID');

                        <select name="category">
                            <option value="">...</option>
                            <?php
                                $stmt2 = $con->prepare("SELECT * FROM categories");
                                $stmt2->execute();
                                $cats = $stmt2->fetchAll();

                                foreach ($cats as $cat) {
                                    echo "<option value= '" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>


                <!---save button--->
                <div class="form-group form-group-lg">
                    <div class="col-sm-offset-3 col-sm-9">
                        <input type="submit" value="Add Item" class="btn btn-primary btn-lg"/>
                    </div>
                </div>
                </form>
                </div>
                <div class ="col-md-4">  
                   <div class ="thumbnail item-box live-preview">
                        <span class="price-tag">$0</span>
                        <img class="img-responsive" src="img.png" alt="" />
                        <div class="caption">
                            <h3>Title</h3>
                            <p>Description</p>
                            </div>
                        </div>
                     </div>
                 </div>
                 <!-- Start Looping Through Errors-->
                 <?php 
                 if(! empty($formErrors)){
                     foreach ($formErrors as $error){
                         echo'<div class="alert alert-danger">' .$error .'</div>';
                     }
                 }
                 if(isset($successMsg)){
                    echo'<div class="alert alert-success" >' .$successMsg .'</div>';
                }

                 ?>
                 <!-- End Looping Through Errors-->
             </div>
         </div>
    </div>
</div>

<?php
} else{
        header('Location: login.php');
        exit();
}

 include $tpl . 'footer.php'; 
 ob_end_flush();
 ?>

 include $tpl . 'footer.php'; ?>
