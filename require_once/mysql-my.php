<?

require_once('mysql.php');
$DB = array(
		'server' => 'localhost',
		'login' => 'zanner_bizpost',  //bizpostc
		'password' => 'zanner_bizpostzanner_bizpost',  //v&#Eg1uI_Duw
		'hardwired' => false,
		'flag' => null,
		'database' => 'zanner_bizpost',  //bizpostc_db
		'autoquery' => array('SET CHARACTER SET cp1251;', "SET NAMES 'cp1251';"),
		'cast' => true,
		'debug' => true,
		'speed' => false,
		'speed_sensitivity' => 10
	);
$DB = new Z_MySQLs($DB);
//$DB->debug(true);
//print_r($DB);

?>