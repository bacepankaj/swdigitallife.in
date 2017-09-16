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
		* payment
		*
		* Function payment
		* @author Susanta Das
		*/
		function payment(){
            // get required parameters
            $parameters = array();
            
            // set required parameters
            $parameters['mid'] = "WL0000000027698";
            $parameters['encKey'] = "6375b97b954b37f956966977e5753ee6";
            //$parameters['orderId'] = date("Ymdhis", strtotime("now"));
            $parameters['orderId'] = mktime(date());
            $parameters['amount'] = "301";
            $parameters['remarks'] = "Account Registration Fees";
            $parameters['responseUrl'] = AJAX_URL.'/verify?verificationCode='.$this->parameters['verificationCode'];
                        
            // parameters to memory
            extract($parameters);
            
            //require phpToolKit for payment gateway
            require BASE_PATH.'/application/plugins/phpToolKit/Sample_Project_Standard/meTrnPay.php';
            
            //phpinfo();
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
            $msg = "Your SWDIGITALLIFE OTP Authentication Code is $otp";
            
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
        
        /**
		* import data
		*
		* Function import
		* @author Susanta Das
		*/        
        function import(){
            $handle = fopen(UPLOAD_PATH."/data.csv", "r");
            
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    $data = explode(",", $line);
                    
                    if(is_numeric($data[0]))
                    {
                        $name = $data[1];
                        $mobile = substr($data[2], 0, 10);    
                        $username = substr($data[3], 3, 5);    
                        $id_prefix = $this->functions->date_format($data[4], "ym");    
                        $username = $id_prefix.$username;
                        $doj = $this->functions->date_format($data[4], "Y-m-d");  
                        $reffer_by_username = substr($data[5], 3, 5);  
                            
                        if(!empty($reffer_by_username)){
                            $reffer_by_id = $this->model->use_table('user')->where_like("user_name", "%$reffer_by_username")->find_one();
                            
                            if(is_object($reffer_by_id))
                            {
                                $reffer_by = $reffer_by_id->id;
                            }
                        } else {
                            $reffer_by = null;
                        }
                        
                        $address = $data[20];
                        
                        // add user
                        $user = $this->model->use_table('user')->create();
                        
                        $user->id = $this->functions->uuid();
                        $user->user_name = $username;
                        $user->name = $name;
                        $user->mobile = $mobile;                       
                        $user->reffered_by = $reffer_by;
                        $user->date_of_joining = $doj;
                        $user->save();
                        
                        // add user_profile
                        $user_profile = $this->model->use_table('user_profile')->create();
                        
                        $user_profile->id = $user->id;
                        $user_profile->street_road_name = $address;
                        $user_profile->save();
                    }
                }

                fclose($handle);
            }
        }
        
        function testSMS($mobile, $otp) {
            // prepare msg                         
            $msg = "Your SWDIGITALLIFE OTP Authentication Code is $otp";
            
            // send message otp
            $this->functions->send_msg($mobile, $msg);
        }
	}
?>