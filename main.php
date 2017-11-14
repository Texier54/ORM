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

/*
foreach ($a->get() as $key => $value) {
		echo '<br>'.$key.' : '.$value;
}; */

	echo '<br>';

	$art = new SGBD\Article;
	$art->id = 72;
	$art->delete();

/*
	$art2 = new SGBD\Article;
	$art2->nom = 'test2';
	$art2->descr = 'test';
	$art2->tarif = 20;
	$art2->id_categ = 1;
	$art2->insert();
	echo '<br>'.$art2->id; */

	$liste = SGBD\Article::all();
	foreach ($liste as $article) print $article->nom;

	echo '<br>';

	$l = SGBD\Article::find(66, ['nom','tarif']);   
	$article = $l[0];
	print_r($article);

	echo '<br><br>';

	$l = SGBD\Article::find( ['tarif', '<=', 100 ], ['nom', 'tarif'] );
	print_r($l);

	echo '<br><br>';

	$l = SGBD\Article::find( [['nom','like','%velo%'],['tarif', '<=', 100 ]], ['nom', 'tarif'] );
	print_r($l);

	echo '<br><br>';

	$l = SGBD\Article::first(['tarif', '<=', 100 ]);   
	print_r($l);

	echo '<br><br>';

	$a=SGBD\Article::first(64);
	$categorie = $a->belongs_to('SGBD\Categorie', 'id_categ');
	print_r($categorie);
	
	echo '<br><br>';
	
	$m = SGBD\Categorie::first(1);
	$list_article = $m->has_many('SGBD\Article', 'id_categ') ;
	print_r($list_article);
		
	echo '<br><br>';
	
	$categorie = SGBD\Article::first(64)->categorie() ;
	print_r($categorie);
	
	echo '<br><br>';
	
	$list = SGBD\Categorie::first(1)->articles();
	print_r($list);
