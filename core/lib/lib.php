<?

try
{
	$DEBUG = true;

	// Config
	require_once('configline/configline.php');
	$CL = new Z_CONFIGLINE();
	$CONFIGLINE = &$CL;
	$CL->debug($DEBUG);
	$CL->file('core/lib/lib.zcfg');
	//print_r($CL);

	// Location
	require_once('location/location.php');
	$L = Z_LOCATION::init($CL->get('lib', 'location'));
	$LOCATION = &$L;
	//$L->debug($DEBUG);
	//print_r($L);

	// DB
	require_once('mysql/mysql.php');
	$DB = new Z_MySQLs($CL->get('lib', 'mysql'));
	$DATABASE = &$DB;
	$MYSQL = &$DB;
	$DB->debug($DEBUG);
	//print_r($DB);
}
catch (Exception $e)
{
	print 'Lib error' . "\n" . $e->getMessage();
	exit;
}

?>