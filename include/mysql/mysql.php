<?

// обертка на стандартные функции СУБД MySQL
// класс работы с конкретным соединением СУБД MySQL
class Z_MySQL_SINGLE
{
	const VESION = '1.2.0';
	final public static function version() { return self::VESION; }

/** /
	(bool) debug((bool) $debug = null)
	(array) autoquery()
	(string) datbase()
	(string) db()
	(int) flag()
	(bool) hardwired()
	(string) host()
	(resource) link()
	(string) login()
	(string) password()
	(string) server()
	(string) user()
	(bool) speed((bool) $speed = null)
	(int) speed_sensitivity((int) $sensibility = null)
	(array | bool | int | string) fetch_field((resource) $result, (int) $offset = null, (string) $key = null)
	(array) fetch_lengths((resource) $result)
	(string) field_flags((resource) $result, (int) $offset)
	(int) field_length((resource) $result, (int) $offset)
	(string) field_name((resource) $result, (int) $index)
	(array) field_seek((resource) $result, (int) $offset)
	(string) field_table((resource) $result, (int) $offset)
	(string) field_type((resource) $result, (int) $offset)
	(string) get_client_info()
	(string) get_host_info()
	(int) get_proto_info()
	(string) get_server_info()
	(string) info()
	(int) insert_id()
	(bool) ping()
	(bool | mixed | null | string) result((resource) $result, (int) $row = 0, (int | string) $field = null)
	(int) thread_id()

	(int) affected()
	(bool) close()
	(bool) connect((string) $server = null, (string) $login = null, (string) $password = null, (bool) $new = null, (int) $flag = null)
	(bool) db_create((string) $db)
	(bool) db_drop((string) $db)
	(resource) db_list()
	(string) db_name((resource) $result, (int) $row, (int | string) $field)
	(bool | null | resource) db_query((string) $query, (string) $db = null)
	(bool) db_select((string) $db)
	(bool) disconnect()
	(string) encoding()
	(string) error()
	(int) errorN()
	(array | bool | object) fetch((resource) $result, (int | string) $type = null)
	(int) fields((resource) $result)
	(resource) fields_list((string) $db, (string) $table)
	(string) last_id()
	(bool) open((string) $server = null, (string) $login = null, (string) $password = null, (bool) $new = null, (int) $flags = null, (string) $db = null, (string | array) $query = null)
	(bool) pconnect((string) $server = null, (string) $login = null, (string) $password = null, (int) $flag = null)
	(resource) processes_list()
	(bool | null | resource) query((string) $query)
	(string) quote((string) $string = '', (int) $mask = 0)
	(string) quote_real((string) $string = '', (int) $mask = 0)
	(bool) relogin((string) $login = null, (string) $password = null, (string) $db = null)
	(bool) result_free((resource) $result)
	(bool) result_seek((resource) $result, (int) $row)
	(int) rows((resource) $result)
	(array) state()
	(resource) table_list((string) $db)
	(string) table_name((resource) $result, (int) $index)
	(bool | null | resource) uquery((string) $query)

	(bool) cast((bool) $cast = null)
	(bool) free((resource) $result)
	(array | bool | object) all((resource) $result, (int | string) $type = null, (int | string) $field = null, (int | string) $key = null)
	(bool | double | int | string) one((resource) $result, (int) $row = null, (int | string) $field = null)
	(bool | int) rall((resource) $result, (string | array) $call, (int | string) $type = null, (mixed) $cdata = null)
	(array | bool | double | int | object | string) row((resource) $result, (int | string) $type = null, (int | string) $field = null)

	(array | bool | object) query_all((string) $query = null, (int | string) $type = null, (int | string) $field = null, (int | string) $key = null)
	(bool | double | int | string) query_one((string) $query = null, (int) $row = null, (int | string) $field = null)
	(bool | int) query_rall((string) $query = null, (string) $call = null, (int | string) $type = null, (mixed) $cdata = null)
	(array | bool | double | int | object | string) query_row((string) $query = null, (int | string) $type = null, (int | string) $field = null)
	(bool | double) query_speed()

	(bool | null | resource) q((string) $query = null)
	(array | bool | object) q_all((string) $query = null, (int | string) $type = null, (int | string) $field = null, (int | string) $key = null)
	(bool | double | int | string) q_one((string) $query = null, (int) $row = null, (int | string) $field = null)
	(bool | int) q_rall((string) $query = null, (string) $call = null, (int | string) $type = null, (mixed) $cdata = null)
	(array | bool | double | int | object | string) q_row((string) $query = null, (int | string) $type = null, (int | string) $field = null)
	(bool | double) q_speed()

	(bool | double | int | string) q0((string) $query = null, (int) $row = null, (int | string) $field = null)
	(array | bool | double | int | object | string) q1((string) $query = null, (int | string) $type = null, (int | string) $field = null)
	(array | bool | object) q2((string) $query = null, (int | string) $type = null, (int | string) $field = null, (int | string) $key = null)
	(bool | int) q3((string) $query = null, (string) $call = null, (int | string) $type = null, (mixed) $cdata = null)

	(array | bool | object) uquery_all((string) $query = null, (int | string) $type = null, (int | string) $field = null, (int | string) $key = null)
	(bool | int) uquery_rall((string) $query = null, (string) $call = null, (int | string) $type = null, (mixed) $cdata = null)
	(array | bool | double | int | object | string) uquery_row((string) $query = null, (int | string) $type = null, (int | string) $field = null)
	(bool | double) uquery_speed()

	(bool | null | resource) u((string) $query = null)
	(array | bool | object) u_all((string) $query = null, (int | string) $type = null, (int | string) $field = null, (int | string) $key = null)
	(bool | int) u_rall((string) $query = null, (string) $call = null, (int | string) $type = null, (mixed) $cdata = null)
	(array | bool | double | int | object | string) u_row((string) $query = null, (int | string) $type = null, (int | string) $field = null)
	(bool | double) u_speed()

	(array | bool | double | int | object | string) u1((string) $query = null, (int | string) $type = null, (int | string) $field = null)
	(array | bool | object) u2((string) $query = null, (int | string) $type = null, (int | string) $field = null, (int | string) $key = null)
	(bool | int) u3((string) $query = null, (string) $call = null, (int | string) $type = null, (mixed) $cdata = null)

	(void) __construct((bool | null) $debug = null, (array | null) $data = null)
	$data:
		AUTOQUERY = { 'AUTOQUERY' | 'QUERY' | 'AUTO' | 'AQ' | 'Q' | 6 } => (array | string | null)
		DATABASE = { 'DATABASE' | 'DB' | 'D' | 'BASE' | 'B' | 5 } => (string | 'mysql')
		FLAG = { 'FLAG' | 'F' | 4 } => (int | null)
		HARDWIRED = { 'HARDWIRED' | 'NEW' | 3 } => (string | bool | null)
		LOGIN = { 'LOGIN' | 'L' | 'USER' | 'U' | 1 } => (string | 'root')
		PASSWORD = { 'PASSWORD' | 'PASS' | 'PWD' | 'P' | 2 } => (string)
		SERVER = { 'SERVER' | 'SRV' | 'HOST' | 0 } => (string | 'localhost')
	(void) __destruct()
	(void) __clone()
	(void) __sleep()
	(void) __wakeup()
	(string) __toString()
/**/

	// Параменты по умолчанию из php.ini
	final private static function ini_allow_persistent() { return (bool)preg_match('"^(?:on|1)$"iu', (string)ini_get('allow_persistent')); }

	final private static function ini_connect_timeout($default = 30)
	{
		$timeout = (string)ini_get('connect_timeout');
		return (int)(preg_match('"^(?>[\d]+)$"u', $timeout) ? $timeout : $default);
	}

	final private static function ini_default_login($default = 'root')
	{
		$user = (string)ini_get('default_user');
		return (string)(preg_match('"^(?>[\w]+)$"u', $user) ? $user : $default);
	}

	final private static function ini_default_password($default = '1')
	{
		$password = (string)ini_get('default_password');
		return (string)(preg_match('"^(?>.+)$"u', $password) ? $password : $default);
	}

	final private static function ini_default_port($default = 3306)
	{
		$port = (string)ini_get('default_port');
		return (int)(preg_match('"^(?>[\d]+)$"u', $port) ? $port : $default);
	}

	final private static function ini_default_server($default = 'localhost')
	{
		$host = (string)ini_get('default_host');
		return (string)(preg_match('"^(?>[\w\d\.\-\_\:\@\/]+)$"u', $host) ? $host : $default);
	}

	final private static function ini_default_socket($default = '')
	{
		$socket = (string)ini_get('default_socket');
		return (string)(preg_match('"^(?>.+)$"u', $socket) ? $socket : $default);
	}

	final private static function ini_max_links($default = -1)
	{
		$links = (string)ini_get('max_links');
		return (int)(preg_match('"^[\-]?(?>[\d]+)$"u', $links) ? $links : $default);
	}

	final private static function ini_max_persistent($default = -1)
	{
		$persistent = (string)ini_get('max_persistent');
		return (int)(preg_match('"^[\-]?(?>[\d]+)$"u', $persistent) ? $persistent : $default);
	}

	final private static function ini_safe_mode() { return (bool)preg_match('"^(?:on|1)$"iu', (string)ini_get('safe_mode')); }

	final private static function ini_trace_mode() { return (bool)preg_match('"^(?:on|1)$"iu', (string)ini_get('trace_mode')); }


	// Проверяет загружено ли расширение PHP для работы MySQL, если нет, то пытается подгрузить его.
	final private function extension_loaded()
	{
		static $return = null;
		if ($return === null)
		{
			if (extension_loaded('mysql')) $return = true;
			elseif (ini_safe_mode()) $return = false; // если safe_mode, то подгрузка невозможна
			else $return = dl(preg_match('"WIN"i', PHP_OS) ? 'php_mysql.dll' : 'mysql.so') ? true : false;
		}
		return $return;
	}


	// Флаг работы в режиме отладки: DEBUG
	const DEBUG = false;

	private $DEBUG = self::DEBUG;

	final public function  debug($debug = null)
	{
		if ($debug === (bool)$debug) $this->DEBUG = (bool)$debug;
		return (bool)$this->DEBUG;
	}


