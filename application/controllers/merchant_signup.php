<?
	/**
	* merchant_signup Controller Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class merchant_signup extends Controller {
		/**
		* __construct class initialization
		*
		* Function __construct
		* @author Susanta Das
		*/
		function __construct() {
			parent::__construct(true);
            
            // disable operation menu
            $this->view->operation_menu = array();
		}
		
		/**
		* Index
		*
		* Function index
		* @author Susanta Das
		*/
		function index(){
			// render view page
			$this->view->display($this->view->template);
		}
	}
?>