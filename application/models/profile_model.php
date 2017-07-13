<?
	/**
	* profile_model Model Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/	
	class profile_model extends Model {
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
		* submit profile
		*
		* Function submit
		* @author Susanta Das
		*/
		function submit(){
            // extract post data into memory
            extract($_POST);
            
            // get post data
            $data = $_POST;    
           
            // unset some data
            unset($data['csrfToken']);
            unset($data['returnUrl']);
            unset($data['tab']);            
            unset($data['id']);            
                        
            // update reffered_by
            if(isset($reffered_by))
            {
                // get user rs
                $user = $this->use_table('user')->find_one($id);
                $user->reffered_by = ((empty($reffered_by) || $id==$reffered_by) ? null : $reffered_by);
                $user->save();
                
                // unset reffered_by
                unset($data['reffered_by']);
            }
            
            // get user_profile rs
            $user_profile = $this->use_table('user_profile')->find_one($id);
            
            // if no profile found create it
            if(!is_object($user_profile))
            {
                $user_profile = $this->use_table('user_profile')->create();				
                $user_profile->id = $id;
            }
            
            if($tab!='bank_details'){ 
                // loop profile fields
                foreach($data as $field=>$value) 
                {
                    if($field=='dob' || $field=='nominee_dob')
                        $user_profile->{$field} = $this->functions->date_format($value, 'Y-m-d');
                    else
                        $user_profile->{$field} = $value;
                }
            }else{
                $user_profile->bank_details = json_encode($data);                
            }
            
            // save profile fields
            $user_profile->save();
                
            // redirect back to module
            $this->redirect(urldecode($returnUrl));
        }
        
        /**
		* Get User Details
		*
		* Function get_user_details
		* @author Susanta Das
		*/
		function get_user_details($id){
            // get user_profile
            $profile = $this->use_table('user')
                                        ->table_alias('u')
                                        ->select_many('up.*', 'u.*')
                                        ->select_expr("(SELECT user_name FROM user ru WHERE ru.id = u.reffered_by)", "refferal_id")
                                        ->select_expr("(SELECT name FROM user ru WHERE ru.id = u.reffered_by)", "refferal_name")
                                        ->left_outer_join('user_profile', array('u.id', '=', 'up.id'), 'up');                                        
           
            if(strlen($id)==36)         
                $profile = $profile->find_one($id);
            else
                $profile = $profile->where('user_name', $id)->find_one();
                       
            // return profile
            return $profile;
        }
	}
?>