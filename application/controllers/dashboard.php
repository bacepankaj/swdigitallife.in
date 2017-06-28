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
		}		
		
		/**
		* landing
		*
		* Function landing
		* @author Susanta Das
		*/
		function landing(){
			// render view page
			$this->view->display($this->view->template);	
		}
		
		/**
		* other method
		*
		* Function other
		* @author Susanta Das
		*/
		function other($param1, $param2){
			$this->view->assign('param1', $param1);
			$this->view->assign('param2', $param2);
			
			// render view page
			$this->view->display($this->view->template);	
		}
		
		/**
		* otherview method with other view
		*
		* Function otherview
		* @author Susanta Das
		*/
		function otherview($param1, $param2){
			$this->view->assign('param1', $param1);
			$this->view->assign('param2', $param2);
			
			// render view page
			$this->view->display('dashboard/otherview.html');
		}
	}
?>