
<?php

	function lang($phrase) {

		static $lang = array(

			// Navbar links

			'ADMIN_HOME' 		=> 'Admin Area' ,
			'ADMIN_CATEGORIES' 	=> 'categories' ,
			'ADMIN_ITEM' 		=> 'items' ,
			'ADMIN_MEMBERS' 	=> 'members' ,
			'ADMIN_COMMENTS'	=> 'comments',
			'ADMIN_STATISTICS' 	=> 'statistics' ,
			'ADMIN_LOGS' 		=> 'logs' ,
			'ADMIN_EDIT' 		=> 'edit profile',
			'ADMIN_SETTING' 	=> 'setting' ,
			'ADMIN_LOGOUT' 		=> 'logout' 

		);

		return $lang[$phrase];

	}
	
