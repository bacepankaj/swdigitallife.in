<?
	/**
	* profile Controller Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class profile extends Controller {
		/**
		* __construct class initialization
		*
		* Function __construct
		* @author Susanta Das
		*/
		function __construct() {
			parent::__construct(true);

            // disable operation menu
            $this->view->operation_menu = array();
		}
		
		/**
		* Index
		*
		* Function index
		* @author Susanta Das
		*/
		function index(){
            // get user id
			$id = (isset($this->parameters['id']) ? $this->parameters['id'] : Session::get('user_id'));
            
            // get user_profile
            $profile = $this->model->get_user_details($id);
            
            // override user id
            $profile->id = $id;
            
            // assign view page
			$this->view->assign('profile', $profile);
            
            // render view page
			$this->view->display($this->view->template);
		}
        
        /**
		* Get Referal Details
		*
		* Function get_referal_details
		* @author Susanta Das
		*/
		function get_referal_details($referal_id){
            // get referal details
            $referal = $this->model->get_user_details($referal_id, false)->where_not_equal('id', Session::get('user_id'))->where_not_equal('reffered_by', Session::get('user_id'))->find_one();
            
            // return referal details
            echo json_encode(array('id'=>$referal->id, 'name'=>$referal->name));
        }
        
        /**
		* Get Referal Details
		*
		* Function get_referal_details
		* @author Susanta Das
		*/
		function avatar_update(){
            // extact the variables to memory
			extract($_POST);
									
			// get file object
			$file = $_FILES['avatar'];
								
			// move file to upload path
			move_uploaded_file($file['tmp_name'] , AVATAR_PATH.'/'.$file['name']);
			
			// generate large file thumbnail
			Image::thumbnail(AVATAR_PATH.'/'.$file['name'], AVATAR_PATH.'/'.$id.'.png', 256, 256);
						
			// remove original file
			unlink(AVATAR_PATH.'/'.$file['name']);
            
            // set avatar version
            $avatar_version = time();
            
            // get user rs and update avatar version
            $user = $this->model->use_table('user')->find_one($id);
            $user->avatar_version = $avatar_version;
            $user->save();           
			
			$result['status'] = 'OK';
			$result['message'] = 'Avatar changed successfully!';
			$result['url'] = AJAX_BASE_URL.'/'.AVATAR_PATH.'/'.$id.'.png?v='.$avatar_version;
			
			echo $result = json_encode($result);
        }
	}
?>