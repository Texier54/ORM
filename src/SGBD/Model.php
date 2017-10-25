<?php 

	namespace SGBD;

	class Model {

		protected $attribut = [];

		public function __get($attr_name) {
	        if (isset($this->attribut[$attr_name]))
	            return $this->attribut[$attr_name];
	        else
	        {
		        $emess = __CLASS__ . ": unknown member $attr_name (__get)";
		        throw new \Exception($emess);
			}
	    }
    
    	public function __set($attr_name, $attr_val) {
    		$this->attribut[$attr_name]=$attr_val;
    	}


		public function __construct($tab=null) {
			if(isset($tab))
				$attribut = $tab;
		}

		public function delete() {

			if(isset($this->attribut['id']))
			{
				$delete = \SGBD\Query::table($this->table);
				$delete->where('id', '=', $this->attribut[$this->primaryKey]);
				$delete->delete();
			}
		}

		public function insert() {

			$insert = \SGBD\Query::table($this->table);
			$this->$primaryKey = $insert->insert();

		}
	}