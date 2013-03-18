<?

class Z_KERNEL
{
	// Флаг работы в режиме отладки: DEBUG
	const DEBUG = false;
	private static $DEBUG = self::DEBUG;
	final public static function debug($debug = null)
	{
		if ($debug === (bool)$debug) self::$DEBUG = (bool)$debug;
		return (bool)self::$DEBUG;
	}

	final static public function init($debug = null)
	{
		$__CLASS__ = __CLASS__;
		return new $__CLASS__($debug);
	}

	public $CONFIG = null;
	public $LOCATION = null;
	final private function __construct($debug = null)
	{
		$this->debug($debug);

		// Config
		require_once('configline/configline.php');
		$this->CONFIG = new Z_CONFIGLINE($this->debug(null));
		//print_r($this->CONFIG);

		// Location
		require_once('location/location.php');
		$this->LOCATION = Z_LOCATION::init();
		//print_r($this->LOCATION);

		//$this->CONFIG->file('core/lib/lib.zcfg');
		//$this->LOCATION->set($CL->get('lib', 'location'));
	}

	public function __destruct () {}

}

/*
try
{
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
	print 'Kernel error' . "\n" . $e->getMessage();
	exit;
}
*/
?>