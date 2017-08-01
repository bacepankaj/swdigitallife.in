<?
	/**
	* pick_list_model Model Class
	*
	* @link http://somnetics.in/
	* @copyright 2010-2011 Somnetics Pvt. Ltd.
	* @author Mouparna Das <mouparna.das@somnet.co.in>
	* @version 1.0.50
	*/	
	class pick_list_model extends Model {
		/**
		* __construct class initialization
		*
		* Function __construct
		* @author Mouparna Das
		*/
		function __construct() {			
			parent::__construct();	
		}
        
		function pick_list($name_id, $append_blank_option=true, $return_id=false, $parent_option=null, $selected_options=null){
			// get pick list details
			$pick_list_details = $this->use_table('pick_list')->table_alias('pl')->join('pick_list_details', array('pld.pick_list_id', '=', 'pl.id'), 'pld')->select_many('pld.id', 'pld.caption', 'pld.value')->where_raw("(pl.id = '$name_id' OR pl.name = '$name_id')")->order_by_asc('caption');
			
			// get parent options
			if(!empty($parent_option))
			$pick_list_details = $pick_list_details->where_raw("pld.parent_id = (select id from pick_list_details pldl where pldl.value = '$parent_option' or pldl.id = '$parent_option')");
			
			// find selected options
			if(!empty($selected_options))
			$pick_list_details = $pick_list_details->where_in('pld.id', $selected_options);	
			
			// find the options
			$pick_list_details = $pick_list_details->find_many();
								
			// default item
			if($append_blank_option)
			$pick_lists[''] = '&nbsp;';
			
			// loop lists items
			foreach($pick_list_details as $pick_list)
			{
				if($return_id)
					$pick_lists[$pick_list->id] = array('id'=>$pick_list->id, 'label'=>trim($pick_list->caption));
				else
					$pick_lists[trim($pick_list->value)] = array('id'=>$pick_list->id, 'label'=>trim($pick_list->caption));
			}
			
			// return picklist
			return $pick_lists;
		}
		
		function pick_list_info($id){
			// get pick list details
			return $this->use_table('pick_list_details')->find_one($id);
		}		
	}
?>