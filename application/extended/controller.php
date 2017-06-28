<?
	/**
	* Extends Main Controller Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class Controller extends MainController {
		/**
		* __construct class initialization
		*
		* Function __construct
		* @author Susanta Das
		*/
		function __construct($check_session=true, $check_privilege=true) {			
			parent::__construct($check_session);
			
			// default module redirection after login	
			$redirect_to_after_login = Session::get('redirect_to_after_login');
							
			// get if empty
			if(empty($redirect_to_after_login))
				$this->redirect_to_after_login = REDIRECT_TO_AFTER_LOGIN;
			else
				$this->redirect_to_after_login = $redirect_to_after_login;
		}
	}
?>
