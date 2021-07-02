<?php

function getAllFrom($tableName , $orderBy , $where=NULL){

	global $con;
	$sql = $where == NULL ? '' : $where ;
	$getAll =$con->prepare("SELECT * FROM $tableName $sql ORDER BY $orderBy DESC ");
	$getAll->execute();
	$all = $getAll->fetchAll();
	return $all;

}


	/*
	** title functon v1.0
	*/
	function getTitle(){
		global $pageTitle;
		if(isset($pageTitle)){
			echo $pageTitle;

		}else{

			echo 'Default';

		}
	}
           /*check if user is not active*/
	function checkUserStatus($user){
		global $con;
		$stmt = $con->prepare("SELECT Username,RegStatus 

		FROM 
		users
		WHERE Username = ?
		AND
		RegStatus  = 0 ");

		$stmtx->execute(array($user));
		$Status =$stmt->rowCount();
		return $Status;
	}

<
	function getcat(){

		global $con;
	    $getcat =$con->prepare("SELECT * FROM categories ORDER BY ID ASC");
	    $getcat->execute();
	    $cats = $getcat->fetchAll();
	    return $cats;

	}

	/*
	** check items function v1.0
	** function to check item in database [function accept parameters]
	**$select = the item to select [example : user,item, category]
	**$from = the table to select from [example : users ,items , categories]
	**$value = the value of select[example : osama ,box , electronics]
	*/

	function checkItem($select , $from , $value){
	    
	    global $con;
	    $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
	    $statement->execute(array($value));
	    $count = $statement->rowCount();
	    //echo $count;
	    return $count;

	}

	/*get item function*/
	function getItems($where , $value , $approve = NULL){

		global $con;
		$sql = $approve == NULL ? 'AND Approve = 1' : '' ;
		
	    $getItems =$con->prepare("SELECT * FROM items WHERE $where = ? $sql ORDER BY Item_ID DESC");

	    $getItems->execute(array($value));
	    $Items = $getItems->fetchAll();
	    return $Items;

	}


	/* 
	** home redirect function v2.0
	** this function accept parameters
	** $theMsg = Echo the message [error | success | warning]
	** url = the link you want to redirect
	** $seconds = seconds before redirecting  
	*/

	function redirectHome($theMsg , $url = null ,$seconds = 3) {

	    if($url === null){
	        $url = 'index.php';
	        $link = 'Home Page' ;
	    }else{
	            //$url = isset($_SERVER['HTTP_REFERER']) &&  $_SERVER['HTTP_REFERER'] !== '' ? $_SERVER['HTTP_REFERER'] : 'index.php';
	            //$link = 'previous Page' ;
	            
	            if(isset($_SERVER['HTTP_REFERER']) &&  $_SERVER['HTTP_REFERER'] !== '' ) {
	                $url = $_SERVER['HTTP_REFERER'];
	                $link = 'previous Page' ;
	            } else {
	                $url = 'index.php';
	                $link = 'Home Page' ;
	            }
	        }
	        echo $theMsg;
	        echo " <div class= 'alert alert-info'>You Will Be Redirected to $link After $seconds seconds</div> " ;
	        header("refresh:$seconds ; url=$url");
	        exit();
	       // $url = $_SERVER['HTTP_REFERER'];
	}



	/**count number of items function v1.0 
	**function 
	**$item= the item to count
	**$table= the table to choose from  
	**/

	function countItems($item,$table){
	    global $con;
	    $stmt2 =$con->prepare("SELECT COUNT($item)FROM $table");
	    $stmt2->execute();
	    return $stmt2->fetchColumn();

	}


	/*
	**get latest items functionds v1.0  
	*/
	function getLatest($select, $table, $order, $limit=5){

		global $con;
	    $getStmt =$con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");
	    $getStmt->execute();
	    $rows = $getStmt->fetchAll();
	    return $rows;

	}