	// Параметры соединения
	private $AUTOQUERY = array();
	private $DATABASE = null;
	private $FLAG = null;
	private $HARDWIRED = null;
	private $IS_NEW = null;
	private $LINK = null;
	private $LOGIN = null;
	private $PASSWORD = null;
	private $SERVER = null;

	final public function  autoquery() { return $this->AUTOQUERY; }

	final public function  database() { return $this->DATABASE; }

	final public function  db() { return $this->DATABASE; }

	final public function  flag() { return $this->FLAG; }

	final public function  hardwired() { return $this->HARDWIRED; }

	final public function  host() { return $this->SERVER; }

	final public function  is_new() { return $this->IS_NEW; }

	final public function  link() { return $this->LINK; }

	final public function  login() { return $this->LOGIN; }

	final public function  password() { return $this->PASSWORD; }

	final public function  server() { return $this->SERVER; }

	final public function  user() { return $this->LOGIN; }


	// Флаг работы механизма замера скорости
	const SPEED = false;

	private $SPEED = self::SPEED;

	final public function  speed($speed = null)
	{
		if ($speed === (bool)$speed) $this->SPEED = (bool)$speed;
		return (bool)$this->SPEED;
	}


	// точность = кол-во знаков после запятой
	const SPEED_SENSITIVITY = 8;

	private $SPEED_SENSITIVITY = self::SPEED_SENSITIVITY;

	final public function  speed_sensitivity($sensibility = null)
	{
		if (((int)$sensibility >= 0) && ((int)$sensibility <= 20)) $this->SPEED_SENSITIVITY = (int)$sensibility;
		return (int)$this->SPEED_SENSITIVITY;
	}


	// Замер скорости выполнения
	final private static function _speed_locate()
	{
		list($micro_seconds, $seconds) = explode(' ', microtime());
		return array((double)$seconds, (double)$micro_seconds);
	}

	final private static function _speed_locate_duration($locate = null, $sensibility = 0)
	{
		$n = self::_speed_locate();
		$l = isset($locate[0], $locate[1]) ? array((double)$locate[0], (double)$locate[1]) : $n;
		return ($n[0] - $l[0]) + (double)preg_replace('"^((?>[\d]+))(?:([\.\,])([\d]{0,' . $sensibility . '}))?.*$"', '$1$2$3', (string)($n[1] - $l[1]));
	}

	private $SPEED_LOCATE = false; // последнее засеченное время
	private $SPEED_DURATION = false; // длительность выполенения последнего запроса

	final private function speed_duration() { return $this->SPEED_DURATION; }

	final private function speed_locate() { $this->SPEED_DURATION = false; $this->SPEED_LOCATE = $this->speed() ? self::_speed_locate() : false; }

	final private function speed_locate_duration() { $this->SPEED_DURATION = $this->speed() && $this->SPEED_LOCATE ? self::_speed_locate_duration($this->SPEED_LOCATE, $this->SPEED_SENSITIVITY) : false; }


	// Вызывает функцию или метод с параметрами.
	final private function call($call, $data = null, $default = false)
	{
		if (!$this->extension_loaded()) return $default;
		$call = (string)$call;
		$data = is_array($data) ? $data : array($data);
		return $this->debug() ? call_user_func_array($call, $data) : @call_user_func_array($call, $data);
	}


	// mysql_affected_rows -- Возвращает число затронуиых прошлой операцией рядов.
	// int ( resource link_identifier )
	final private function affected_rows() { return is_resource($this->link()) ? $this->call('mysql_affected_rows', $this->link(), 0) : 0; }


	// mysql_change_user --  Изменяет пользователя для указанного соединения.
	// bool ( string user, string password, string database, resource link_identifier )
	final private function change_user($login = null, $password = null, $db = null)
	{
		$login = is_string($login) ? (string)$login : $this->login();
		$password = is_string($password) ? (string)$password : $this->password();
		$db = is_string($db) ? (string)$db : $this->db();
		$return = is_resource($this->link()) && $db ? $this->call('mysql_change_user', array($login, $password, $db, $this->link()), false) : false;
		if ($return)
		{
			$this->LOGIN = $login;
			$this->PASSWORD = $password;
			$this->DATABASE = $db;
		}
		return $return;
	}


	// mysql_client_encoding -- Возвращает кодировку соединения.
	// string ( resource link_identifier )
	final private function client_encoding() { return is_resource($this->link()) ? $this->call('mysql_client_encoding', $this->link(), '') : ''; }


	// mysql_close -- Закрывает соединение с сервером MySQL.
	// bool ( resource link_identifier )
	final private function closing()
	{
		if (is_resource($this->link()))
		{
			$return = $this->call('mysql_close', $this->link(), false);
			$this->AUTOQUERY = array();
			$this->DATABASE = $this->FLAG = $this->HARDWIRED = $this->IS_NEW = $this->LINK = $this->LOGIN = $this->PASSWORD = $this->SERVER = null;
			return $return;
		}
		else $return = null;
		return $return;
	}


	const COMPRESS = MYSQL_CLIENT_COMPRESS;
	const INTERACTIVE = MYSQL_CLIENT_INTERACTIVE;
	const SPACE = MYSQL_CLIENT_IGNORE_SPACE;

	// Открывает соединение с сервером MySQL.
	// resource mysql_connect ( string host, string username, string password, bool new_link [ , int client_flags ] )
	// client_flags = { MYSQL_CLIENT_COMPRESS | MYSQL_CLIENT_IGNORE_SPACE | MYSQL_CLIENT_INTERACTIVE }
	final private function connecting($server = null, $login = null, $password = null, $new = null, $flag = null)
	{
		if (is_resource($this->link()))
		{
			if ($new === true) $this->closing();
			else return true;
		}
		if (is_string($server)) $server = (string)$server;
		elseif (is_array($server) && isset($server[0], $server[1])) $server = sprintf('%s:%s', $server[0], $server[1]);
		else $server = sprintf('%s:%s', $this->ini_default_server(), $this->ini_default_port());
		$login = is_string($login) ? (string)$login : $this->ini_default_login();
		$password = is_string($password) ? (string)$password : $this->ini_default_password();
		$new = ($new === (bool)$new) ? $new : true;
		static $FLAGS = array('COMPRESS' => self::COMPRESS, 'SPACE' => self::SPACE, 'INTERACTIVE' => self::INTERACTIVE);
		$FLAGS_ALL = $FLAGS['COMPRESS'] | $FLAGS['SPACE'] | $FLAGS['INTERACTIVE'];
		$FLAGS_DEFAULT = $FLAGS['COMPRESS'] | $FLAGS['SPACE'];
		$flag = (int)(is_int($flag) && ($flag & $FLAGS_ALL) ? ($flag & $FLAGS_ALL) : $FLAGS_DEFAULT);
		$link = $this->call('mysql_connect', array($server, $login, $password, $new, $flag), false);
		if (is_resource($link))
		{
			$this->AUTOQUERY = array();
			$this->DATABASE = null;
			$this->FLAG = $flag;
			$this->HARDWIRED = false;
			$this->IS_NEW = $new;
			$this->LINK = $link;
			$this->LOGIN = $login;
			$this->PASSWORD = $password;
			$this->SERVER = $server;
			return true;
		}
		else return false;
	}


	// Создаёт базу данных MySQL.
	// bool mysql_create_db ( string database_name, resource link_identifier )
	final private function create_db($db)
	{
		$db = (string)$db;
		return is_resource($this->link()) ? $this->call('mysql_create_db', array($db, $this->link()), false) : false;
	}


	// Перемещает внутренний указатель в результате запроса.
	// bool mysql_data_seek ( resource result_identifier, int row_number = [0, mysql_num_rows) )
	final private function data_seek($result, $row)
	{
		$row = (int)$row;
		return is_resource($this->link()) && is_resource($result) ? $this->call('mysql_data_seek', array($result, $row), false) : false;
	}


	// Уничтожает базу данных MySQL.
	// bool mysql_drop_db ( строка database_name, resource link_identifier )
	final private function drop_db($db)
	{
		$db = (string)$db;
		return is_resource($this->link()) ? $this->call('mysql_drop_db', array($db, $this->link()), false) : false;
	}


	// Возвращает численный код ошибки выполнения последней операции с MySQL.
	// int mysql_errno ( resource link_identifier )
	final private function error_code() { return is_resource($this->link()) ? $this->call('mysql_errno', $this->link(), 0) : 0; }


	// Возвращает строку ошибки последней операции с MySQL.
	// string mysql_error ( resource link_identifier )
	final private function error_text() { return is_resource($this->link()) ? $this->call('mysql_error', $this->link(), '') : ''; }


	// Экранирует SQL спец-символы для mysql_query.
	// string mysql_escape_string ( string unescaped_string )
	final private function escape_string($string, $mask = 0)
	{
		$data = array((string)$string);
		$return = $this->extension_debug_call('mysql_escape_string', $data, false);
		if (is_string($return))
		{
			if (is_numeric($mask))
			{
				$mask = (int)$mask;
				if (($mask & 1) === 1) $return = str_replace('_', '\\_', $return);
				if (($mask & 2) === 2) $return = str_replace('%', '\\%', $return);
			}
			elseif (is_string($mask))
			{
				if (strpos($mask, '_') !== false) $return = str_replace('_', '\\_', $return);
				if (strpos($mask, '%') !== false) $return = str_replace('%', '\\%', $return);
			}
			elseif (is_array($mask))
			{
				if (in_array('_', $mask) !== false) $return = str_replace('_', '\\_', $return);
				if (in_array('%', $mask) !== false) $return = str_replace('%', '\\%', $return);
			}
		}
		else $return = '';
		return $return;
	}


	// Обрабатывает ряд результата запроса, возвращая ассоциативный массив, численный массив или оба.
	// array mysql_fetch_array ( resource result, int result_type )
	// result_type = { MYSQL_ASSOC | MYSQL_NUM | MYSQL_BOTH }
	final private function fetch_array($result, $type = null)
	{
		static $TYPES = array('ASSOC' => MYSQL_ASSOC, 'BOTH' => MYSQL_BOTH, 'NUM' => MYSQL_NUM);
		$TYPES_ALL = $TYPES['ASSOC'] | $TYPES['BOTH'] | $TYPES['NUM'];
		$TYPE = $TYPES['BOTH'];
		$type = (int)(is_int($type) && ($type & $TYPES_ALL) ? ($type & $TYPES_ALL) : $TYPE);
		return is_resource($this->link()) && is_resource($result) ? $this->call('mysql_fetch_array', array($result, $type), false) : false;
	}


