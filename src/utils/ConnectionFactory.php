<?php

	namespace utils;

	class ConnectionFactory
	{
		private static $config;
		private static $db;

		public static function setConfig($nom)
		{	
			self::$config = parse_ini_file($nom);
		}

		public static function makeConnection()
		{

			$host   = self::$config['host'];
			$user   = self::$config['user'];
			$pass    = self::$config['pass'];
			$base   = self::$config['base'];

			if(isset($db))
				return self::$db;

			try {
				self::$db = new \PDO('mysql:host='. $host .';dbname='. $base, $user, $pass);
			} catch (Exception $e) {
				die('Erreur : '. $e->getMessage());
			}

			return self::$db;	
		}
	}
	
