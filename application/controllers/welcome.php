<?
	/**
	* Session Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class welcome extends Controller {
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
			// assign view variable
			$this->view->assign('welcome_message', Lang::error(001, array('user'=>'Dear'))->msg);
			
			// render view page
			$this->view->display($this->view->template);
		}
		
		function check(){
            $this->view->display($this->view->template);
            
            //print_r(Session::get('session_result'));
		}
	}
?>