<?
	/**
	* Index Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class index extends Controller {
		/**
		* __construct class initialization
		*
		* Function __construct
		* @author Susanta Das
		*/
		function __construct() {
			parent::__construct();			
		}
				
		/**
		* Index
		*
		* Function index
		* @author Susanta Das
		*/
		function index(){
			// redirect to default after login
			$this->redirect($this->redirect_to_after_login);	
		}
	}
?>