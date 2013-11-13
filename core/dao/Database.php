<?php
class Database {
 	private static $dbLink;
	private static $server = "localhost";
	private static $user = "movielov_root";
	private static $password = "Lalith.123";
	private static $database = "movielov_video";
	
	private static $whitelist = array('localhost', '127.0.0.1');
	private static $localUser = "root";
	private static $localPassword = "root";
	private static $localDatabase = "video_vertex";

 	private static function instance() {
 		if (self::$dbLink == null) {
 			if(in_array($_SERVER['HTTP_HOST'], self::$whitelist)){
 				self::$dbLink = new mysqli(self::$server, self::$localUser, self::$localPassword, self::$localDatabase);
 			} else {
 				self::$dbLink = new mysqli(self::$server, self::$user, self::$password, self::$database);
 			}
		}
		return self::$dbLink;
	}

	public static function sql_query($sql) {
		$result = self::instance()->query($sql);
		return $result;
	}
}
?>