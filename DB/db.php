<?php
class Db {
	static private $_instance;//单例模式
	static private $_connectSource;
	private $_dbConfig = array(
		'host' => 'localhost',
		'user' => 'root',
		'password' => '',
		'database' => 'balance_sheet'

		);
	private function __construct(){

	}
	static public function getInstance(){
		if(!(self::$_instance instanceof self)){
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function connect(){
		if(!self::$_connectSource){
			self::$_connectSource = mysql_connect($this->_dbConfig['host'], $this->_dbConfig['user'], $this->_dbConfig['password']);

			if(!self::$_connectSource) {
				// die('mysql connect error' . mysql_error());
				throw new Exception('mysql connect error' . mysql_error());
			}

			mysql_select_db($this->_dbConfig['database'], self::$_connectSource);
			mysql_query("set names UTF8", self::$_connectSource);
		}

		return self::$_connectSource;

	}



}

/*$connect = Db::getInstance()->connect();

$sql = "select * from balanceSheetTotal";
$result = mysql_query($sql, $connect);//结果集
echo mysql_num_rows($result);

var_dump($result);*/




?>