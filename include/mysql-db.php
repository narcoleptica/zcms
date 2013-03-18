<?

	// DB
	require_once('mysql.php');
	$DB = array(
			'SERVER' => 'localhost',
			'LOGIN' => 'zanner_bizpost', // 'bizpostc',
			'PASSWORD' => 'zanner_bizpostzanner_bizpost', // 'v&#Eg1uI_Duw',
			'HARDWIRED' => false,
			'FLAG' => null,
			'DATABASE' => 'zanner_bizpost', // 'bizpostc_db',
			'AUTOQUERY' => array('SET CHARACTER SET cp1251;', "SET NAMES 'cp1251';"),
			'CAST' => true,
			'DEBUG' => true,
			'SPEED' => false,
			'SPEED_SENSITIVITY' => 10
		);
	$DB = new Z_MySQLs($DB);

?>