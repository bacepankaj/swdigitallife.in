<?
	/**
	* Main Dashboard Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class dashboard extends Controller {
		/**
		* __construct class initialization
		*
		* Function __construct
		* @author Susanta Das
		*/
		function __construct() {
			parent::__construct();
            
            // disable operation menu
            $this->view->operation_menu = array();
            
            // override caption
            $this->view->caption = "Overview & Status";
		}
        
        function index() {
            // render view page
			$this->view->display($this->view->template);
        }
	}
?>