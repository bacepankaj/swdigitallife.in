<?	
	/**
	* Main Model Class
	*
	* @link http://orionsoft.co.in/
	* @copyright 2010-2011 Orion Software Pvt. Ltd.
	* @author Susanta Das <susanta.das@orionsoft.co.in>
	* @version 1.0.50
	*/
	class MainModel extends ORM {
		public $db;
		
		/**
		* __construct class initialization
		*
		* Function __construct
		* @author Susanta Das
		*/		
		function __construct() {						
			parent::__construct(null);
			
			//get controller name
			$this->controller = CONTROLLER;
			
			//get method name
			$this->method = METHOD;
			
			//get controller parameters
			$this->parameters = json_decode(PARAMETERS, true);
			
			//initiate function class
			$this->functions = new Functions();
		
			// define unique id for record
			$this->uuid = $this->functions->uuid();
			
			//get child class
			$this->child_class = get_called_class();
			
			// return false if method is Model Class
			if($this->child_class=='Model')
				$this->model_name = $this->controller;
			else			
				$this->model_name = str_replace('_model', '', $this->child_class);
			
			//create record set instance
			$this->recordset_instance($this->model_name);
						
			// application debug			
			if(APP_DEBUG){echo "<p>Model Initialization - [$this->model_name]</p>";}
		}

		/**
		* Use ORM Database Table
		*
		* Function use_table
		* @param $table_name as string
		* @returns object
		* @author Susanta Das
		*/
		public function use_table($table_name){
			// check if database is used
			if(APP_DATABASE && !empty($table_name))
			{	
				// default primary key
				$this->primary_key = 'id';
				
				// default delete permanent
				$this->permanent_delete = false;
				
				// default delete key
				$this->delete_key = 'del_flg';
				
				// default delete value
				$this->delete_value = 1;
				
				// default restore value
				$this->restore_value = 0;
				
				// set database record set name
				$this->$table_name = ORM::for_table($table_name);
						
				// create a pdo instance from orm class
				$this->db = ORM::$_db['default'];
				
				// check table exists
				$table_exists = $this->db->query("SHOW TABLES LIKE '$table_name'")->rowCount();
				
				// if table not exist dont create db instance
				if($table_exists==0){return false;}
				
				// application debug
				if(APP_DEBUG){echo "<p>Use Table - [$table_name]</p>";}
					
				// return table recordset object
				return $this->$table_name;
			}
		}
		
		/**
		* ORM Get Last Query
		*
		* Function DBQuery
		* @returns string
		* @author Susanta Das
		*/
		function DBQuery(){
			echo ORM::get_last_query();
		}
		
		/**
		* Create ORM Recordset Instance
		*
		* Function recordset_instance
		* @param $model_name as string
		* @returns object
		* @author Susanta Das
		*/
		protected function recordset_instance($model_name){
			self::use_table($model_name);
		}
		
		/**
		* Initiate Model Object
		*
		* Function use_model
		* @param $model_name as string
		* @returns object
		* @author Susanta Das
		*/
		public static function use_model($model_name){							
			// set model path
			$model_path = 'application/models/'.$model_name.'_model.php';
			
			// get model class name
			$model_class = $model_name."_model";
			
			// check file exists
			if(file_exists($model_path)){			
				// include model file				
				require_once $model_path;
				
				if(class_exists($model_class))
				{					
					// application debug
					if(APP_DEBUG){echo "<p>Use Model Class - [$model_class]</p>";}
					
					// construct model class
					return new $model_class();										
				}	
				else 
					return new self();	
			}
			else
				return new self();									
		}
		
		/**
		* Create Recordset to Array
		*
		* Function RStoArray
		* @param $rs_object as orm object
		* @param $array_value as orm fields
		* @param $array_key as orm fields
		* @returns array
		* @author Susanta Das
		*/
		public function RStoArray($rs_object, $value_field=null, $key_field=null){
			// loop the object to to get fields
			foreach($rs_object as $rs_field)
			{				
				// check if the value field is array
				if(is_array($value_field))
				{
					// loop for the array field value
					$_value_field = null;
					foreach($value_field as $field)
					{
						if(isset($rs_field->$field))
							$_value_field .= trim($rs_field->$field);
						else
							$_value_field .= $field;
					}
				}
				else
					$_value_field = trim($rs_field->$value_field);
				
				// check if key is not empty or not
				if(!empty($key_field))
					$fieldset[$rs_field->$key_field] = trim($_value_field);
				else
					$fieldset[] = trim($_value_field);
			}
			
			// return the array
			return $fieldset;
		}
		
		/**
		* Form Data Submit Record 
		*
		* Function submit_record
		* @author Susanta Das
		* @param $data as array
		* @param $redirect_path as string
		*/
		public function submit($data, $redirect_path=null) {
			// get model name
			$model = $this->model_name;
			
			// check if record is empty for new record creation else update record
			if(empty($data['id']))
			{
				$model_rs = $this->$model->create();
				$model_rs->id = $this->uuid;
			}
			else
				$model_rs = $this->$model->find_one($data['id']);
			
			// loop the form variables
			foreach($data as $field=>$value)
			{
				if($field!='id')
				{
					if(!is_array($value))
						$model_rs->$field = trim($value);				
					else
						$model_rs->$field = implode(',', $value);									
				}
			}
			
			// save the record
			$model_rs->save();
			
			// redirect to search page
			if(!empty($redirect_path))
				$this->redirect($redirect_path);
			else
				$this->redirect($this->controller.'/search');
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
		* @param $field as string / array
		* @param $key as string default id
		* @returns string
		* @author Susanta Das
		*/
		function column_data($table, $id, $fields, $key='id'){
			// check if database is used
			if(APP_DATABASE)
			{
				// get table object
				$table_obj = ORM::for_table($table);
				
				// get table rs
				$rs = $table_obj->where($key, $id)->find_one();
								
				// return table field			
				if(is_array($fields))
				{				
					// loop for the array field value
					$value = null;
					foreach($fields as $field)
					{
						if(isset($rs->$field))
							$value .= trim($rs->$field);
						else
							$value .= $field;
					}
				}
				else
					$value = $rs->$fields;
							
				return trim($value);
			}
		}
	}
?>