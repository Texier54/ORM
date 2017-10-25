<?php
	
	namespace SGBD;

	class Query extends \utils\ConnectionFactory{

		private $sqltable;
		private $fields = '*';
		private $where = null;
		private $args = [];
		private $sql = '';


		public static function table(string $table) {

			$query = new Query;
			$query->sqltable = $table;
			return $query;
		}

		public function where($col, $op, $val) {
			if($this->where == null)
				$this->where = 'WHERE '.$col.' '.$op.' ?';
			else
			{
				$this->where = $this->where.' AND WHERE '.$col.' '.$op.' ?';
			}
			$this->args[]=$val;
			return $this->where;
		}

		public function get() {
			$this->sql = 'SELECT '. $this->fields. ' FROM '. $this->sqltable. ' '.$this->where;

			$db = \utils\ConnectionFactory::makeConnection();
			$stmt = $db->prepare($this->sql);
			$stmt->execute($this->args);
			return $stmt->fetch();
		}

		public function select(array $fields) {

			$this->fields = implode( ',', $fields);
			return $this;
		}

		public function delete() {
			$this->sql = 'DELETE FROM '.$this->sqltable. ' '.$this->where;
			$db = \utils\ConnectionFactory::makeConnection();
			$stmt = $db->prepare($this->sql);
			$stmt->execute($this->args);
			return $this->sql;
		}

		public function insert(array $t) {

			foreach($t as $key => $attname)
			{
				$temp1[] = $key.' ';
				$sq[] = ' '.$attname.' ';
				$intero[] = '?';
			}

			$this->sql = 'INSERT INTO '.$this->sqltable. ' ('. implode(', ', $temp1) .') VALUES (' . implode(', ', $intero) .')';

			$db = \utils\ConnectionFactory::makeConnection();
			$stmt = $db->prepare($this->sql);
			$stmt->execute($sq);
			return $db->lastInsertId();
		}
	}