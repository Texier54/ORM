<?php 

	namespace SGBD;

	class Model {

		protected $attribut = [];

		public function __get($attr_name) {
	        if (isset($this->attribut[$attr_name]))
	            return $this->attribut[$attr_name];
	        else
	        {
				if(method_exists($this, $attr_name))
					return $this->$attr_name();
				else
				{
					$emess = __CLASS__ . ": unknown member $attr_name (__get)";
					throw new \Exception($emess);
				}
			}
	    }
    
    	public function __set($attr_name, $attr_val) {
    		$this->attribut[$attr_name]=$attr_val;
    	}


		public function __construct($tab=null) {
			if(isset($tab))
				$this->attribut = $tab;
		}

		public function delete() {

			if(isset($this->attribut[static::$primaryKey]))
			{
				$delete = \SGBD\Query::table(static::$table);
				$delete->where(static::$primaryKey, '=', $this->attribut[static::$primaryKey]);
				$delete->delete();
			}
		}

		public function insert() {

			$insert = \SGBD\Query::table(static::$table);
			$this->attribut[static::$primaryKey] = $insert->insert($this->attribut);

		}

		public static function all() {

			$all = \SGBD\Query::table(static::$table);
			$res = $all->get();

			for($i=0;$i<count($res);$i++)
				$obj[] = new static($res[$i]);

			return $obj;

		}

		public static function find($recherche, $colonnes=null) {

			$find = \SGBD\Query::table(static::$table);

			if($colonnes != null)
				$find->select($colonnes);

			if(is_array($recherche))

				if(is_array($recherche[0]))
					for($i=0; $i<count($recherche); $i++)
						$find->where($recherche[$i][0], $recherche[$i][1], $recherche[$i][2]);
				else
					$find->where($recherche[0], $recherche[1], $recherche[2]);

			else
				$find->where(static::$primaryKey, '=', $recherche);

			$res = $find->get();

			for($i=0;$i<count($res);$i++)
				$obj[] = new static($res[$i]);

			return $obj;
		}

		public static function first($recherche, $colonnes=null) {

			$find = \SGBD\Query::table(static::$table);

			if($colonnes != null)
				$find->select($colonnes);

			if(is_array($recherche))

				if(is_array($recherche[0]))
					for($i=0; $i<count($recherche); $i++)
						$find->where($recherche[$i][0], $recherche[$i][1], $recherche[$i][2]);
				else
					$find->where($recherche[0], $recherche[1], $recherche[2]);

			else
				$find->where(static::$primaryKey, '=', $recherche);

			$res = $find->get();

			return new static($res[0]);
		}

		public function belongs_to($modele, $id) {
			$belong = new $modele();
			return $belong->first([$belong::$primaryKey, '=', $this->attribut[$id]]);
		}
		
		public function has_many($modele, $id) {
			$many = new $modele();
			return $many->find([$id, '=', $this->attribut[$many::$primaryKey]]);
		}

	}