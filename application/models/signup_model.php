<?
	/**
	* signup_model Model Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/	
	class signup_model extends Model {
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
            $user = $this->use_table('user')->where('mobile', $mobile)->find_one();
            
            // check if exists
            if(is_object($user)){
                // show error message
                MsgBox::view()->show(Lang::error('002', array('mobile'=>$mobile, 'name'=>$name))->msg, Lang::error('002')->title);									
            } else {
                // show error message
                MsgBox::view()->show(Lang::error('003', array('mobile'=>$mobile, 'name'=>$name))->msg, Lang::error('003')->title, null, true, 1, 'success.svg', APP_PATH.'/signup/verify?verificationCode='.$this->functions->encrypt_decrypt('encrypt', json_encode(array('mobile'=>$mobile, 'name'=>$name, 'controller'=>$this->controller))), APP_PATH.'/signup');	
            }
		}
        
        /**
		* otp_verification
		*
		* Function otp_verification
		* @author Susanta Das
		*/
		function otp_verification(){
            // extract post data into memory
            extract($_POST);
            
            // get data from registratio
            $data = json_decode($this->functions->encrypt_decrypt('decrypt', $verificationCode));
              
            // validate otp
            if($otp==$data->otp){
                if($data->controller=='signup'){
                    // create user
                    $user = $this->use_table('user')->create();
                    
                    // set fields
                    $user->id = $this->functions->uuid();
                    $user->user_name = $this->functions->GenerateId('user', 'user_name');
                    $user->name = $data->name;
                    $user->password = md5($password);
                    $user->mobile = $data->mobile;
                    
                    // save data
                    $user->save();
                    
                    // if user is valid login to session
                    Session::set_state(true);
                    Session::set('user_id', $user->id);
                    Session::set('user_name', $user->user_name);
                    Session::set('name', $user->name);                  
                    Session::set('email', $user->email);
                    Session::set('mobile', $user->mobile);                
                    Session::set('is_admin', $user->is_admin);	
                    Session::set('last_login', $user->last_login);	
                    Session::set('logged_with_master_password', false);
                     
                    // prepare msg
                    $msg = "Dear $data->name Your Id no is $user->user_name and password is $password This Id will be used as an referral. Thank you for choosing ".APP_NAME;
                    
                    // send message otp
                    $this->functions->send_msg($data->mobile, $msg);
                     
                    // show error message
                    MsgBox::view()->show(Lang::error('005', array('name'=>$data->name))->msg, Lang::error('005')->title, null, true, 3, 'success.svg', APP_PATH.'/dashboard');	
                } else if($data->controller=='forgot_password'){
                    // create user
                    $user = $this->use_table('user')->where('mobile', $data->mobile)->find_one();
                    
                    // set fields
                    $user->password = md5($password);
                    
                    // save data
                    $user->save();
                    
                    // prepare msg
                    $msg = "Dear $data->name Your Id no is $user->user_name and reset password is $password This Id will be used as an referral. Thank you for choosing ".APP_NAME;
                    
                    // send message otp
                    $this->functions->send_msg($data->mobile, $msg);
                     
                    // show error message
                    MsgBox::view()->show(Lang::error('007', array('name'=>$data->name))->msg, Lang::error('007')->title, null, true, 3, 'success.svg', APP_PATH.'/login');	
                }
            } else {
                // show error message
                MsgBox::view()->show(Lang::error('004', array('mobile'=>$mobile, 'name'=>$name))->msg, Lang::error('004')->title);
            }      
        }
	}
?>