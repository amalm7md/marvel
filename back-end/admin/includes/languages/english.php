<?php
	
	function lang($phrase){

		static $lang = array(
			'MESSAGE' => 'Welcome',
			'ADMIN' => 'Admin',


			//Dashboard phrases

			//navbar links
			'HOME_ADMIN' => 'Home',
			'CATEGORIES' => 'Categories',
			'ITEMS' => 'Items',
			'MEMBERS' => 'Members',
			'STATISTICS' => 'Statistics',
			'LOGS' => 'Logs',
			'LOGS' => 'Logs',
			'COMMENTS' => 'Comments',
			'' => '',
			'' => '',
			'' => '',
			'' => ''
			
		);

		return $lang[$phrase];
	}