	// Обрабатывает ряд результата запроса и возвращает ассоциативный массив.
	// array mysql_fetch_assoc ( resource result )
	final private function fetch_assoc($result)
	{
		return is_resource($this->link()) && is_resource($result) ? $this->call('mysql_fetch_assoc', $result, false) : false;
	}


	// Возвращает информацию о колонке из результата запроса в виде объекта.
	// object mysql_fetch_field ( resource result [, int field_offset ] )
	// object { blob, max_length, multiple_key, name, not_null, numeric, primary_key, table, type, unique_key, unsigned, zerofill }
	final public function  fetch_field($result, $offset = null, $key = null)
	{
		$data = is_int($offset) ? array($result, (int)$offset) : array($result);
		$return = is_resource($this->link()) && is_resource($result) ? $this->call('mysql_fetch_field', $data, null) : null;
		if (!is_object($return)) return null;
		static $KEY = array(
				'table' => 'string', 'name' => 'string', 'type' => 'string', 'max_length' => 'int',
				'multiple_key' => 'bool', 'primary_key' => 'bool', 'unique_key' => 'bool',
				'blob' => 'bool', 'numeric' => 'bool', 'not_null' => 'bool', 'unsigned' => 'bool', 'zerofill' => 'bool'
			);
		// cast
		$return_new = array();
		foreach ($KEY as $k => $t)
		{
			if ($t === 'bool') $return_new[$k] = (bool)$return->$k;
			elseif ($t === 'string') $return_new[$k] = (string)$return->$k;
			elseif ($t === 'int') $return_new[$k] = (int)$return->$k;
		}
		// key
		$key = is_string($key) ? strtolower((string)$key) : null;
		if ($key === null) $return = $return_new;
		elseif (is_string($key) && array_key_exists($key, $KEY)) $return = $return_new[$key];
		elseif (is_array($key) && (count($key) > 0))
		{
			$return = array();
			foreach ($key as $k) { if (array_key_exists($k, $return_new)) { $return[$k] = $return_new[$k]; } }
			if (count($return) < 1) $return = null;
		}
		else $return = $return_new;
		return $return;
	}


	// Возвращает длину каждого поля в результате.
	// array mysql_fetch_lengths ( resource result )
	final public function  fetch_lengths($result)
	{
		return is_resource($this->link()) && is_resource($result) ? $this->call('mysql_fetch_lengths', $result, false) : false;
	}


	// Обрабатывает ряд результата запроса и возвращает объект.
	// object mysql_fetch_object ( resource result )
	final private function fetch_object($result)
	{
		return is_resource($this->link()) && is_resource($result) ? $this->call('mysql_fetch_object', $result, false) : false;
	}


	// Орабатывает ряд результата запроса и возвращает неассоциативный массив.
	// array mysql_fetch_row ( resource result )
	final private function fetch_row($result)
	{
		return is_resource($this->link()) && is_resource($result) ? $this->call('mysql_fetch_row', $result, false) : false;
	}


	// Возвращает флаги указанного поля результата запроса.
	// string mysql_field_flags ( resource result, int field_offset )
	// string { not_null | primary_key | unique_key | multiple_key | blob | unsigned | zerofill | binary | enum | auto_increment | timestamp }
	final public function  field_flags($result, $offset)
	{
		return is_resource($this->link()) && is_resource($result) ? $this->call('mysql_field_flags', array($result, (int)$offset), '') : '';
	}


	// Возвращает длину указанного поля.
	// int mysql_field_len ( resource result, int field_offset )
	final public function  field_length($result, $offset)
	{
		return is_resource($this->link()) && is_resource($result) ? $this->call('mysql_field_len', array($result, (int)$offset), 0) : 0;
	}


	// Возвращает название указанной колонки результата запроса.
	// string mysql_field_name ( resource result, int field_index )
	final public function  field_name($result, $index)
	{
		return is_resource($this->link()) && is_resource($result) ? $this->call('mysql_field_name', array($result, (int)$index), '') : '';
	}


	// Устанавливает внутренний указатель поля на переданное смещение.
	// array mysql_field_seek ( resource result, int field_offset )
	final public function  field_seek($result, $offset)
	{
		return is_resource($this->link()) && is_resource($result) ? $this->call('mysql_field_seek', array($result, (int)$offset), array()) : array();
	}


	// Возвращает название таблицы, которой принадлежит указанное поле.
	// string mysql_field_table ( resource result, int field_offset )
	final public function  field_table($result, $offset)
	{
		return is_resource($this->link()) && is_resource($result) ? $this->call('mysql_field_table', array($result, (int)$offset), '') : '';
	}


	// Возвращает тип указанного поля результата запроса.
	// string mysql_field_type ( resource result, int field_offset )
	final public function  field_type($result, $offset)
	{
		return is_resource($this->link()) && is_resource($result) ? $this->call('mysql_field_type', array($result, (int)$offset), '') : '';
	}


	// Освобождает память от результата запроса.
	// bool mysql_free_result ( resource result )
	final private function free_result($result)
	{
		return is_resource($this->link()) && is_resource($result) ? $this->call('mysql_free_result', $result, false) : false;
	}


	// Возвращает данные о MySQL-клиенте.
	// string mysql_get_client_info ( void )
	final public function  get_client_info() { return $this->call('mysql_get_client_info', array(), ''); }


	// Возвращает информацию о соединении с MySQL.
	// string mysql_get_host_info ( resource link_identifier )
	final public function  get_host_info() { return is_resource($this->link()) ? $this->call('mysql_get_host_info', $this->link(), '') : ''; }


	// Возвращает информацию о протоколе MySQL.
	// int mysql_get_proto_info ( resource link_identifier )
	final public function  get_proto_info() { return is_resource($this->link()) ? $this->call('mysql_get_proto_info', $this->link(), 0) : 0; }


	// Возвращает информацию о сервере MySQL.
	// string mysql_get_server_info ( resource link_identifier )
	final public function  get_server_info() { return is_resource($this->link()) ? $this->call('mysql_get_server_info', $this->link(), '') : ''; }


	// Возвращает информацию о последнем запросе.
	// string mysql_info ( resource link_identifier )
	final public function  info() { return is_resource($this->link()) ? $this->call('mysql_info', $this->link(), '') : ''; }


	// Возвращает ID, сгенерированный при последнем INSERT-запросе.
	// int mysql_insert_id ( resource link_identifier )
	final public function  insert_id()
	{
/** /
		$result = is_resource($this->link()) ? $this->query_buffered('SELECT LAST_INSERT_ID();') : null;
		return is_resource($result) ? $this->result($result, 0, 0) : 0;
/**/
		return is_resource($this->link()) ? $this->call('mysql_insert_id', $this->link(), 0) : 0;
/**/
	}


	// Возвращает список баз данных, доступных на сервере.
	// resource mysql_list_dbs ( resource link_identifier )
	final private function list_dbs() { return is_resource($this->link()) ? $this->call('mysql_list_dbs', $this->link(), null) : null; }


	// Возвращает список колонок таблицы.
	// resource mysql_list_fields ( string database_name, string table_name, resource link_identifier )
	final private function list_fields($db, $table)
	{
		$db = (string)$db;
		$table = (string)$table;
		return is_resource($this->link()) ? $this->call('mysql_list_fields', array($db, $table, $this->link()), null) : null;
	}


	// Возвращает список процессов MySQL.
	// resource mysql_list_processes ( resource link_identifier )
	final private function list_processes() { return is_resource($this->link()) ? $this->call('mysql_list_processes', $this->link(), null) : null; }


	// Возвращает список таблиц базы данных MySQL.
	// resource mysql_list_tables ( string database, resource link_identifier )
	final private function list_tables($db)
	{
		$db = (string)$db;
		return is_resource($this->link()) ? $this->call('mysql_list_tables', array($db, $this->link()), null) : null;
	}


	// Возвращает название базы данных.
	// string mysql_db_name ( resource result = mysql_list_dbs(), int row = [0, mysql_num_rows), mixed field )
	final private function name_db($list, $row, $field)
	{
		$row = (string)$row;
		$field = (string)$field;
		return is_resource($this->link()) && is_resource($list) ? $this->call('mysql_db_name', array($list, $row, $field), '') : '';
	}


	// Возвращает количество полей результата запроса.
	// int mysql_num_fields ( resource result )
	final private function num_fields($result)
	{
		return is_resource($this->link()) && is_resource($result) ? $this->call('mysql_num_fields', $result, 0) : 0;
	}


	// Возвращает количество рядов результата запроса.
	// int mysql_num_rows ( resource result )
	final private function num_rows($result)
	{
		return is_resource($this->link()) && is_resource($result) ? $this->call('mysql_num_rows', $result, 0) : 0;
	}


	// Устанавливает постоянное соединение с сервером MySQL.
	// resource mysql_pconnect ( string host, string username, string password [, int client_flags ] )
	// client_flags = { MYSQL_CLIENT_COMPRESS | MYSQL_CLIENT_IGNORE_SPACE | MYSQL_CLIENT_INTERACTIVE }
	final private function pconnecting($server = null, $login = null, $password = null, $flag = null)
	{
		if (is_resource($this->link())) return true;
		if (is_string($server)) $server = (string)$server;
		elseif (is_array($server) && isset($server[0], $server[1])) $server = sprintf('%s:%s', $server[0], $server[1]);
		else $server = sprintf('%s:%s', $this->ini_default_server(), $this->ini_default_port());
		$login = is_string($login) ? (string)$login : $this->ini_default_login();
		$password = is_string($password) ? (string)$password : $this->ini_default_password();
		static $FLAGS = array('COMPRESS' => self::COMPRESS, 'SPACE' => self::SPACE, 'INTERACTIVE' => self::INTERACTIVE);
		$FLAGS_ALL = $FLAGS['COMPRESS'] | $FLAGS['SPACE'] | $FLAGS['INTERACTIVE'];
		$FLAGS_DEFAULT = $FLAGS['COMPRESS'] | $FLAGS['SPACE'];
		$flag = (int)(is_int($flag) && ($flag & $FLAGS_ALL) ? ($flag & $FLAGS_ALL) : $FLAGS_DEFAULT);
		$link = $this->call('mysql_pconnect', array($server, $login, $password, $flag), false);
		if (is_resource($link))
		{
			$this->AUTOQUERY = array();
			$this->DATABASE = null;
			$this->FLAG = $flag;
			$this->HARDWIRED = true;
			$this->IS_NEW = null;
			$this->LINK = $link;
			$this->LOGIN = $login;
			$this->PASSWORD = $password;
			$this->SERVER = $server;
			return true;
		}
		return false;
	}


