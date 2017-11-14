<?php

	namespace SGBD;
	
	class Article extends Model {

		protected static $table = 'article';
		protected static $primaryKey = 'id';
		
		public function categorie() {
			return $this->belongs_to('SGBD\Categorie', 'id_categ');
		}
	}