<?

try
{
	$DEBUG = true;

	// Config
	require_once('configline/configline.php');
	$CL = new Z_CONFIGLINE();
	$CL->debug($DEBUG);
	$CL->file('core/lib/lib.cl');
	//print_r($CL);

	// Location
	require_once('location/location.php');
	$L = Z_LOCATION::init($CL->get('lib', 'location'));
	//$L->debug($DEBUG);
	//print_r($L);

	// DB
	require_once('mysql/mysql.php');
	$DB = new Z_MySQLs($CL->get('lib', 'mysql'));
	$DB->debug($DEBUG);
	//print_r($DB);
}
catch (Exception $e)
{
	print 'Lib error';
	exit;
}

?>