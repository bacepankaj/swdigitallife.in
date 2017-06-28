<?
	/**
	* Database Config for ORM
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	
	// check if database is used
	if(APP_DATABASE)
	{	
		// config database 
		ORM::configure(array(
			'connection_string' => DRIVER.':host='.SERVER.';dbname='.DATABASE,
			'username' => DBUSER,
			'password' => DBPASSWORD,
			//'error_mode' => PDO::ERRMODE_SILENT,
			'id_column' => 'id',				
			'return_result_sets' => true,
			'caching' => true
		));
	}
?>