	// Проверяет соединение с сервером и пересоединяется при необходимости.
	// bool mysql_ping ( resource link_identifier )
	final public function  ping() { return is_resource($this->link()) ? $this->call('mysql_ping', $this->link(), false) : false; }


	// Посылает запрос MySQL.
	// resource mysql_query ( string query, resource link_identifier )
	final private function query_buffered($query)
	{
		$query = is_string($query) && preg_match('"[\S]"', $query) ? (string)$query : false;
		$this->speed_locate();
		$return = (is_resource($this->link()) && $query) ? $this->call('mysql_query', array($query, $this->link()), false) : false;
		$this->speed_locate_duration();
		return $return;
	}


	// Переключается к указанной базе данных и посылает запрос.
	// resource mysql_db_query ( string database, string query, resource link_identifier )
	final private function query_db($query, $db = null)
	{
		$query = is_string($query) && preg_match('"[\S]"', $query) ? (string)$query : false;
		$db = is_string($db) ? (string)$db : $this->db();
		$this->speed_locate();
		$return = (is_resource($this->link()) && $query && $db) ? $this->call('mysql_db_query', array($db, $query, $this->link()), false) : false;
		$this->speed_locate_duration();
		if (is_resource($return))
		{
			$this->DATABASE = $db;
		}
		return $return;
	}


	// Посылает MySQL SQL-запрос без авто-обработки результата и её буфферизации.
	// resource mysql_unbuffered_query ( string query, resource link_identifier )
	final private function query_unbuffered($query)
	{
		$query = is_string($query) && preg_match('"[\S]"', $query) ? (string)$query : false;
		$this->speed_locate();
		$return = (is_resource($this->link()) && $query) ? $this->call('mysql_unbuffered_query', array($query, $this->link()), false) : false;
		$this->speed_locate_duration();
		return $return;
	}


	// Экранирует специальные символы в строках для использования в выражениях SQL, принимая во внимание кодировку соединения.
	// string mysql_real_escape_string ( string unescaped_string, resource link_identifier )
	final private function real_escape_string($string, $mask = 0)
	{
		$string = (string)$string;
		$return = is_resource($this->link()) ? $this->call('mysql_real_escape_string', array($string, $this->link()), false) : false;
		if (is_string($return))
		{
			if (is_numeric($mask))
			{
				$mask = (int)$mask;
				if (($mask & 1) === 1) $return = str_replace('_', '\\_', $return);
				if (($mask & 2) === 2) $return = str_replace('%', '\\%', $return);
			}
			elseif (is_string($mask))
			{
				if (strpos($mask, '_') !== false) $return = str_replace('_', '\\_', $return);
				if (strpos($mask, '%') !== false) $return = str_replace('%', '\\%', $return);
			}
			elseif (is_array($mask))
			{
				if (in_array('_', $mask) !== false) $return = str_replace('_', '\\_', $return);
				if (in_array('%', $mask) !== false) $return = str_replace('%', '\\%', $return);
			}
		}
		else $return = false;
		return $return;
	}


	// Возвращает данные результата запроса.
	// mixed mysql_result ( resource result, int row [, mixed field] )
	final public function  result($result, $row = 0, $field = null)
	{
		$row = ((int)$row > 0) ? (int)$row : 0;
		if ($field === null) $data = array($result, $row);
		elseif (is_string($field)) $data = array($result, $row, (string)$field);
		elseif (is_int($field)) $data = array($result, $row, (int)$field);
		else $data = array($result, $row);
		return is_resource($this->link()) && is_resource($result) ? $this->call('mysql_result', $data, false) : false;
	}


	// Выбирает базу данных MySQL.
	// bool mysql_select_db ( string database_name, resource link_identifier )
	final private function select_db($db = null)
	{
		$db = is_string($db) ? (string)$db : $this->db();
		$return = is_resource($this->link()) && $db ? $this->call('mysql_select_db', array($db, $this->link()), false) : false;
		if ($return === true)
		{
			$this->DATABASE = $db;
		}
		return $return;
	}


	// Возвращает текущий статус сервера.
	// string mysql_stat ( resource link_identifier )
	final private function stat() { return explode('  ', is_resource($this->link()) ? $this->call('mysql_stat', $this->link(), '') : ''); }


	// Возвращает имя таблицы, содержащей указанное поле.
	// string mysql_tablename ( string result, int index )
	final private function tablename($result, $index)
	{
		$index = (int)$index;
		return is_resource($this->link()) && is_resource($result) ? $this->call('mysql_tablename', array($result, $index), '') : '';
	}


	// Возвращает ID текущего потока.
	// int mysql_thread_id ( resource link_identifier )
	final public function  thread_id()
	{
		return is_resource($this->link()) ? $this->call('mysql_thread_id', $this->link(), 0) : 0;
	}


	// Handler
	final private function handler($result, $result_error = false)
	{
		if ($this->debug() && ($result === $result_error))
		{
			$message = array(sprintf('#%s: %s.', $this->error_code(), $this->error_text()));
			foreach (debug_backtrace() as $v)
			{
				if (isset($v['file'], $v['line'])) $message[] = sprintf('%s (%s)', $v['file'], $v['line']);
			}
			trigger_error(join("\n", $message), E_USER_NOTICE);
		}
		return $result;
	}


	// обертки
	final public function  affected() { return $this->affected_rows(); }

	final public function  close() { return $this->handler($this->closing(), false); }

	final public function  connect($server = null, $login = null, $password = null, $new = null, $flag = null)
	{
		return $this->handler($this->connecting(&$server, &$login, &$password, &$new, &$flag), false);
	}

	final public function  db_create($db) { return $this->handler($this->create_db(&$db), false); }

	final public function  db_drop($db) { return $this->handler($this->drop_db(&$db), false); }

	final public function  db_list() { return $this->handler($this->list_dbs(), null); }

	final public function  db_name($result, $row, $field) { return $this->handler($this->name_db(&$result, &$row, &$field), ''); }

	final public function  db_query($query, $db = null) { return $this->handler($this->query_db(&$query, &$db), false); }

	final public function  db_select($db) { return $this->handler($this->select_db(&$db), false); }

	final public function  disconnect() { return $this->handler($this->closing(), false); }

	final public function  encoding() { return $this->client_encoding(); }

	final public function  error() { return $this->error_text(); }

	final public function  errorN() { return $this->error_code(); }

	final public function  fetch($result, $type = null)
	{
		if ($type === null) $return = $this->fetch_assoc($result);
		elseif (is_string($type) || is_int($type))
		{
			if (in_array($type, array(1, 'a', 'A', '', 'd', 'D', 'assoc', 'default'), true)) $return = $this->fetch_assoc($result);
			elseif (in_array($type, array(2, 'y', 'Y', 'array'), true)) $return = $this->fetch_array($result);
			elseif (in_array($type, array(3, 'o', 'O', 'object'), true)) $return = $this->fetch_object($result);
			elseif (in_array($type, array(4, 'r', 'R', 'row'), true)) $return = $this->fetch_row($result);
			else $return = $this->fetch_assoc($result);
		}
		else $return = $this->fetch_assoc($result);
		return $return;
	}

	final public function  fields($result) { return $this->num_fields(&$result); }

	final public function  fields_list($db, $table) { return $this->handler($this->list_fields(&$db, &$table), null); }

	final public function  last_id()
	{
		$result = is_resource($this->link()) ? $this->handler($this->query_buffered('SELECT LAST_INSERT_ID();'), false) : false;
		return (string)(is_resource($result) ? $this->result($result, 0, 0) : 0);
	}

	final public function  open($server = null, $login = null, $password = null, $new = null, $flags = null, $db = null, $query = null)
	{
		$A = array(0 => &$server, 1 => &$login, 2 => &$password, 3 => &$new, 4 => &$flags, 5 => &$db, 6 => &$query);
		$a = in_array($A[3], array(null, true, false), true) ? true : false;
		$connected = $this->handler($a ? $this->connecting(&$A[0], &$A[1], &$A[2], &$A[3], &$A[4]) : $this->pconnecting(&$A[0], &$A[1], &$A[2], &$A[4]), false);
		if ($connected)
		{
			$this->handler($this->select_db(&$A[5]), false);
			$this->AUTOQUERY = is_array($A[6]) ? $A[6] : (is_string($A[6]) ? array((string)$A[6]) : array());
			foreach ($this->AUTOQUERY as $q) (is_string($q) && (strlen($q) > 0)) ? $this->handler($this->query_unbuffered($q), false) : 0;
			return true;
		}
		return false;
	}

	final public function  pconnect($server = null, $login = null, $password = null, $flag = null)
	{
		return $this->handler($this->pconnecting(&$server, &$login, &$password, &$flag), false);
	}

	final public function  processes_list() { return $this->list_processes(); }

	final public function  query($query) { return $this->handler($this->query_buffered(&$query), false); }

	final public function  quote($string = '', $mask = 0) { return $this->escape_string(&$string, &$mask); }

	final public function  quote_real($string = '', $mask = 0) { $return = $this->handler($this->real_escape_string(&$string, &$mask), false); }

	final public function  relogin($login = null, $password = null, $db = null)
	{
		return $this->handler($this->change_user(&$login, &$password, &$db), false);
	}

	final public function  result_free($result) { return $this->handler($this->free_result(&$result), false); }

	final public function  result_seek($result, $row) { return $this->handler($this->data_seek(&$result, &$row), false); }

	final public function  rows($result) { return $this->num_rows(&$result); }

	final public function  state() { return $this->stat(); }

	final public function  table_list($db) { return $this->list_tables(&$db); }

