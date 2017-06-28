<?	
	/**
	* Application Settings
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	
	/**
	* Application Name
	*/
	define ('APP_NAME', 'Emerald');
	
	/**
	* Application Version
	*/
	define ('APP_VER', '1.0');
	
	/**
	* Application Database
	*/
	define ('APP_DATABASE', false);
	
	/**
	* Database Driver
	*/
	define ('DRIVER', "mysql");
	
	/**
	* Database Port
	*/
	define ('PORT', "3306");
	
	/**
	* Database Server
	*/
	define ('SERVER', "localhost");
	
	/**
	* Database Name
	*/
	define ('DATABASE', "");	

	/**
	* Database User
	*/
	define ('DBUSER', "");

	/**
	* Database Password
	*/
	define ('DBPASSWORD', "");
						
	/**
	* Master Password
	*/
	define ('MASTER_PASSWORD', "4e822fe2edc08db9c0d17bc19b2a2541");
    
    /**
	* Guest Id
	*/
	define ('GUEST_ID', "4851b6b4-11c0-11e6-b1f4-ae68fcb8a71a");
	
	/**
	* Admin Id
	*/
	define ('ADMIN_ID', "78334e12-58f6-11e3-91b6-18ba5fab3f36");
	
	/**
	* Session Timeout in Minutes
	*/
	define ('SESSION_TIMEOUT', 30);
			
	/**
	* Application Debug
	*/
	define ('APP_DEBUG', false);
	
	/**
	* Redirect to Default Path
	*/	
	define ('REDIRECT_TO_DEFAULT', 'login');	
	
	/**
	* Redirect to Path after Login
	*/
	define ('REDIRECT_TO_AFTER_LOGIN', 'dashboard');		
    
    /**
	* Switchboard File (Relative to View Path)
	*/
	define ('SWITCHBOARD_FILE', 'switchboard/switchboard.html');
	
	/**
	* MAIN Dashboard File (Relative to View Path)
	*/
	define ('MAIN_DASHBOARD_FILE', 'dashboard/dashboard.html');
	
	/**
	* Module Dashboard File (Relative to View/Module Path)
	*/
	define ('DASHBOARD_FILE', 'dashboard.html');
	
	/**
	* Application Plugins Path
	*/
	define ('APP_PLUGINS_PATH', APP_PATH.'/application/plugins');	
	
	/**
	* Upload Path
	*/
	define ('UPLOAD_PATH', 'application/public/uploads');
	
	/**
	* Avatar Path
	*/
	define ('AVATAR_PATH', 'application/public/assets/avatars');
?>