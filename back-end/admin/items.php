<?php 

ob_start();
session_start();
$pageTitle = 'Items';
if(isset($_SESSION['Username'])){


    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


    if($do == 'Manage'){ 

        $stmt = $con->prepare("
            SELECT items.*, categories.Name AS category_name, users.Username
            FROM items
            INNER JOIN categories
            ON categories.ID = items.Cat_ID
            INNER JOIN users
            ON users.UserID = items.Member_ID
            ");
        $stmt->execute();
        $items = $stmt->fetchAll();

        ?>


        <h1 class="text-center">Manage Items</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Price</td>
                        <td>Adding Date</td>
                        <td>Category</td>
                        <td>Username</td>
                        <td>Control</td>
                    </tr>

                    <?php

                    foreach ($items as $item) {
                        echo "<tr>";
                            echo "<td>" . $item['Item_ID'] . "</td>";
                            echo "<td>" . $item['Name'] . "</td>";
                            echo "<td>" . $item['Description'] . "</td>";
                            echo "<td>" . $item['Price'] . "</td>";
                            echo "<td>" . $item['Add_Date'] . "</td>";
                            echo "<td>" . $item['category_name'] . "</td>";
                            echo "<td>" . $item['Username'] . "</td>"; 
                            echo "<td>
                                    <a href='items.php?do=Edit&itemid=" . $item['Item_ID'] ."' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                    <a href='items.php?do=Delete&itemid=" . $item['Item_ID'] ."' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
                                    if ($item['Approve'] == 0) {
                                            echo "<a href='items.php?do=Approve&itemid=" . $item['Item_ID'] ."' class='btn btn-info activate'><i class='fa fa-check'></i> Approve </a>";
                                        }

                                echo "</td>";
                        echo "</tr>";
                    }

                    ?>

                </table>
            </div>
            <a href="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Item</a>
        </div>  

            

    <?php 

    }elseif($do == 'Add'){  ?>

        

        <h1 class="text-center">Add New Item</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=Insert" method="POST">

                    <input type="hidden" name="catid" value="<?php echo $catid ?>"/>

                    <!---Name field--->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="name" class="form-control"  required="required" placeholder="Name Of The Item"/>
                        </div>
                    </div>

                    <!---Description field--->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="desc" class="form-control" required="required" placeholder="Description Of The Item"/>
                        </div>
                    </div>

                    <!---Price field--->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="price" class="form-control" required="required" placeholder="Price Of The Item"/>
                        </div>
                    </div>

                    <!---Country field--->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Country</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="country" class="form-control" required="required" placeholder="Country of Made"/>
                        </div>
                    </div>

                    <!---Status selectbox--->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10 col-md-6">
                            <select name="status">
                                <option value="0">...</option>
                                <option value="1">New</option>
                                <option value="2">Like New</option>
                                <option value="3">Used</option>
                                <option value="4">Very Old</option>
                            </select>
                        </div>
                    </div>


                    <!---Members selectbox--->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Member</label>
                        <div class="col-sm-10 col-md-6">
                            <select name="member">
                                <option value="0">...</option>
                                <?php
                                    $stmt = $con->prepare("SELECT * FROM users");
                                    $stmt->execute();
                                    $users = $stmt->fetchAll();
                                    foreach ($users as $user) {
                                        echo "<option value= '" . $user['UserID'] . "'>" . $user['Username'] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>


                    <!---Category selectbox--->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-10 col-md-6">
                            <select name="category">
                                <option value="0">...</option>
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
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Add Item" class="btn btn-primary btn-lg"/>
                        </div>
                    </div>
                </form>
            </div>

    <?php

    }elseif($do == 'Insert'){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    echo " <h1 class='text-center'>Insert Item</h1> ";
                    echo "<div class='container'>";

                    // get Variables from the Form  

                    $name       = $_POST['name'];
                    $desc       = $_POST['desc'];
                    $price      = $_POST['price'];
                    $country    = $_POST['country'];
                    $status     = $_POST['status'];
                    $member     = $_POST['member'];
                    $cat     = $_POST['category'];



                    // Validate Fields

                    $formErrors = array();


                    if(empty($name)){
                        $formErrors[] = 'Name can\'t be <strong>Empty</strong>' ;
                    }
                    if(empty($desc)){
                        $formErrors[] = 'Description can\'t be <strong>Empty</strong>' ;
                    }
                    if(empty($price)){
                        $formErrors[] = 'Price can\'t be <strong>Empty</strong>';
                    }
                    if(empty($country)){
                        $formErrors[] = 'Country can\'t be <strong>Empty</strong>';
                    }
                    if($status == 0){
                        $formErrors[] = 'You must choose the<strong>Status</strong>';
                    }
                    if($member == 0){
                        $formErrors[] = 'You must choose the<strong>Member</strong>';
                    }
                    if($cat == 0){
                        $formErrors[] = 'You must choose the<strong>Category</strong>';
                    }
                    foreach ($formErrors as $error) {
                        echo '<div class="alert alert-danger">' . $error . '</div>';
                    }


                    // Insert User Info To Database 

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
                            'cat'=>$cat,
                            'member'=>$member
                        )); 

                        echo "<div class='container'>";
                        $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
                        redirectHome($theMsg , 'back');
                        echo "</div>";  
                                
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

    }elseif($do == 'Edit'){

        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

                $stmt = $con->prepare("SELECT * FROM items WHERE Item_Id = ?");

                $stmt->execute(array($itemid));
                $item = $stmt->fetch();
                $count = $stmt->rowCount();

                if($count > 0){  ?>

                    <h1 class="text-center">Edit Item</h1>
                    <div class="container">
                        <form class="form-horizontal" action="?do=Update" method="POST">

                            <input type="hidden" name="itemid" value="<?php echo $itemid ?>"/>

                            <!---Name field--->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" name="name" class="form-control"  required="required" placeholder="Name Of The Item" 
                                    value="<?php echo $item['Name'] ?>" />
                                </div>
                            </div>

                            <!---Description field--->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" name="desc" class="form-control" required="required" placeholder="Description Of The Item" 
                                    value="<?php echo $item['Description'] ?>"/>
                                </div>
                            </div>

                            <!---Price field--->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Price</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" name="price" class="form-control" required="required" placeholder="Price Of The Item" 
                                    value="<?php echo $item['Price'] ?>"/>
                                </div>
                            </div>

                            <!---Country field--->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Country</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" name="country" class="form-control" required="required" placeholder="Country of Made" 
                                    value="<?php echo $item['Country_Made'] ?>"/>
                                </div>
                            </div>

                            <!---Status selectbox--->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Status</label>
                                <div class="col-sm-10 col-md-6">
                                    <select name="status">
                                        <option value="1" <?php if($item['Status'] == 1){echo 'selected';} ?> >New</option>
                                        <option value="2" <?php if($item['Status'] == 2){echo 'selected';} ?> >Like New</option>
                                        <option value="3"<?php if($item['Status'] == 3){echo 'selected';} ?> >Used</option>
                                        <option value="4" <?php if($item['Status'] == 4){echo 'selected';} ?> >Very Old</option>
                                    </select>
                                </div>
                            </div>


                            <!---Members selectbox--->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Member</label>
                                <div class="col-sm-10 col-md-6">
                                    <select name="member">
                                        <?php
                                            $stmt = $con->prepare("SELECT * FROM users");
                                            $stmt->execute();
                                            $users = $stmt->fetchAll();
                                            foreach ($users as $user) {
                                                echo "<option value= '" . $user['UserID'] . "'"; 
                                                if($item['Member_ID'] == $user['UserID']){
                                                    echo 'selected';} 
                                                echo ">" . $user['Username'] . "</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>


                            <!---Category selectbox--->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Category</label>
                                <div class="col-sm-10 col-md-6">
                                    <select name="category">
                                        <?php
                                            $stmt2 = $con->prepare("SELECT * FROM categories");
                                            $stmt2->execute();
                                            $cats = $stmt2->fetchAll();
                                            foreach ($cats as $cat) {
                                                echo "<option value= '" . $cat['ID'] . "'"; 
                                                if($item['Cat_ID'] == $cat['ID']){
                                                    echo 'selected';} 
                                                echo ">" . $cat['Name'] . "</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            

                            <!---save button--->
                            <div class="form-group form-group-lg">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="submit" value="Save Item" class="btn btn-primary btn-lg"/>
                                </div>
                            </div>
                        </form>
                    </div>

            <?php

                }else{

                    echo "<div class='container'>";
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Theres No Such ID</div>';
                    redirectHome($theMsg , 'back');
                    echo "</div>"; 
                }

    }elseif($do == 'Update'){  

        echo " <h1 class='text-center'>Update Item</h1> ";
            echo "<div class='container'>";

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // get Variables from the Form 

                $id         = $_POST['itemid'];
                $name       = $_POST['name'];
                $desc       = $_POST['desc'];
                $price      = $_POST['price'];

                $country      = $_POST['country'];
                $status      = $_POST['status'];
                $member      = $_POST['member'];
                $cat      = $_POST['category'];


                // Validate Fields

               $formErrors = array();


                if(empty($name)){
                    $formErrors[] = 'Name can\'t be <strong>Empty</strong>' ;
                }
                if(empty($desc)){
                    $formErrors[] = 'Description can\'t be <strong>Empty</strong>' ;
                }
                if(empty($price)){
                    $formErrors[] = 'Price can\'t be <strong>Empty</strong>';
                }
                if(empty($country)){
                    $formErrors[] = 'Country can\'t be <strong>Empty</strong>';
                }
                if($status == 0){
                    $formErrors[] = 'You must choose the<strong>Status</strong>';
                }
                if($member == 0){
                    $formErrors[] = 'You must choose the<strong>Member</strong>';
                }
                if($cat == 0){
                    $formErrors[] = 'You must choose the<strong>Category</strong>';
                }
                foreach ($formErrors as $error) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }


                // Update Database with this info

                if(empty($formErrors)){

                    $stmt = $con->prepare("
                        UPDATE items SET Name = ?, Description = ?, Price = ?, Country_Made = ?, Status = ?, Cat_ID = ?, Member_ID = ?
                        WHERE Item_ID = ? ");

                    $stmt->execute(array( $name, $desc, $price, $country, $status, $cat, $member, $id));

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

    }elseif($do == 'Delete'){ 

        echo " <h1 class='text-center'>Delete Item</h1> ";
            echo "<div class='container'>";

                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

                $check = checkItem('Item_ID' , 'items' , $itemid);

                if($check > 0){ 

                    $stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :id");
                    $stmt->bindParam(":id", $itemid);
                    $stmt->execute();

                    echo "<div class='container'>";
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';
                    redirectHome($theMsg,'back');
                    echo "</div>";

                }else{
                    echo "<div class='container'>";
                    $theMsg = '<div class="alert alert-danger">There Is No Such ID</div>';
                    redirectHome($theMsg);
                    echo "</div>";
                    }

            echo '</div>';

    }elseif($do == 'Approve'){ 

        echo " <h1 class='text-center'>Approve Item</h1> ";
            echo "<div class='container'>";

                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;


                $check = checkItem('Item_ID' , 'items' , $itemid);

                if($check > 0){ 

                    $stmt = $con->prepare("UPDATE items SET Approve = 1  WHERE Item_ID = ?");

                    $stmt->execute(array($itemid));

                    echo "<div class='container'>";
                    $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Item Approved</div>';
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

    include $tpl .'footer.php';
    }else{
        header('Location: index.php');
        exit();
    }
  ob_get_flush();
?>