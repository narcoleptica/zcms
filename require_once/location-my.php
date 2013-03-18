<?

require_once('location.php');
$LOCATION = array(
		'method' => null,
		'domain' => null,
		'request' => null,
		'query-' => null,
		'post-' => null,
		'anchor' => null
	);
$LOCATION = &Z_LOCATION::init($LOCATION);
$L = &$LOCATION;
//$L->debug(true);
//print_r($L);

?>