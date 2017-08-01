<?
	/**
	* pick_list Controller Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class pick_list extends Controller {
		/**
		* __construct class initialization
		*
		* Function __construct
		* @author Susanta Das
		*/
		function __construct() {
			parent::__construct(true);
            
            // get pick list
            $pick_list = $this->model->use_table('pick_list')->where('del_flg', 0)->order_by_asc('name')->find_many();
            
            // assign parent_list
            $this->view->assign('parent_list', $this->model->RStoArray($pick_list, 'name'));
		}
        
        function manage_list($id){
            // get pick_list
			$pick_list = $this->model->use_table('pick_list')->where('del_flg', 0)->find_one($id);	
			
			// assign tms_tasl rs object
			$this->view->assign('pick_list', $pick_list);
            
            // get pick list
            $pick_lists = $this->model->use_table('pick_list_details')->where('pick_list_id', $id)->order_by_asc('list_order')->find_many();
            
            // assign pick_lists
            $this->view->assign('pick_lists', $pick_lists);
            
            // get pick_list_details 
			$pick_list_details = $this->model->use_table('pick_list_details')->where('pick_list_id', $pick_list->parent_id)->where('del_flg', 0)->order_by_asc('list_order')->find_many();
			            
			// assign parent pick list
			$this->view->assign('parent_pick_list', $this->model->RStoArray($pick_list_details, 'caption', 'id'));	
			            
            // view template
            $this->view->display($this->view->template);
        }
        
		// save item
		function save_item($id=null){
			extract($_POST);
		
			if(empty($id))
			{
				$rs = $this->model->use_table('pick_list_details')->create();
				$id = $this->functions->uuid();
				$rs->id = $id;				
			}
			else
			{				
				$rs = $this->model->use_table('pick_list_details')->find_one($id);				
			}
			
			if(!empty($pick_list_id))
			$rs->pick_list_id = $pick_list_id;
			
			if(!empty($caption))
			$rs->caption = $caption;
		
			if(!empty($caption))
			$rs->value = $value;
			
			if(!(empty($parent_id) || $parent_id=='null'))
				$rs->parent_id = $parent_id;
			else
				$rs->parent_id = null;
					
			if(!empty($list_order))
			$rs->list_order = $list_order;
												
			// save to sys_form_builder_field table
			$rs->save();
			
			// return record id
			echo $id;
		}
		
		// arrange list order
		function list_order(){
			// get post data
            $data = $_POST;    
           
            // unset some data
            unset($data['csrfToken']);
            
            // reset list_order
            $list_order = 0;
			
            // loop lists
            foreach($data as $id=>$value)
			{
				// get id
				$list_id = $id.'-'.$value[0];
				                
				// get pick_list_details rs
				$rs = $this->model->use_table('pick_list_details')->find_one($list_id);
				
				// update field order
				$rs->list_order = ++$list_order;
			
				// save to sys_form_builder_field table
				$rs->save();				
			}			
		}
		
		// remove item
		function remove_field($id){
			// delete the record
			$this->model->use_table('pick_list_details')->where('id', $id)->delete_many();
		}
		
		// json data grid search
		//function record_search(){
		function search(){
			// use table
			$this->model->use_table('pick_list');
			
			// create the query recordset
			$recordset = $this->model->use_table('pick_list')->table_alias('ctable')			
				->select_many('ctable.id', 'name')
				->where('del_flg', 0)
				->order_by_asc('name')
                ->find_many();
                
            // assign recordset
			$this->view->assign('recordset', $recordset);	
			            
            // view template
            $this->view->display($this->view->search_file);
			
			// grid options
			/*$options = array(
				'primary_key'=>'id',
				'delete_table'=>'pick_list',
				'delete_permanent'=>true,
				'module_sharing_per'=>$this->user_access				
			);
					
			// fetch the records in grid
			$this->grid_search($recordset, $options);*/
		}
		
		// json trash grid search
		/*function trash_grid(){
			// use table
			$this->model->use_table('sys_pick_list');
			
			// create the query recordset
			$sys_pick_list = $this->model->sys_pick_list->table_alias('ctable')					
				->select_many('id', 'name')
				->where_raw("(sys_company_id = '".Session::get('company_id')."' OR sys_company_id IS NULL)")
				->where('del_flg', 1)
				->order_by_asc('name');
				
			// grid options
			$options = array(
				'primary_key'=>'id',
				'delete_table'=>'sys_pick_list',
				'delete_permanent'=>true,
			);
			
			// fetch the records in grid
			$this->grid_search($sys_pick_list, $options);
		}*/
	}
?>