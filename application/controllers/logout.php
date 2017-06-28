<?
	/**
	* Logout Controller Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class logout extends Controller {
		/**
		* __construct class initialization
		*
		* Function __construct
		* @author Susanta Das
		*/
		function __construct() {
			parent::__construct();
						
			// destroy session
			Session::destroy();
			
			// redirect to default page			
			$this->redirect(REDIRECT_TO_DEFAULT);			
		}
	}
?>