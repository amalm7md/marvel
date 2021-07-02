<?php

    ob_start();
	 session_start();
	 $pageTitle = 'Homepage';
	 include 'init.php'

	 ?>
<div class ="container ">
<div class="row">
	<?php
	$allItems = getAllFrom('items' , 'Item_ID' , 'where Approve = 1');
    foreach($allItems as $item){
        echo '<div class="col-sm-6 coll-md-3">';
           echo '<div class ="thumbnail item-box">';
            echo '<span class="price-tag"> $' . $item['price'] . '</span>'; 
               echo '<img class="img-responsive" src="img.png" alt="" />';
               echo'<div class="caption">' ;
                    echo '<h3> <a href="items.php?itemid='. $item['Item_ID'].'">' . $item['Name'] . '</a></h3>' ;
                    echo '<p>' . $item['Description']. '</p>';
                    echo '<div class="date">' . $item['Add_Date']. '</div>';

        echo'</div>';
        echo'</div>';
        echo'</div>';

	 session_start();
	 $pageTitle = 'Home';

	 session_start();
	 $pageTitle = 'Home';


	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';

    }
    ?>
    </div>
    </div>
  
  <?php  }
    include $tpl . 'footer.php';
    ob_end_flush() ;
?>
	}
	$uri .= $_SERVER['HTTP_HOST'];
	header('Location: '.$uri.'/dashboard/');
	exit;
?>
   
