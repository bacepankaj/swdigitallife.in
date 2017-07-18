<?
	/**
	* forgot_password_model Model Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/	
	class forgot_password_model extends Model {
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
            $user = $this->use_table('user')->where_raw("(user_name = '$username' OR mobile = '$username')")->find_one();
                        
            // check if exists
            if(is_object($user)) {       
                // show error message
                MsgBox::view()->show(Lang::error('006', array('mobile'=>$mobile, 'name'=>$name))->msg, Lang::error('003')->title, null, true, 1, 'success.svg', APP_PATH.'/signup/verify?verificationCode='.$this->functions->encrypt_decrypt('encrypt', json_encode(array('mobile'=>$user->mobile, 'name'=>$user->name, 'controller'=>$this->controller))), APP_PATH.'/signup');	
            } else {
                // show error message
                MsgBox::view()->show(Lang::error('001', array('login_attempts'=>$data->login_attempts))->msg, Lang::error('001')->title);									
            }
		}
	}
?>