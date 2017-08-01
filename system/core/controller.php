<?
	/**
	* Main Controller Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class MainController {
		/**
		* __construct class initialization
		*
		* Function __construct
		* @author Susanta Das
		*/
		function __construct($check_session=true) {
			//check session if exists
			if($check_session){Session::check_session();}
				
			//set view instance
			$this->view = new View();
			
			//get controller name
			$this->controller = CONTROLLER;
			
			//get method name
			$this->method = METHOD;
			
			//get controller parameters
			$this->parameters = json_decode(PARAMETERS, true);
			
			// get ajax true path 
			$this->ajax_url = rtrim(BASE_URL."/".CONTROLLER, '/');
									
			// define ajax url
			define ('AJAX_URL', $this->ajax_url);
			
			// assign ajax base url
			define ('AJAX_BASE_URL', rtrim(BASE_URL, '/'));
						
			// define model object
			$this->model = Model::use_model($this->controller);
			
			// define model object
			if($this->model->model_name=='MainModel')
			$this->model = new Model();
			
			// set function object from model
			$this->functions = $this->model->functions;

			// application debug
			if(APP_DEBUG){echo "<p>Controller Initialization - [$this->controller]</p>";}
		}
		
		/**
		* Default Controller Method
		*
		* Function index
		* @author Susanta Das
		*/
		function index() {							
			// view default template
			if(file_exists($this->view->view_path.'/'.$this->view->template)) 
			$this->view->display($this->view->dashboard_file);
		}
		
		/**
		* Submit Form Data
		*
		* Function submit	
		* @author Susanta Das
		*/
		function submit() {			
			// return url
            $return_url = urldecode($_POST['returnUrl']);
            
            // unset variables
            unset($_POST['csrfToken']);
            unset($_POST['returnUrl']);
            
            // submit data
            $this->model->submit($_POST, $return_url);		
		}		
		
		/**
		* Create Record
		*
		* Function create
		* @author Susanta Das
		*/
		function create() {			
			// view template
			if(file_exists($this->view->view_path.'/'.$this->view->template)) 
			$this->view->display($this->view->template);	
		}
		
		/**
		* View Record
		*
		* Function view
		* @author Susanta Das
		*/
		function view($rec_id=null) {													
			// call edit record
			call_user_func_array(array($this, 'edit'), $this->parameters);
		}
		
		/**
		* Edit Record
		*
		* Function edit
		* @author Susanta Das
		*/
		function edit($rec_id=null) {													
			if(!empty($rec_id))
			{
				// get model name
				$model_name = $this->model->model_name;
							
				// get record set
				$rs = $this->model->$model_name->find_one($rec_id);
				
				// assign recordset to view
				$this->view->assign($model_name, $rs);	
			}
						
			// view template
			if(file_exists($this->view->view_path.'/'.$this->view->template)) 
			$this->view->display($this->view->template);	
		}
		
		/**
		* Search Record
		*
		* Function search
		* @author Susanta Das
		*/
		function search() {													
			// assign search method
			$this->view->assign('search_method', 'data_grid');
						
			// view template			
			if(file_exists($this->view->view_path.'/search/search.html')) 
			$this->view->display('search/search.html');	
		}
		
		/**
		* Delete Record
		*
		* Function delete
		* @author Susanta Das
		*/
		function delete($rec_id=null, $confirm) {													
			// delete record message			
			if(!empty($rec_id))
			{				
				// get model name
				$model_name = $this->model->model_name;
							
				// get record set
				$rs = $this->model->$model_name;
				
				// delete the record
				if($this->model->permanent_delete)
					$rs->where($this->model->primary_key, $rec_id)->delete_many();
				else
				{					
					// get rec pointer
					$record = $rs->where($this->model->primary_key, $rec_id)->find_one();
					
					// get delete key
					$delete_key = $this->model->delete_key;
					
					// update the record
					$record->$delete_key = $this->model->delete_value;
					$record->save();
				}
				
				// after redirect redirect to search
				$this->redirect($this->controller.'/search');
			}	
		}
		
		/**
		* Search Deleted Record
		*
		* Function trash
		* @author Susanta Das
		*/
		function trash() {													
			// assign search method
			$this->view->assign('search_method', 'trash_grid');
						
			// view template			
			if(file_exists($this->view->view_path.'/search/search.html')) 
			$this->view->display('search/search.html');	
		}
				
		/**
		* jSON Data Grid - jsonGrid
		*
		* Function grid_search
		* @param $record_source as object
		* @param $options as array
		* @param $return as boolean
		* @returns jSon Data Output
		* @author Susanta Das
		*/		
		function grid_search($record_source, $options=null, $return=false){
			// get json xml data from recordset
			if($return)
				return $this->model->json->GridSearch($record_source, $_POST, $options);
			else
				echo $this->model->json->GridSearch($record_source, $_POST, $options);
		}
				
		/**
		* Redirect to given path
		*
		* Function redirect
		* @param $rediect_path as string
		* @returns none
		* @author Susanta Das
		*/
		public function redirect($rediect_path) {			
			if(trim(SERVER_PROTOCOL.'://'.$_SERVER['HTTP_HOST'].REQUEST_URI, '/') != trim(BASE_URL.'/'.$rediect_path, '/'))
			{	
				// redirect to given path
				header('Location: '.BASE_URL.'/'.$rediect_path);
			}
		}
		
		/**
		* Fetch Database Table Object
		*
		* Function column_data
		* @param $table as string
		* @param $id as string
		* @param $field as string
		* @param $key as string
		* @returns string
		* @author Susanta Das
		*/
		function column_data($table, $id, $field, $key='id'){			
			// return table field			
			return $this->model->column_data($table, $id, $field, $key);			
		}
        
        /**
		* Generate Json Dropdown
		*
		* Function json_dropdown
		* @param post data
		* @returns json data
		* @author Susanta Das
		*/
		function json_dropdown(){
			extract($_POST);
			
			// decode the html request
			$selected = html_entity_decode($selected);
			
			// get json array 
			$json_array = json_decode(stripslashes($selected), true);
						
			// get selected items as array
			foreach($json_array as $item)
			{
				$selected_items[] = $item['value'];
			}
										
			if($type=='record_master')// check if type is record master
			{
				// use sys_record_master table
				$this->model->use_table('sys_record_master');
			
				// get pick list from sys_pick_list_details table
				$record_master = $this->model->sys_record_master->where('del_flg', 0)->find_one($dropdown_id);
								
				// use table for table in record master
				$sys_table = $this->model->use_table($record_master->table_name);
				
				// get table join objects
				$table_join = json_decode($record_master->table_join);
								
				if(is_object($sys_table))
				{					
					// get pick list from record_master table
					if(strpos($record_master->field_caption, ',') !== false)
						$pick_list = $sys_table->select_many(array('id'=>$record_master->field_value))->select_expr('CONCAT(`'.str_replace(".", "`.`", str_replace(",", "`,' ',`", $record_master->field_caption)).'`)', 'value')->order_by_expr('CONCAT(`'.str_replace(".", "`.`", str_replace(",", "`,' ',`", $record_master->field_caption)).'`)');
					else
						$pick_list = $sys_table->select_many(array('id'=>$record_master->field_value), array('value'=>$record_master->field_caption))->order_by_asc($record_master->field_caption);						
				
					if($is_dependent)
						$pick_list = $pick_list->where_in($record_master->parent_ref_key, $selected_items);			
					else
					{
						if(!empty($selected_items[0]))		
						$pick_list = $pick_list->where_in($record_master->parent_ref_key, $selected_items);
					}					

					// prepare join query
					foreach($table_join as $join)
					{						
						$pick_list = $pick_list->join($join->table, array($join->on, '=', $join->equal), $join->table);
					}
					
					// check rs object
					if(is_object($pick_list))
					{
						// check custom condition
						if(!empty($record_master->condition))
						{
							// get condition variables
							preg_match_all('/{(.*?)\}/s', $record_master->condition, $condition_variables);
							
							// get condition variables
							foreach($condition_variables[1] as $i=>$variable)
							{
								// get statement
								$statement = $condition_variables[1][$i];	
								
								// evaluate statement
								eval("\$var = $statement;");
								
								// replace condition with condition variable
								$record_master->condition = str_replace($condition_variables[0][$i], $var, $record_master->condition);
							}
							
							// add custom condition
							$pick_list = $pick_list->where_raw($record_master->condition);
						}
						
						// execute the query				
						$pick_list = $pick_list->find_many();
					}
				}
			}
			else
			{
				// use pick_list_details table
				$this->model->use_table('pick_list_details');
			
				// get pick list from pick_list_details table
				$pick_list = $this->model->use_table('pick_list_details')->where('pick_list_id', $dropdown_id)->order_by_asc('caption');
								
				if($is_dependent)
					$pick_list = $pick_list->where_in('parent_id', $selected_items);			
				else
				{
					if(!empty($selected_items[0]))		
					$pick_list = $pick_list->where_in('parent_id', $selected_items);		
				}
				
				// check rs object
				if(is_object($pick_list))
				{
					// execute the query									
					$pick_list = $pick_list->find_many();
				}
			}
						
			if($pick_list->count() > 0)
			{
				// create array of pick list
				foreach($pick_list as $item)
				{
					if($type=='record_master')
						$options[$item->id] = $item->value;
					else
						$options[$item->value] = array('id'=>$item->id, 'value'=>$item->value);
				}
				
				// return json data
				echo json_encode($options);
			}
			else
				echo json_encode(array());
		}
	}
?>