	final public function  table_name($result, $index) { return $this->tablename(&$result, &$index); }

	final public function  uquery($query) { return $this->handler($this->query_unbuffered(&$query), false); }


	// Приведение типов по выполнении запроса
	const CAST = true;

	private $CAST = self::CAST;

	final public function  cast($cast = null)
	{
		if ($cast === (bool)$cast) $this->CAST = (bool)$cast;
		return (bool)$this->CAST;
	}

	final private function cast_to_type($data, $type)
	{
		$return = null;
		if ($data === null) $return = null;
		elseif ($data === (bool)$data) $return = (bool)$return;
		elseif (is_string($data))
		{
			static $TYPE = array(
					'NULL' => array('null'),
					'STRING' => array('string', 'blob'),
					'INTEGER' => array('int'),
					'DATETIME' => array('datetime', 'date', 'time'),
					'DOUBLE' => array('real')
				);
			$type = is_string($type) ? strtolower((string)$type) : '';
			if (in_array($type, $TYPE['NULL'], true)) $return = null;
			elseif (in_array($type, $TYPE['STRING'], true)) $return = (string)$data;
			elseif (in_array($type, $TYPE['INTEGER'], true)) $return = ($data == (int)$data) ? (int)$data : (string)$data;
			elseif (in_array($type, $TYPE['DATETIME'], true)) $return = $this->call('strtotime', (string)$data, '');
			elseif (in_array($type, $TYPE['DOUBLE'], true)) $return = (double)$data;
			else $return = &$data;
		}
		else $return = (string)$data;
		return $return;
	}


	// free & all & one & rall & row
	final public function  free($result) { return $this->result_free(&$result); }

	final public function  all($result, $type = null, $field = null, $key = null)
	{
		$RETURN = array();
		$first = true;
		do
		{
			$return = $this->fetch($result, $type);
			// $return = $this->handler($return, false);
			if ($return === false) { break; }
			elseif ($first === true)
			{
				$first = false;
				$data = array();
				for ($i = 0, $ii = $this->fields($result); $i < $ii; $i++)
				{
					$d = array(
							't' => $this->field_type($result, $i),
							'n' => $this->field_name($result, $i),
							'i' => $i
						);
					in_array($key, array($d['n'], $d['i']), true) ? array_unshift($data, $d) : array_push($data, $d);
				}
			}
			//
			$KEY = false;
			foreach ($data as $d)
			{
				$n = $d['n'];
				$i = $d['i'];
				if (is_array($return) && array_key_exists($n, $return)) { $r = &$return[$n]; $f = true; }
				elseif (is_object($return) && property_exists($return, $n)) { $r = &$return->$n; $f = true; }
				elseif (is_array($return) && array_key_exists($i, $return)) { $r = &$return[$i]; $n = $i; $f = true; }
				else $f = false;
				//
				if ($f)
				{
					if ($this->cast()) { $r = $this->cast_to_type($r, $d['t']); }
					if ($key === $n) { $KEY = $r; }
					if ($field === $n) { $return = $r; break; }
				}
			}
			if ($KEY === false) $RETURN[] = $return;
			else $RETURN[(string)$KEY] = $return;
		}
		while(true);
		return $RETURN;
	}

	final public function  one($result, $row = null, $field = null)
	{
		$return = $this->handler($this->result($result, $row, $field), false);
		if ($return !== false)
		{
			if (!is_numeric($field))
			{
				$type = 'string';
				for ($i = 0, $I = $this->fields($result); $i < $I; $i++)
				{
					$fetch = $this->fetch_field($result, $i, array('name', 'type'));
					if ($fetch && ($fetch['name'] === $field)) { $type = $fetch['type']; break; }
				}
			}
			else $type = $this->field_type($result, $field);
			$return = $this->cast_to_type($return, $type);
		}
		return $return;
	}

	final public function  rall($result, $call, $type = null, $cdata = null)
	{
		if (!is_callable($call)) return false;
		$RETURN = 0;
		$first = true;
		do
		{
			$return = $this->fetch($result, $type);
			// $return = $this->handler($return, false);
			if ($return === false) { break; }
			elseif ($first === true)
			{
				$first = false;
				$data = array();
				for ($i = 0, $ii = $this->fields($result); $i < $ii; $i++)
				{
					$data[] = array(
							't' => $this->field_type($result, $i),
							'n' => $this->field_name($result, $i),
							'i' => $i
						);
				}
			}
			//
			foreach ($data as $d)
			{
				$n = $d['n'];
				$i = $d['i'];
				if (is_array($return) && array_key_exists($n, $return)) { $r = &$return[$n]; $f = true; }
				elseif (is_object($return) && property_exists($return, $n)) { $r = &$return->$n; $f = true; }
				elseif (is_array($return) && array_key_exists($i, $return)) { $r = &$return[$i]; $n = $i; $f = true; }
				else $f = false;
				//
				if ($f && $this->cast()) { $r = $this->cast_to_type($r, $d['t']); }
			}
			// для прерывания - используйте в функции обратного вызова конструкцию
			// throw new Exception('<BREAK_MESSAGE>', <BREAK_CODE>);
			try { call_user_func_array($call, array($return, $RETURN++, &$cdata)); } catch (Exception $e) { break; }
		}
		while(true);
		return $RETURN;
	}

	final public function  row($result, $type = null, $field = null)
	{
		$return = $this->fetch($result, $type);
		// $return = $this->handler($return, false);
		if ($return !== false)
		{
			for ($i = 0, $ii = $this->fields($result); $i < $ii; $i++)
			{
				$n = $this->field_name($result, $i);
				if (is_array($return) && array_key_exists($n, $return)) { $r = &$return[$n]; $f = true; }
				elseif (is_object($return) && property_exists($return, $n)) { $r = &$return->$n; $f = true; }
				elseif (is_array($return) && array_key_exists($i, $return)) { $r = &$return[$i]; $n = $i; $f = true; }
				else $f = false;
				//
				if ($f)
				{
					if ($this->cast()) { $r = $this->cast_to_type($r, $this->field_type($result, $i)); }
					if ($field === $n) { $return = $r; break; }
				}
			}
		}
		return $return;
	}


	// query: all, one, rall, row, speed
	final public function  query_all($query = null, $type = null, $field = null, $key = null)
	{
		$result = $this->query(&$query);
		if (is_resource($result))
		{
			$return = $this->all(&$result, &$type, &$field, &$key);
			$this->free(&$result);
		}
		else $return = false;
		return $return;
	}

	final public function  query_one($query = null, $row = null, $field = null)
	{
		$result = $this->query(&$query);
		if (is_resource($result))
		{
			$return = $this->one(&$result, &$row, &$field);
			$this->free(&$result);
		}
		else $return = false;
		return $return;
	}

	final public function  query_rall($query = null, $call = null, $type = null, $cdata = null)
	{
		$result = $this->query(&$query);
		if (is_resource($result))
		{
			$return = $this->rall(&$result, &$call, &$type, &$cdata);
			$this->free(&$result);
		}
		else $return = false;
		return $return;
	}

	final public function  query_row($query = null, $type = null, $field = null)
	{
		$result = $this->query(&$query);
		if (is_resource($result))
		{
			$return = $this->row(&$result, &$type, &$field);
			$this->free(&$result);
		}
		else $return = false;
		return $return;
	}

	final public function  query_speed() { return $this->speed_duration(); }

	final public function  q($query = null) { return $this->query(&$query); }

	final public function  q_all($query = null, $type = null, $field = null, $key = null) { return $this->query_all(&$query, &$type, &$field, &$key); }

	final public function  q_one($query = null, $row = null, $field = null) { return $this->query_one(&$query, &$row, &$field); }

	final public function  q_rall($query = null, $call = null, $type = null, $cdata = null) { return $this->query_rall(&$query, &$call, &$type, &$cdata); }

	final public function  q_row($query = null, $type = null, $field = null) { return $this->query_row(&$query, &$type, &$field); }

	final public function  q_speed() { return $this->query_speed(); }

	final public function  q0($query = null, $row = null, $field = null) { return $this->q_one(&$query, &$row, &$field); }

	final public function  q1($query = null, $type = null, $field = null) { return $this->q_row(&$query, &$type, &$field); }

	final public function  q2($query = null, $type = null, $field = null, $key = null) { return $this->q_all(&$query, &$type, &$field, &$key); }

	final public function  q3($query = null, $call = null, $type = null, $cdata = null) { return $this->q_rall(&$query, &$call, &$type, &$cdata); }



	// uquery: all, rall, row
	final public function  uquery_all($query = null, $type = null, $field = null, $key = null)
	{
		$result = $this->uquery($query);
		if (is_resource($result))
		{
			$return = $this->all(&$result, &$type, &$field, &$key);
			$this->free(&$result);
		}
		else $return = false;
		return $return;
	}

	final public function  uquery_rall($query = null, $call = null, $type = null, $cdata = null)
	{
		$result = $this->uquery($query);
		if (is_resource($result))
		{
			$return = $this->rall(&$result, &$call, &$type, &$cdata);
			$this->free(&$result);
		}
		else $return = false;
		return $return;
	}

	final public function  uquery_row($query = null, $type = null, $field = null)
	{
		$result = $this->uquery($query);
		if (is_resource($result))
		{
			$return = $this->row(&$result, &$type, &$field);
			$this->free(&$result);
		}
		else $return = false;
		return $return;
	}

	final public function  uquery_speed() { return $this->speed_duration(); }

	final public function  u($query = null) { return $this->uquery(&$query); }

	final public function  u_all($query = null, $type = null, $field = null, $key = null) { return $this->uquery_all(&$query, &$type, &$field, &$key); }

	final public function  u_rall($query = null, $call = null, $type = null, $cdata = null) { return $this->uquery_rall(&$query, &$call, &$type, &$cdata); }

	final public function  u_row($query = null, $type = null, $field = null) { return $this->uquery_row(&$query, &$type, &$field); }

	final public function  u_speed() { return $this->uquery_speed(); }

	final public function  u1($query = null, $type = null, $field = null) { return $this->u_row(&$query, &$type, &$field); }

	final public function  u2($query = null, $type = null, $field = null, $key = null) { return $this->u_all(&$query, &$type, &$field, &$key); }

