<?
	/**
	* sys_department_model Model Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/	
	class login_model extends Model {
		/**
		* __construct class initialization
		*
		* Function __construct
		* @author Susanta Das
		*/
		function __construct() {			
			parent::__construct();
		}
		
		function submit(){
			// extract post data into memory
            extract($_POST);
            
            // if valid user
            if($username=='swdigitallife.in' && $password=='swdigitallife@321') {            
                // set the session to active
                Session::set_state(true);
			
                // redirect to dashboard
                $this->redirect('dashboard');
            } else {
                // show error message
                MsgBox::view()->show(Lang::error('001', array('login_attempts'=>$data->login_attempts))->msg, Lang::error('001')->title);									
            }
		}
	}
?>