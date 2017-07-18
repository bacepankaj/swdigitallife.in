<?
	/**
	* signup Controller Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class signup extends Controller {
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

        /**
		* verify
		*
		* Function verify
		* @author Susanta Das
		*/
		function verify(){
			// get data from registratio
            $data = json_decode($this->functions->encrypt_decrypt('decrypt', $this->parameters['verificationCode']));
           
            // get opt
            $otp = strtoupper($this->functions->GenerateRandomString(6, '1234567890'));   

            // set otp
            $data->otp = $otp;
                  
            // prepare msg             
            if($data->controller=='signup')
                $msg = "Dear $data->name Thank to register with ".APP_NAME." your Id no is $otp";
            else if($data->controller=='forgot_password')
                $msg = "Dear $data->name Thank to register with ".APP_NAME." your Id no is $otp";
            
            // send message otp
            $this->functions->send_msg($data->mobile, $msg);
            
            // assign data to view
            $this->view->assign('data', $data);
            
            // render view page
			$this->view->display('signup/verify.html', false, false);
		}	
        
        /**
		* otp_verification
		*
		* Function otp_verification
		* @author Susanta Das
		*/
		function otp_verification(){
            $this->model->otp_verification();
        }
	}
?>