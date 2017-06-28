<?
	/**
	* Login Controller Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class login extends Controller {
		/**
		* __construct class initialization
		*
		* Function __construct
		* @author Susanta Das
		*/
		function __construct() {
			parent::__construct(false);
						
			// redirect to redirect after login page if logged on state is true			
			if(Session::get_state())
			$this->redirect($this->redirect_to_after_login);
		}
		
		/**
		* Index
		*
		* Function index
		* @author Susanta Das
		*/
		function index(){
			// render view page
			$this->view->display($this->view->template, false, false);
		}	
	}
?>