	final public function  u3($query = null, $call = null, $type = null, $cdata = null) { return $this->u_rall(&$query, &$call, &$type, &$cdata); }


	//
	final public function __construct($data = null)
	{
		if (is_array($data))
		{
			$data = array_change_key_case($data, CASE_UPPER);
			// DEBUG
			if (array_key_exists('DEBUG', $data)) $this->debug($data['DEBUG']);
			// SPEED
			if (array_key_exists('SPEED', $data)) $this->speed($data['SPEED']);
			// SPEED_SENSITIVITY
			if (array_key_exists('SPEED_SENSITIVITY', $data)) $this->speed_sensitivity($data['SPEED_SENSITIVITY']);
			elseif (array_key_exists('SPEED_S', $data)) $this->speed_sensitivity($data['SPEED_S']);
			// CAST
			if (array_key_exists('CAST', $data)) $this->cast($data['CAST']);
			// AUTOQUERY
			if (array_key_exists('AUTOQUERY', $data)) $AUTOQUERY = $data['AUTOQUERY'];
			elseif (array_key_exists('QUERY', $data)) $AUTOQUERY = $data['QUERY'];
			elseif (array_key_exists('AUTO', $data)) $AUTOQUERY = $data['AUTO'];
			elseif (array_key_exists('AQ', $data)) $AUTOQUERY = $data['AQ'];
			elseif (array_key_exists('Q', $data)) $AUTOQUERY = $data['Q'];
			elseif (array_key_exists(6, $data)) $AUTOQUERY = $data[6];
			else $AUTOQUERY = null;
			// DATABASE
			if (array_key_exists('DATABASE', $data)) $DATABASE = $data['DATABASE'];
			elseif (array_key_exists('DB', $data)) $DATABASE = $data['DB'];
			elseif (array_key_exists('D', $data)) $DATABASE = $data['D'];
			elseif (array_key_exists('BASE', $data)) $DATABASE = $data['BASE'];
			elseif (array_key_exists('B', $data)) $DATABASE = $data['B'];
			elseif (array_key_exists(5, $data)) $DATABASE = $data[5];
			else $DATABASE = 'mysql';
			$DATABASE = (string)$DATABASE;
			// FLAG
			if (array_key_exists('FLAG', $data)) $FLAG = $data['FLAG'];
			elseif (array_key_exists('F', $data)) $FLAG = $data['F'];
			elseif (array_key_exists(4, $data)) $FLAG = $data[4];
			else $FLAG = null;
			// HARDWIRED
			if (array_key_exists('HARDWIRED', $data)) $HARDWIRED = $data['HARDWIRED']; // ''
			elseif (array_key_exists('NEW', $data)) $HARDWIRED = $data['NEW']; // { null | false | true }
			elseif (array_key_exists(3, $data)) $HARDWIRED = $data[3];
			else $HARDWIRED = true;
			// LOGIN
			if (array_key_exists('LOGIN', $data)) $LOGIN = $data['LOGIN'];
			elseif (array_key_exists('L', $data)) $LOGIN = $data['L'];
			elseif (array_key_exists('USER', $data)) $LOGIN = $data['USER'];
			elseif (array_key_exists('U', $data)) $LOGIN = $data['U'];
			elseif (array_key_exists(1, $data)) $LOGIN = $data[1];
			else $LOGIN = 'root';
			$LOGIN = (string)$LOGIN;
			// PASSWORD
			if (array_key_exists('PASSWORD', $data)) $PASSWORD = $data['PASSWORD'];
			elseif (array_key_exists('PASS', $data)) $PASSWORD = $data['PASS'];
			elseif (array_key_exists('PWD', $data)) $PASSWORD = $data['PWD'];
			elseif (array_key_exists('P', $data)) $PASSWORD = $data['P'];
			elseif (array_key_exists(2, $data)) $PASSWORD = $data[2];
			else $PASSWORD = false;
			// SERVER
			if (array_key_exists('SERVER', $data)) $SERVER = $data['SERVER'];
			elseif (array_key_exists('SRV', $data)) $SERVER = $data['SRV'];
			elseif (array_key_exists('HOST', $data)) $SERVER = $data['HOST'];
			elseif (array_key_exists(0, $data)) $SERVER = $data[0];
			else $SERVER = 'localhost';
			$SERVER = (string)$SERVER;
			// OPEN
			if ($PASSWORD) $this->open($SERVER, $LOGIN, $PASSWORD, $HARDWIRED, $FLAG, $DATABASE, $AUTOQUERY);
		}
		else
		{
			$this->DEBUG = self::DEBUG;
			$this->SPEED = self::SPEED;
			$this->SPEED_SENSITIVITY = self::SPEED_SENSITIVITY;
			$this->CAST = self::CAST;
			$this->AUTOQUERY = array();
			$this->DATABASE = null;
			$this->FLAG = null;
			$this->HARDWIRED = null;
			$this->IS_NEW = null;
			$this->LINK = null;
			$this->LOGIN = null;
			$this->PASSWORD = null;
			$this->SERVER = null;
		}
		$this->SPEED_LOCATE = false;
		$this->SPEED_DURATION = false;
	}

	final public function __destruct() { $this->close(); }

	final public function __clone()
	{
		//$this->DEBUG;
		// AUTOQUERY & DATABASE & FLAG & HARDWIRED & IS_NEW & LINK & LOGIN & PASSWORD & SERVER
		$connect = is_resource($this->LINK) ? $this->open($this->SERVER, $this->LOGIN, $this->PASSWORD, $this->HARDWIRED ? 'HARDWIRED' : $this->IS_NEW, $this->FLAG, $this->DATABASE, $this->AUTOQUERY) : false;
		if (!$connect)
		{
			$this->AUTOQUERY = array();
			$this->DATABASE = $this->FLAG = $this->HARDWIRED = $this->IS_NEW = $this->LINK = $this->LOGIN = $this->PASSWORD = $this->SERVER = null;
		}
		//$this->SPEED;
		//$this->SPEED_SENSITIVITY;
		$this->SPEED_LOCATE = false;
		$this->SPEED_DURATION = false;
		//$this->CAST;
	}

	final public function __sleep()
	{
		if (is_resource($this->LINK))
		{
			$this->close();
			$this->LINK = true;
		}
		return array('DEBUG', 'DATABASE', 'FLAG', 'HARDWIRED', 'IS_NEW', 'LINK', 'LOGIN', 'PASSWORD', 'SERVER', 'SPEED', 'SPEED_SENSITIVITY', 'SPEED_LOCATE', 'SPEED_DURATION', 'CAST');
	}

	final public function __wakeup()
	{
		//$this->DEBUG;
		$connect = is_resource($this->LINK === true) ? $this->open($this->SERVER, $this->LOGIN, $this->PASSWORD, $this->HARDWIRED ? 'HARDWIRED' : $this->IS_NEW, $this->FLAG, $this->DATABASE, $this->AUTOQUERY) : false;
		if (!$connect)
		{
			$this->AUTOQUERY = array();
			$this->DATABASE = $this->FLAG = $this->HARDWIRED = $this->IS_NEW = $this->LINK = $this->LOGIN = $this->PASSWORD = $this->SERVER = null;
		}
		//$this->SPEED;
		//$this->SPEED_SENSITIVITY;
		$this->SPEED_LOCATE = false;
		$this->SPEED_DURATION = false;
		//$this->CAST;
	}

	final public function __toString() { return is_resource($this->LINK) ? sprintf('%sconnected %s:%s@%s', ($this->HARDWIRED ? 'p' : ''), $this->LOGIN, $this->PASSWORD, $this->SERVER) : 'disconnected'; }

}


// обертка на стандартные функции СУБД MySQL
class Z_MySQL_MULTIPLE
{
	const VESION = '0.2.0';
	final public static function version() { return self::VESION; }

/** /
	(bool) cast()
	(bool) debug()
	(bool) speed()
	(int) speed_sensitivity()
	(array) autoquery()
	(string) database()
	(string) db()
	(int) flag()
	(bool) hardwired()
	(string) login()
	(string) user()
	(string) password()
	(string) server()
	(string) host()
	(&array) &dbms((int | null) $index = null)
	(mixed) dbms_call((function) $call, (array) $data = null, (int) $index = null)
	(int) dbms_current()
	(bool) dbms_free((int) $index)

	(void) __construct((array | null) $data = null)
	(void) __destruct()
	(void) __clone()
	(void) __sleep()
	(void) __wakeup()
	(string) __toString()

	(bool) db_create((string) $db = null)
	(bool) db_drop((string) $db = null)
	(mixed) db_query((string) $query = null, (string) $db = null)
	(resource) query((string) $query = null)
	(resource) q((string) $query = null)
	(array | bool) query_all((string) $q = null, (int | string) $t = null, (int | null | string) $f = null, (int | null | string) $k = null)
	(array | bool) q_all((string) $q = null, (int | string) $t = null, (int | null | string) $f = null, (int | null | string) $k = null)
	(array | bool) q2((string) $q = null, (int | string) $t = null, (int | null | string) $f = null, (int | null | string) $k = null)
	(double | int | null | string) query_one((string) $q = null, (int) $r = null, (int | null | string) $f = null)
	(double | int | null | string) q_one((string) $q = null, (int) $r = null, (int | null | string) $f = null)
	(double | int | null | string) q0((string) $q = null, (int) $r = null, (int | null | string) $f = null)
	(int) query_rall((string) $q = null, (function) $c = null, (int | string) $t = null, (array | mixed) $d = null)
	(int) q_rall((string) $q = null, (function) $c = null, (int | string) $t = null, (array | mixed) $d = null)
	(int) q3((string) $q = null, (function) $c = null, (int | string) $t = null, (array | mixed) $d = null)
	(array | bool) query_row((string) $q = null, (int | string) $t = null, (int | null | string) $f = null)
	(array | bool) q_row((string) $q = null, (int | string) $t = null, (int | null | string) $f = null)
	(array | bool) q1((string) $q = null, (int | string) $t = null, (int | null | string) $f = null)
	(double) query_speed()
	(double) q_speed()

	(resource) uquery((string) $query = null)
	(resource) u((string) $query = null)
	(array | bool) uquery_all((string) $q = null, (int | string) $t = null, (int | null | string) $f = null, (int | null | string) $k = null)
	(array | bool) u_all((string) $q = null, (int | string) $t = null, (int | null | string) $f = null, (int | null | string) $k = null)
	(array | bool) u2((string) $q = null, (int | string) $t = null, (int | null | string) $f = null, (int | null | string) $k = null)
	(int) uquery_rall((string) $q = null, (function) $c = null, (int | string) $t = null, (array | mixed) $d = null)
	(int) u_rall((string) $q = null, (function) $c = null, (int | string) $t = null, (array | mixed) $d = null)
	(int) u3((string) $q = null, (function) $c = null, (int | string) $t = null, (array | mixed) $d = null)
	(array | bool) uquery_row((string) $q = null, (int | string) $t = null, (int | null | string) $f = null)
	(array | bool) u_row((string) $q = null, (int | string) $t = null, (int | null | string) $f = null)
	(array | bool) u1((string) $q = null, (int | string) $t = null, (int | null | string) $f = null)
	(double) uquery_speed()
	(double) u_speed()
	(bool) free((resource) $result)
	(string) quote((string) $string = '', (array | int | string) $mask = 0)
	(string) quote_real((string) $string = '', (array | int | string) $mask = 0)
/**/

