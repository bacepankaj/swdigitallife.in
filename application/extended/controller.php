<?
	/**
	* Extends Main Controller Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class Controller extends MainController {
		/**
		* __construct class initialization
		*
		* Function __construct
		* @author Susanta Das
		*/
		function __construct($check_session=true, $check_privilege=true) {			
			parent::__construct($check_session);
			
			// check for user login status
			if(!($this->controller=='index' || $this->controller=='login' || $this->controller=='profile'  || $this->controller=='logout' || Session::get('is_admin')))
			{
				if(Session::get_state())
				{   
                    // get user_profile
                    $user_profile = $this->model->use_table('user_profile')->find_one(Session::get('user_id'));
                    
                    // check user profile not exists
                    if(!is_object($user_profile))
                    {
                       // redirect to profile pending is user is not active
                       $this->redirect('profile');
                    } 
                    							
					// redirect to account_activation_pending is user is not active
					//if($login_status=='Inactive')
					//$this->redirect('signup/account_activation_pending');
				}
			}
            
            // default module redirection after login	
			$redirect_to_after_login = Session::get('redirect_to_after_login');
							
			// get if empty
			if(empty($redirect_to_after_login))
				$this->redirect_to_after_login = REDIRECT_TO_AFTER_LOGIN;
			else
				$this->redirect_to_after_login = $redirect_to_after_login;
		}
        
        /**
		* Index
		*
		* Function index
		* @author Susanta Das
		*/
		function index(){
            // render view page
			$this->view->display(DASHBOARD_FILE);
		}
        
        /**
		* Dashboard
		*
		* Function dashboard
		* @author Susanta Das
		*/
		function dashboard(){
            // render view page
			$this->index();
		}
        
        /**
		* Search
		*
		* Function create
		* @author Susanta Das
		*/
		function search(){
            // render view page
			$this->view->display(SEARCH_FILE);
        }
        
        /**
		* Trash
		*
		* Function trash
		* @author Susanta Das
		*/
		function trash(){
            // render view page
            $this->search();
        }
	}
?>
