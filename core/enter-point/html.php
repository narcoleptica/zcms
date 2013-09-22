<?
header('Content-Type: text/plain');

try
{
	require_once('../kernel/kernel.php');
	$KERNEL = Z_KERNEL::init(true);
	print_r($KERNEL);
}
catch (Exception $e)
{
	print 'Kernel error' . "\n" . $e->getMessage();
	exit;
}

//require_once('lib/lib.php');
//$CONFIGLINE->file('/data/data-index.zcfg');
//print_r($CL);

#require_once('lib/location/location-my.php');
print "\n\n" . 'index.php' . "\n\n\n";

print '$_SERVER:' . "\n";
print_r($_SERVER);
print "\n\n";

print '$_GET:' . "\n";
print_r($_GET);
print "\n\n";

print '$_POST:' . "\n";
print_r($_POST);
print "\n\n";

print '$_ENV:' . "\n";
print_r($_ENV);
print "\n\n";

?>