	const COMPRESS = Z_MySQL_SINGLE::COMPRESS;
	const INTERACTIVE = Z_MySQL_SINGLE::INTERACTIVE;
	const SPACE = Z_MySQL_SINGLE::SPACE;

	const CAST = Z_MySQL_SINGLE::CAST;
	private $CAST = self::CAST;
	final public function  cast() { return $this->CAST; }

	const DEBUG = Z_MySQL_SINGLE::DEBUG;
	private $DEBUG = self::DEBUG;
	final public function  debug() { return $this->DEBUG; }

	const SPEED = Z_MySQL_SINGLE::SPEED;
	private $SPEED = self::SPEED;
	final public function  speed() { return $this->SPEED; }

	const SPEED_SENSITIVITY = Z_MySQL_SINGLE::SPEED_SENSITIVITY;
	private $SPEED_SENSITIVITY = self::SPEED_SENSITIVITY;
	final public function  speed_sensitivity() { return $this->SPEED_SENSITIVITY; }


	private $AUTOQUERY = array();
	final public function  autoquery() { return $this->AUTOQUERY; }

	private $DATABASE = null;
	final public function  database() { return $this->DATABASE; }
	final public function  db() { return $this->DATABASE; }

	private $FLAG = null;
	final public function  flag() { return $this->FLAG; }

	private $HARDWIRED = null;
	final public function  hardwired() { return $this->HARDWIRED; }

	private $LOGIN = null;
	final public function  login() { return $this->LOGIN; }
	final public function  user() { return $this->LOGIN; }

	private $PASSWORD = null;
	final public function  password() { return $this->PASSWORD; }

	private $SERVER = null;
	final public function  server() { return $this->SERVER; }
	final public function  host() { return $this->SERVER; }


	// DBMSs
	private $DBMSs = array();
	private $DBMSs_current = null;
	private $DBMSs_sequence = 0;

	final private function DBMSs_clear()
	{
		foreach (array_keys($this->DBMSs) as $i) { $this->DBMSs_delete($i); }
		$this->DBMSs = array();
		$this->DBMSs_current = null;
		$this->DBMSs_sequence = 0;
		return true;
	}

	final private function DBMSs_current() { return $this->DBMSs_current; }

	final private function DBMSs_delete($index = null)
	{
		if (array_key_exists($index, $this->DBMSs))
		{
			$this->DBMSs[$index]['DBMS']->close();
			$this->DBMSs[$index] = $this->DBMSs[$index]['DBMS'] = $this->DBMSs[$index]['OCCUPIED'] = null;
			unset($this->DBMSs[$index]['DBMS'], $this->DBMSs[$index]['OCCUPIED'], $this->DBMSs[$index]);
			if ($index === $this->DBMSs_current) $this->DBMSs_current = null;
			return true;
		}
		return false;
	}

	final private function DBMSs_new()
	{
		$data = array(
				'DEBUG' => $this->DEBUG,
				'SPEED' => $this->SPEED,
				'SPEED_SENSITIVITY' => $this->SPEED_SENSITIVITY,
				'CAST' => $this->CAST,
				'AUTOQUERY' => $this->AUTOQUERY,
				'DATABASE' => $this->DATABASE,
				'FLAG' => $this->FLAG,
				'HARDWIRED' => $this->HARDWIRED ? 'HARDWIRED' : true,
				'LOGIN' => $this->LOGIN,
				'PASSWORD' => $this->PASSWORD,
				'SERVER' => $this->SERVER
			);
		$class = 'Z_MySQL_SINGLE';
		$this->DBMSs[$this->DBMSs_sequence] = array('DBMS' => new $class($data), 'OCCUPIED' => false);
		return $this->DBMSs_sequence++;
	}

	final private function DBMSs_occupied($index = null) { return array_key_exists($index, $this->DBMSs) ? $this->DBMSs[$index]['OCCUPIED'] : true; }

	final private function DBMSs_occupy_set($index, $state)
	{
		if (!array_key_exists($index, $this->DBMSs)) return false;
		$this->DBMSs[$index]['OCCUPIED'] = (bool)$state;
		return true;
	}


	final private function DBMSs_next()
	{
		foreach (array_keys($this->DBMSs) as $index) { if ($this->DBMSs_occupied($index)) { $this->DBMSs_occupy_set($index, true); return $index; } }
		return $this->DBMSs_new();
	}

	final private function DBMSs_call($call, $data = null, $index = null)
	{
		$index = $this->DBMSs_occupied($index) ? $this->DBMSs_next() : $index;
		$this->DBMSs_occupy_set($index, true);
		$this->DBMSs_current = $index;
		if ($data === null) $data = array(); elseif (!is_array($data)) $data = array(&$data);
		$call = (string)$call;
		$dbms = &$this->DBMSs[$index]['DBMS'];
		if (is_object($dbms) && method_exists($dbms, $call)) $return = call_user_func_array(array($dbms, $call), $data);
		else throw new Exception(sprintf('Call method MySQL->%s is unknown', $call), 99);
		$this->DBMSs_current = $index;
		$this->DBMSs_occupy_set($index, false);
		return $return;
	}


	final public function  &dbms($index = null)
	{
		$index = $this->DBMSs_occupied($index) ? $this->DBMSs_next() : $index;
		$this->DBMSs_occupy_set($index, true);
		$this->DBMSs_current = $index;
		return $this->DBMSs[$index]['DBMS'];
	}

	final public function  dbms_call($call, $data = null, $index = null) { return $this->DBMSs_call($call, $data, $index); }

	final public function  dbms_current() { return $this->DBMSs_current(); }

	final public function  dbms_free($index) { return $this->DBMSs_occupy_set($index, false); }


	//
	final public function __construct($data = null)
	{
		if (is_array($data))
		{
			$data = array_change_key_case($data, CASE_UPPER);
			// DEBUG
			if (array_key_exists('DEBUG', $data)) $this->DEBUG = $data['DEBUG'];
			// SPEED
			if (array_key_exists('SPEED', $data)) $this->SPEED = $data['SPEED'];
			// SPEED_SENSITIVITY
			if (array_key_exists('SPEED_SENSITIVITY', $data)) $this->SPEED_SENSITIVITY = $data['SPEED_SENSITIVITY'];
			elseif (array_key_exists('SPEED_S', $data)) $this->SPEED_SENSITIVITY = $data['SPEED_S'];
			// CAST
			if (array_key_exists('CAST', $data)) $this->CAST = $data['CAST'];
			// AUTOQUERY
			if (array_key_exists('AUTOQUERY', $data)) $AUTOQUERY = $data['AUTOQUERY'];
			elseif (array_key_exists('QUERY', $data)) $AUTOQUERY = $data['QUERY'];
			elseif (array_key_exists('AUTO', $data)) $AUTOQUERY = $data['AUTO'];
			elseif (array_key_exists('AQ', $data)) $AUTOQUERY = $data['AQ'];
			elseif (array_key_exists('Q', $data)) $AUTOQUERY = $data['Q'];
			elseif (array_key_exists(6, $data)) $AUTOQUERY = $data[6];
			else $AUTOQUERY = null;
			$this->AUTOQUERY = is_array($AUTOQUERY) || is_string($AUTOQUERY) ? $AUTOQUERY : null;
			// DATABASE
			if (array_key_exists('DATABASE', $data)) $DATABASE = $data['DATABASE'];
			elseif (array_key_exists('DB', $data)) $DATABASE = $data['DB'];
			elseif (array_key_exists('D', $data)) $DATABASE = $data['D'];
			elseif (array_key_exists('BASE', $data)) $DATABASE = $data['BASE'];
			elseif (array_key_exists('B', $data)) $DATABASE = $data['B'];
			elseif (array_key_exists(5, $data)) $DATABASE = $data[5];
			else $DATABASE = 'mysql';
			$this->DATABASE = (string)$DATABASE;
			// FLAG
			if (array_key_exists('FLAG', $data)) $FLAG = $data['FLAG'];
			elseif (array_key_exists('F', $data)) $FLAG = $data['F'];
			elseif (array_key_exists(4, $data)) $FLAG = $data[4];
			else $FLAG = null;
			$this->FLAG = is_int($FLAG) ? (int)$FLAG : null;
			// HARDWIRED
			if (array_key_exists('HARDWIRED', $data)) $HARDWIRED = $data['HARDWIRED']; // ''
			elseif (array_key_exists('NEW', $data)) $HARDWIRED = $data['NEW']; // { null | false | true }
			elseif (array_key_exists(3, $data)) $HARDWIRED = $data[3];
			else $HARDWIRED = true;
			$this->HARDWIRED = is_string($HARDWIRED) || is_bool($HARDWIRED) ? $HARDWIRED : null;
			// LOGIN
			if (array_key_exists('LOGIN', $data)) $LOGIN = $data['LOGIN'];
			elseif (array_key_exists('L', $data)) $LOGIN = $data['L'];
			elseif (array_key_exists('USER', $data)) $LOGIN = $data['USER'];
			elseif (array_key_exists('U', $data)) $LOGIN = $data['U'];
			elseif (array_key_exists(1, $data)) $LOGIN = $data[1];
			else $LOGIN = 'root';
			$this->LOGIN = (string)$LOGIN;
			// PASSWORD
			if (array_key_exists('PASSWORD', $data)) $PASSWORD = $data['PASSWORD'];
			elseif (array_key_exists('PASS', $data)) $PASSWORD = $data['PASS'];
			elseif (array_key_exists('PWD', $data)) $PASSWORD = $data['PWD'];
			elseif (array_key_exists('P', $data)) $PASSWORD = $data['P'];
			elseif (array_key_exists(2, $data)) $PASSWORD = $data[2];
			else $PASSWORD = false;
			$this->PASSWORD = is_string($PASSWORD) ? $PASSWORD : false;
			// SERVER
			if (array_key_exists('SERVER', $data)) $SERVER = $data['SERVER'];
			elseif (array_key_exists('SRV', $data)) $SERVER = $data['SRV'];
			elseif (array_key_exists('HOST', $data)) $SERVER = $data['HOST'];
			elseif (array_key_exists(0, $data)) $SERVER = $data[0];
			else $SERVER = 'localhost';
			$this->SERVER = (string)$SERVER;
		}
		else
		{
			$this->DEBUG = self::DEBUG;
			$this->SPEED = self::SPEED;
			$this->SPEED_SENSITIVITY = self::SPEED_SENSITIVITY;
			$this->CAST = self::CAST;
			$this->AUTOQUERY = array();
			$this->DATABASE = null;
			$this->FLAG = null;
			$this->HARDWIRED = null;
			$this->LOGIN = null;
			$this->PASSWORD = null;
			$this->SERVER = null;
		}

		$this->DBMSs = array();
		$this->DBMSs_current = null;
		$this->DBMSs_sequence = 0;
	}

