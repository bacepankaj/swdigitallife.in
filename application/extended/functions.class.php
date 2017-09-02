<?
	/**
	* Extends Main Function Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class Functions extends MainFunctions {
		/**
		* __construct class initialization
		*
		* Function __construct
		* @author Susanta Das
		*/		
		function __construct() {						
			parent::__construct();			
		}
        
        function send_msg($phone_no, $message){
            //Dear XXXX Thank to register with XXXX your Id no is XXXX
            //Dear XXXX Your Id no is XXXX This Id will be used as an referral. Thank you for choosing XXXX
            //Your SWDIGITALLIFE OPT Authentication Code is XXXXXX
            //Dear XXXX Thank you for choosing XXXX
            
            //echo $message;
            
            // filter msg
            $message = str_replace(' ', '%20', $message);
                       
            // set curl url
            $url = "http://59.162.167.52/api/MessageCompose?admin=t9infomedia@gmail.com&user=smart@t9.com:Prakash@1705&senderID=SWORLD&receipientno=$phone_no&msgtxt=$message&state=4";
                         
            // create curl resource 
            $ch = curl_init(); 

            // set url 
            curl_setopt($ch, CURLOPT_URL, $url); 

            //return the transfer as a string 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

            // $output contains the output string 
            $output = curl_exec($ch); 

            // close curl resource to free up system resources 
            curl_close($ch);
        }
	}
?>