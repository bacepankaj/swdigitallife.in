<?
	/**
	* System Configuration
	*
	* @link http://somnetics.in/
	* @copyright 2010-2011 Somnetics Pvt. Ltd.
	* @author Susanta Das <susanta.das@somnet.co.in>
	* @version 1.0.60
	*/

	/**
	* Sanitize Server Variables
	*/
	$_SERVER['HTTP_REFERER'] = filter_var($_SERVER['HTTP_REFERER'], FILTER_SANITIZE_STRING);
	$_SERVER['SCRIPT_NAME'] = filter_var($_SERVER['SCRIPT_NAME'], FILTER_SANITIZE_STRING);
	$_SERVER['REDIRECT_URL'] = filter_var($_SERVER['REDIRECT_URL'], FILTER_SANITIZE_STRING);
	$_SERVER['REQUEST_URI'] = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING);
	$_SERVER['QUERY_STRING'] = filter_var($_SERVER['QUERY_STRING'], FILTER_SANITIZE_STRING);
	$_SERVER['HTTP_USER_AGENT'] = filter_var($_SERVER['HTTP_USER_AGENT'], FILTER_SANITIZE_STRING);
	$_SERVER['HTTP_HOST'] = filter_var($_SERVER['HTTP_HOST'], FILTER_SANITIZE_STRING);
	
	/**
	* Set Timezone
	*/
	date_default_timezone_set('Asia/Kolkata');
	
	/**
	* Application Directory
	*/
	define ('APP_DIR', basename(dirname(dirname(dirname(dirname(__FILE__))))));
		
	/**
	* Base Directory
	*/
	define ('BASE_DIR', dirname(dirname(dirname(dirname(__FILE__)))));

	/**
	* Base Path
	*/
	define ('BASE_PATH', str_replace('\\', '/', BASE_DIR));			
	
	/**
	* Application Path
	*/
	if(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])) != '/')
		define ('APP_PATH', dirname($_SERVER['SCRIPT_NAME']));
	else
		define ('APP_PATH', null);
	
	/**
	* Application Path
	*/
	define ('APPLICATION_PATH', BASE_PATH.'/application');
	
	/**
	* System Plugins Path
	*/
	define ('SYS_PLUGINS_PATH', APP_PATH.'/system/core/plugins');
	
	/**
	* Public Path
	*/
	define ('PUBLIC_PATH', APP_PATH.'/application/public');
		
	/**
	* Last Url
	*/
	define ('REQUEST_URL', (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : null);
	
	/**
	* Redirect Url
	*/
	define ('REDIRECT_URL', (isset($_SERVER['REDIRECT_URL'])) ? $_SERVER['REDIRECT_URL'] : null);
	
	/**
	* Request Url
	*/
	define ('REQUEST_URI', (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : null);
	
	/**
	* Request Base Uri
	*/
	define ('BASE_URI', substr(REQUEST_URI, strpos(REQUEST_URI, APP_PATH) + strlen(APP_PATH) + 1));
	
	/**
	* Return Url
	*/
	//define ('RETURN_URL',  urlencode(ltrim(str_replace(APP_PATH, '', REQUEST_URI), '/')));
	define ('RETURN_URL',  urlencode(REQUEST_URI));
		
	/**
	* Query String
	*/
	define ('QUERY_STRING', (isset($_SERVER['QUERY_STRING'])) ? $_SERVER['QUERY_STRING'] : null);	
	
	/**
	* Browser Info
	*/
	define ('BROWSER', (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : null);
	
	/**
	* Enable HTTPS
	*/
	define ('ENABLES_HTTPS', false);
	
	/**
	* Server Protocol
	*/
	if(ENABLES_HTTPS)
		define ('SERVER_PROTOCOL', 'https');
	else
		define ('SERVER_PROTOCOL', 'http');
		
	/**
	* Base URL
	*/
	define ('BASE_URL', SERVER_PROTOCOL.'://'.$_SERVER['HTTP_HOST'].APP_PATH);
	
	/**
	* Default Form Submit Action Path
	*/
	define ('FORM_ACTION', 'submit');
		
	/**
	* Header File (Relative to View Path)
	*/
	define ('HEADER_FILE', 'header.html');
	
	/**
	* Footer File (Relative to View Path)
	*/
	define ('FOOTER_FILE', 'footer.html');	
	
	/**
	* Msgbox File (Relative to View Path)
	*/
	define ('MSGBOX_FILE', 'msgbox/msgbox.html');
	
	/**
	* Search File (Relative to View Path)
	*/
	define ('SEARCH_FILE', 'search/grid.html');
	
	/**	
	* Style Default System Date
	*/
	define ('SYSTEM_DATE', date('Y-m-d H:i:s'));	
?>