	final public function __destruct() { $this->DBMSs_clear(); }

	final public function __clone()
	{
		//$this->DEBUG;
		//$this->SPEED;
		//$this->SPEED_SENSITIVITY;
		//$this->CAST;
		//$this->AUTOQUERY;
		//$this->DATABASE;
		//$this->FLAG;
		//$this->HARDWIRED;
		//$this->LOGIN;
		//$this->PASSWORD;
		//$this->SERVER;
		$this->DBMSs = array();
		$this->DBMSs_current = null;
		$this->DBMSs_sequence = 0;
	}

	final public function __sleep() { return array('DEBUG', 'SPEED', 'SPEED_SENSITIVITY', 'CAST', 'AUTOQUERY', 'DATABASE', 'FLAG', 'HARDWIRED', 'LOGIN', 'PASSWORD', 'SERVER'); }

	final public function __wakeup() { $this->DBMSs = array(); $this->DBMSs_current = null; $this->DBMSs_sequence = 0;}

	final public function __toString()
	{
		$return = array();
		foreach ($this->DBMSs as $i => &$dbms)
		{
			if (array_key_exists('DBMS', $dbms))
			{
				$r = (string)$dbms['DBMS'];
				if (array_key_exists('OCCUPIED', $dbms) && ($dbms['OCCUPIED'] === false)) $r .= ', busy';
				$return[] = $r;
			}
		}
		return join("\n\n", $return);
	}


	final public function  db_create($db = null) { return $this->dbms_call(__FUNCTION__, array(&$db)); }
	final public function  db_drop($db = null) { return $this->dbms_call(__FUNCTION__, array(&$db)); }
	final public function  db_query($query = null, $db = null) { return $this->dbms_call(__FUNCTION__, array(&$query, &$db)); }


	final public function  query($query = null) { return $this->dbms_call(__FUNCTION__, array(&$query)); }
	final public function  q($query = null) { return $this->dbms_call(__FUNCTION__, array(&$query)); }

	final public function  query_all($q = null, $t = null, $f = null, $k = null) { return $this->dbms_call(__FUNCTION__, array(&$q, &$t, &$f, &$k)); }
	final public function  q_all($q = null, $t = null, $f = null, $k = null) { return $this->dbms_call(__FUNCTION__, array(&$q, &$t, &$f, &$k)); }
	final public function  q2($q = null, $t = null, $f = null, $k = null) { return $this->dbms_call(__FUNCTION__, array(&$q, &$t, &$f, &$k)); }

	final public function  query_one($q = null, $r = null, $f = null) { return $this->dbms_call(__FUNCTION__, array(&$q, &$r, &$f)); }
	final public function  q_one($q = null, $r = null, $f = null) { return $this->dbms_call(__FUNCTION__, array(&$q, &$r, &$f)); }
	final public function  q0($q = null, $r = null, $f = null) { return $this->dbms_call(__FUNCTION__, array(&$q, &$r, &$f)); }

	final public function  query_rall($q = null, $c = null, $t = null, $d = null) { return $this->dbms_call(__FUNCTION__, array(&$q, &$c, &$t, &$d)); }
	final public function  q_rall($q = null, $c = null, $t = null, $d = null) { return $this->dbms_call(__FUNCTION__, array(&$q, &$c, &$t, &$d)); }
	final public function  q3($q = null, $c = null, $t = null, $d = null) { return $this->dbms_call(__FUNCTION__, array(&$q, &$c, &$t, &$d)); }

	final public function  query_row($q = null, $t = null, $f = null) { return $this->dbms_call(__FUNCTION__, array(&$q, &$t, &$f)); }
	final public function  q_row($q = null, $t = null, $f = null) { return $this->dbms_call(__FUNCTION__, array(&$q, &$t, &$f)); }
	final public function  q1($q = null, $t = null, $f = null) { return $this->dbms_call(__FUNCTION__, array(&$q, &$t, &$f)); }

	final public function  query_speed() { return $this->dbms_call(__FUNCTION__, array()); }
	final public function  q_speed() { return $this->dbms_call(__FUNCTION__, array()); }


	final public function  uquery($query = null) { return $this->dbms_call(__FUNCTION__, array(&$query)); }
	final public function  u($query = null) { return $this->dbms_call(__FUNCTION__, array(&$query)); }

	final public function  uquery_all($q = null, $t = null, $f = null, $k = null) { return $this->dbms_call(__FUNCTION__, array(&$q, &$t, &$f, &$k)); }
	final public function  u_all($q = null, $t = null, $f = null, $k = null) { return $this->dbms_call(__FUNCTION__, array(&$q, &$t, &$f, &$k)); }
	final public function  u2($q = null, $t = null, $f = null, $k = null) { return $this->dbms_call(__FUNCTION__, array(&$q, &$t, &$f, &$k)); }

	final public function  uquery_rall($q = null, $c = null, $t = null, $d = null) { return $this->dbms_call(__FUNCTION__, array(&$q, &$c, &$t, &$d)); }
	final public function  u_rall($q = null, $c = null, $t = null, $d = null) { return $this->dbms_call(__FUNCTION__, array(&$q, &$c, &$t, &$d)); }
	final public function  u3($q = null, $c = null, $t = null, $d = null) { return $this->dbms_call(__FUNCTION__, array(&$q, &$c, &$t, &$d)); }

	final public function  uquery_row($q = null, $t = null, $f = null) { return $this->dbms_call(__FUNCTION__, array(&$q, &$t, &$f)); }
	final public function  u_row($q = null, $t = null, $f = null) { return $this->dbms_call(__FUNCTION__, array(&$q, &$t, &$f)); }
	final public function  u1($q = null, $t = null, $f = null) { return $this->dbms_call(__FUNCTION__, array(&$q, &$t, &$f)); }

	final public function  uquery_speed() { return $this->dbms_call(__FUNCTION__, array()); }
	final public function  u_speed() { return $this->dbms_call(__FUNCTION__, array()); }

	final public function  free($result) { return $this->dbms_call(__FUNCTION__, array(&$result)); }
	final public function  quote($string = '', $mask = 0) { return $this->dbms_call(__FUNCTION__, array(&$string, &$mask)); }
	final public function  quote_real($string = '', $mask = 0) { return $this->dbms_call(__FUNCTION__, array(&$string, &$mask)); }

}


class Z_MySQL_SIMPLE extends Z_MySQL_SINGLE { }
class Z_MySQL_MANY extends Z_MySQL_MULTIPLE { }


class Z_MySQL extends Z_MySQL_SINGLE { }
class Z_MySQLs extends Z_MySQL_MULTIPLE { }

/** /
$db = array('localhost', 'test', 'test', true, null, 'test', array('SET CHARACTER SET cp1251;', "SET NAMES 'cp1251';"));
/** /
echo '<pre>';

$DB = new Z_MySQL($db);

$q = $DB->q('SELECT 1, 1/2 as `xxx`, FALSE, NULL, DATE_FORMAT(NOW(), "%Y"), 1243653333333, 123213.123;');
var_dump($q);

$r = $DB->q0('SELECT * FROM my_f2006 WHERE 1=1;', 1, 'text1');
var_dump($r);

$r = $DB->q1('SELECT * FROM my_f2006 WHERE 1=1 LIMIT 100, 1;', 'row');
print_r($r);

$r = $DB->q2('SELECT * FROM my_f2006 WHERE 1=1;', 'object');
print_r($r);

$r = $DB->q3('SELECT * FROM my_f2006 WHERE 1=1;', create_function('$d, $i, $dd', 'print_r($d);'), 'assoc', 'xxxx');
var_dump($r);

echo '</pre>';
/** /
echo '<pre>';

$DB = new Z_MySQLs($db);

$q = $DB->q('SELECT 1, 1/2 as `xxx`, FALSE, NULL, DATE_FORMAT(NOW(), "%Y"), 1243653333333, 123213.123;');
var_dump($q);

$r = $DB->q0('SELECT * FROM my_f2006 WHERE 1=1;', 1, 'text1');
var_dump($r);

$r = $DB->q1('SELECT * FROM my_f2006 WHERE 1=1 LIMIT 100, 1;', 'row');
print_r($r);

$r = $DB->q2('SELECT * FROM my_f2006 WHERE 1=1;', 'object');
print_r($r);

$r = $DB->q3('SELECT * FROM my_f2006 WHERE 1=1;', create_function('$d, $i, $dd', 'print_r($d);'), 'assoc', 'xxxx');
var_dump($r);

echo '</pre>';
/** /
exit;
/**/

?>