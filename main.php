<?php


	require_once('src/utils/ClassLoader.php');
	$loader = new utils\ClassLoader('src');
	$loader->register();


	utils\ConnectionFactory::setConfig('src/utils/config.ini');
	$db = utils\ConnectionFactory::makeConnection();


	$a = SGBD\Query::table('article');
	var_dump($a);
	echo '<br><br>';


	//echo $a->insert(['nom'=>'test1','descr'=>'qzfzqf','tarif'=>'20','id_categ'=>'1']);


foreach ($a->get() as $key => $value) {
		echo '<br>'.$key.' : '.$value;
};


	$art = new SGBD\Article;
	$art->id = 77;
	$art->delete();
