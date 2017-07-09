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
            
            // get user
            $user = $this->use_table('user')->where_raw("(user_name = '$username' OR mobile = '$username') AND password = md5('$password')")->find_one();
            
            // check if exists
            if(is_object($user)) {       
                // set the session to active
                Session::set_state(true);
                Session::set('user_id', $user->id);
                Session::set('user_name', $user->user_name);
                Session::set('name', $user->name);                  
                Session::set('email', $user->email);
                Session::set('mobile', $user->mobile);                
                Session::set('is_admin', $user->is_admin);	
                Session::set('last_login', $user->last_login);	                
                Session::set('logged_with_master_password', false);
                
                // redirect to dashboard
                $this->redirect('dashboard');
            } else {
                // show error message
                MsgBox::view()->show(Lang::error('001', array('login_attempts'=>$data->login_attempts))->msg, Lang::error('001')->title);									
            }
		}
	}
?>