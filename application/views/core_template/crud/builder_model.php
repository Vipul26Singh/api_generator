{php_open_tag}
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_{table_name} extends MY_Model {

	<?php $field_in_column = $this->crud_builder->getFieldShowInColumn(); 
	?>
	<?php if(!empty($primary_key)) { ?>
private $primary_key 	= '{primary_key}';
	<?php } else { ?>
		private $primary_key    = NULL;
	<?php } ?>
	private $table_name 	= '{table_name}';
	private $field_search 	= ['<?= implode("', '", $field_in_column); ?>'];
	private $user_restriction = '{user_restriction}';
<?php $search_type_array = 'array(' ; 
	 	foreach ($this->crud_builder->getFieldShowInAddForm(true) as $input => $option) { 
			 $search_type_array .= '"'.$input.'" => "'.$option['input_type'].'",' ;
	 	} 
		$search_type_array = rtrim($search_type_array,",");		
		$search_type_array .= ')' ; 
?>
	private $field_search_type = <?= $search_type_array ?>;
	private $export_select_string = '';

	public function __construct()
	{
		$this->export_select_string = $this->get_export_select_string();
		$config = array(
			'primary_key' 	=> $this->primary_key,
		 	'table_name' 	=> $this->table_name,
		 	'field_search' 	=> $this->field_search,
			'user_restriction' => $this->user_restriction,
			'export_select_string' => $this->export_select_string,
			'field_search_type' => $this->field_search_type,
		 );

		parent::__construct($config);
	}

		public function select_string() {
			$select_string = '';
			<?php
                        	foreach ($this->crud_builder->getFieldRelation() as $field => $join) {
			?>

			$select_string .= "tab_<?=$field?>.<?=$join['relation_value']?> as tab_<?=$field?>_value, tab_<?=$field?>.<?=$join['relation_label']?> as tab_<?=$field?>_label,"	;
			<?php } ?>
			$select_string .= "{table_name}.*";
			$this->db->select($select_string, FALSE);
			return $this;
		}

		public function get_export_select_string() {
			$select_string = '';
                        <?php
				$i = 0;
				foreach ($this->crud_builder->getExportableField(true) as $input => $option) {
					if(empty($option['relation_table'])) {
			?>
			$select_string .= "<?= $input ?> as `<?= $option['label'] ?>`,";
			<?php
					} else {
					$i++;
                        ?>
                        $select_string .= " (select relt<?= $i ?>.<?= $option['relation_label'] ?> from <?= $option['relation_table'] ?> relt<?= $i ?> where relt<?= $i ?>.<?= $option['relation_value'] ?> = {table_name}.<?= $input ?> ) as `<?= $option['label']?>`,";
                        <?php 
					} 
				}?>
			$select_string = rtrim($select_string, ",");
			
                        return $select_string;	
		}

	public function count_all($q = null, $field = null)
	{
		$iterasi = 1;
		$num = count($this->field_search);
		$where = NULL;
		$q = $this->scurity($q);
		$field = $this->scurity($field);


		if (!empty($field)) {
				$where .= "(" . "{table_name}.".$field . " LIKE '%" . $q . "%' )";
		}

	        $search = $this->search_filter();

                if(!empty($search)) {
                        if(!empty($where)) {
                                $where .= " and ";
                        }
                        $where .= $search ;
                }

                if($this->apply_user_filter()) {
                        if(!empty($where)) {
                                $where .= " and ";
                        }

                        $where .= " {table_name}.created_by = {$this->aauth->get_user_id()} ";
                }


		$this->join_avaiable();

		if(!empty($where)) {
			$this->db->where($where);
		}

		$query = $this->db->get($this->table_name);

		return $query->num_rows();
	}

	public function get($q = null, $field = null, $limit = 0, $offset = 0, $select_field = [])
	{
		$iterasi = 1;
		$num = count($this->field_search);
		$where = NULL;
		$q = $this->scurity($q);
		$field = $this->scurity($field);

		if( !empty($field) ) {
                                $where .= "(" . "{table_name}.".$field . " LIKE '%" . $q . "%' )";
                }

                $search = $this->search_filter();
		$this->select_string();

                if(!empty($search)) {
                        if(!empty($where)) {
                                $where .= " and ";
                        }
                        $where .= $search ;
                }

                if($this->apply_user_filter()) {
                        if(!empty($where)) {
                                $where .= " and ";
                        }

                        $where .= " {table_name}.created_by = {$this->aauth->get_user_id()} ";

                }

                if (is_array($select_field) AND count($select_field)) {
                        $this->db->select($select_field);
                }

		$this->join_avaiable();
	
		if(!empty($where)) {
			$this->db->where($where);
		}

		$this->db->limit($limit, $offset);
		<?php 	if(!empty($primary_key)) { ?>
			$this->db->order_by('{table_name}.'.$this->primary_key, "DESC");
			<?php } ?>
				$query = $this->db->get($this->table_name);

			return $query->result();
	}

	public function join_avaiable() {
		<?php
			foreach ($this->crud_builder->getFieldRelation() as $field => $join): 
			?>
			$this->db->join('<?= $join['relation_table'] ; ?><?= ' tab_'.$field  ; ?>', '<?=  'tab_'.$field ; ?>.<?= $join['relation_value']; ?> = {table_name}.<?= $field; ?>', 'LEFT');
		<?php endforeach; ?>

			return $this;
	}

}

/* End of file Model_{table_name}.php */
/* Location: ./application/models/Model_{table_name}.php */
