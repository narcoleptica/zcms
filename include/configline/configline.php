<?

class Z_CONFIGLINE
{
	const VESION = '1.0.0';
	final public static function version() { return self::VESION; }

	// Флаг работы в режиме отладки: DEBUG
	const DEBUG = false;
	private static $DEBUG = self::DEBUG;
	final public static function debug($debug = null)
	{
		if ($debug === (bool)$debug) self::$DEBUG = (bool)$debug;
		return (bool)self::$DEBUG;
	}

	final public static function do_throw ($message = null)
	{
		if (self::$DEBUG === false) return;
		elseif (func_num_args() > 1) { $message = func_get_args(); $message = join('', $message); }
		if (self::$DEBUG) throw new Exception($message);
		else
		{
			print $message;
			exit;
		}
	}

	final public static function get_value_by_key ($data, $keys = null)
	{
		static $__FUNCTION__ = __FUNCTION__;
		if ($keys === null) $return = &$data;
		elseif (is_string($keys) && (strlen($keys) > 0)) { $return = &self::$__FUNCTION__(&$data, array($keys)); }
		elseif (is_array($keys) && (count($keys) > 0))
		{
			$return = &$data;
			foreach($keys as $key)
			{
				if (!array_key_exists($key, $return))
				{
					self::do_throw('Error Z_CONFIGLINE.get_value_by_key: key [', join('.', $keys), '] not found');
				}
				$return = &$return[$key];
			}
		}
		else self::do_throw('Error Z_CONFIGLINE.get_value_by_key: Invalid key [', $keys, ']');
		return $return;
	}

	final public static function set_value_by_key (&$data, $keys, $value)
	{
		static $__FUNCTION__ = __FUNCTION__;
		if ($keys === null) self::do_throw('Error Z_CONFIGLINE.set_value_by_key: empty key');
		elseif (is_string($keys) && (strlen($keys) > 0)) { self::$__FUNCTION__($data, array($keys), &$value); }
		elseif (is_array($keys) && (count($keys) > 0))
		{
			$keyL = array_pop($keys);
			$pointer = &$data;
			foreach($keys as $key)
			{
				if (!is_array($pointer)) { self::do_throw('Error Z_CONFIGLINE.set_value_by_key: overwriting key [', $key, ']'); }
				elseif ($key === '')
				{
					$pointer[] = array();
					end($pointer);
					$key = key($pointer);
				}
				elseif (!array_key_exists($key, $pointer)) { $pointer[$key] = array(); }
				elseif (!is_array($pointer[$key])) { self::do_throw('Error Z_CONFIGLINE.set_value_by_key: overwriting key [', $key, ']'); }
				$pointer = &$pointer[$key];
			}
			if ($keyL === '')
			{
				$pointer[] = null;
				end($pointer);
				$keyL = key($pointer);
			}
			elseif (array_key_exists($keyL, $pointer)) { self::do_throw('Error Z_CONFIGLINE.set_value_by_key: overwriting key [', $keyL, ']'); }
			$pointer[$keyL] = $value;
		}
		else self::do_throw('Error Z_CONFIGLINE.set_value_by_key: invalid key [', $keys, ']');
		return true;
	}

	final public static function parse_alias_applay ($data, $alias = null, $ALIAS = null)
	{
		static $__FUNCTION__ = __FUNCTION__;
		if (is_array($alias) && (count($alias) > 0))
		{
			$return = $data;
			$maxcount = 10;
			//
			$pattern = $replace = array();
			foreach($alias as $k => $v)
			{
				$pattern[] = '%' . $k . '%';
				$replace[] = $v;
			}
			// !!! не экранирования % для не alias
			do { $return = str_replace($pattern, $replace, $return, $count); } while (($count > 0) && ($maxcount-- > 0));
			return $return;
		}
		else return $data;
	}

	final public static function parse_keys ($keys, $alias = null, $ALIAS = null)
	{
		$return = self::parse_alias_applay((string)$keys, $alias, $ALIAS);
		$return = explode('.', $return);
		return $return;
	}

	final public static function parse_value ($value, $alias = null, $ALIAS = null)
	{
		$return = preg_replace('"^ [\"] (.*?) [\"] $"xu', '$1', (string)$value);
		$return = self::parse_alias_applay($return, $alias, $ALIAS);
		if (preg_match('"^ [\[] (a|array|b|bool|d|double|i|int|f|float|n|null|r|real|s|string) [\]] [\s]* [\:] [\s]* (.*?) $"xi', $return, $result))
		{
			if ($result[1] === 'a') $return = (array)$result[2];
			elseif ($result[1] === 'array') $return = (array)$result[2];
			elseif ($result[1] === 'b') $return = (bool)$result[2];
			elseif ($result[1] === 'bool') $return = (bool)$result[2];
			elseif ($result[1] === 'd') $return = (double)$result[2];
			elseif ($result[1] === 'double') $return = (double)$result[2];
			elseif ($result[1] === 'i') $return = (int)$result[2];
			elseif ($result[1] === 'int') $return = (int)$result[2];
			elseif ($result[1] === 'f') $return = (float)$result[2];
			elseif ($result[1] === 'float') $return = (float)$result[2];
			elseif ($result[1] === 'n') $return = null;
			elseif ($result[1] === 'null') $return = null;
			elseif ($result[1] === 'r') $return = (float)$result[2];
			elseif ($result[1] === 'real') $return = (float)$result[2];
			elseif ($result[1] === 's') $return = (string)$result[2];
			elseif ($result[1] === 'string') $return = (string)$result[2];
			else $return = (string)$result[2];
		}
		unset($result);
		return $return;
	}

	private $ROOT = null;
	private $FILES = array();
	private $ALIAS = array();
	private $CONFIG = array();
	public function __construct($debug = null, $root = null)
	{
		$this->ROOT = ($root && is_dir($root)) ? (string)$root : (string)$_SERVER['DOCUMENT_ROOT'];
		$this->debug($debug);
	}

	public function __destruct () {}

	final public function string ($string = null)
	{
		if (!is_string($string)) return false;
print "===\n";
var_dump($string);
		static $pattern_line = '"^ [\s]* ((?>.*)) [\s]* $"mxSu';
		static $pattern_comment = '"^ [\#] .* $"xSu';
		static $pattern_file = '"^ (?:include|load) [\s]* (.*) $"xSui';
		static $pattern_ALIAS = '"^ [\%]{2} ([^\=]+?) [\%]{2} [\s]* [\=] [\s]* (.*) $"xSu';
		static $pattern_alias = '"^ [\%] ([^\=]+?) [\%] [\s]* [\=] [\s]* (.*) $"xSu';
		static $pattern_key_value = '"^ ([^\=]+?) [\s]* [\=] [\s]* (.*) $"xSu';
		$alias = $this->ALIAS;
		$offset = 0;
		while ((strlen($string) > $offset) && preg_match($pattern_line, $string, $line, PREG_OFFSET_CAPTURE, $offset))
		{
			$doffset = max((int)$line[0][1], 0);
			$line = (string)$line[1][0];
			$dlength = max((int)strlen($line), 0);
			$offset = $doffset + $dlength;
var_dump($line);
			if (preg_match($pattern_comment, $line)) continue;
			elseif (preg_match($pattern_file, $line, $d))
			{
				$file = self::parse_value((string)$d[1], $alias);
				$this->file($file);
			}
			elseif (preg_match($pattern_ALIAS, $line, $d))
			{
				$keys = self::parse_alias_applay((string)$d[1], $alias, $this->ALIAS);
				$value = self::parse_value($d[2], $alias);
				$this->ALIAS[$keys] = $alias[$keys] = $value;
			}
			elseif (preg_match($pattern_alias, $line, $d))
			{
				$keys = self::parse_alias_applay((string)$d[1], $alias, $this->ALIAS);
				$value = self::parse_value($d[2], $alias);
				$alias[$keys] = $value;
			}
			elseif (preg_match($pattern_key_value, $line, $d))
			{
				$keys = self::parse_keys($d[1], $alias);
				$value = self::parse_value($d[2], $alias);
				self::set_value_by_key($this->CONFIG, $keys, $value);
			}
		}
		return true;
	}

	final public function file ($files = null, $root = null)
	{
		static $__FUNCTION__ = __FUNCTION__;
		if (is_string($files) && (strlen($files) > 0))
		{
			if (!is_dir($root)) $root = $this->ROOT;
			else
			{
				static $REroot = null;
				if ($REroot === null)
				{
					foreach(explode(' ', '\\ + * ? [ ^ ] $ ( ) { } = ! < > | : " \' / - _') as $c)
					{
						$pattern[] = $c;
						$replace[] = sprintf('[\\%s]', $c);
					}
					$REroot = '"' . str_replace($pattern, $replace, $this->ROOT) . '"';
				}
				// !!! временный root вложен в ROOT сайта
				if (!preg_match($REroot, (string)$root)) $root = $this->ROOT;
			}
			$file = sprintf('%s/%s', $root, preg_replace('"^[\/\\\\]"', '', preg_replace('"[\/\\\\]"', '/', $files)));
			if (in_array($file, $this->FILES))
			{
				self::do_throw('Error Z_CONFIGLINE.file: file [', $file, '] included twice');
				$return = false;
			}
			elseif (is_file($file))
			{
				$string = file_get_contents($file);
				$this->FILES[] = $file;
				$return = $this->string(&$string);
				unset($string);
			}
			else
			{
				self::do_throw('Error Z_CONFIGLINE.file: file [', $file, '] not exists');
				$return = false;
			}
		}
		elseif (is_array($files) && (count($files) > 0))
		{
			$return = false;
			foreach($files as $file) { $return |= $this->$__FUNCTION__($file, $root); }
		}
		return $return;
	}

	final public function clear ()
	{
		$this->FILES = $this->ALIAS = $this->CONFIG = array();
	}

	final public function get ($key = null)
	{
		if (func_num_args() > 1) $keys = func_get_args();
		elseif (is_string($key) && (strlen($key) > 0)) $keys = explode('.', $key);
		else $keys = &$key;
		$return = &self::get_value_by_key(&$this->CONFIG, &$keys);
		return $return;
	}

	final public function set ($key, $value)
	{
		if (is_string($key) && (strlen($key) > 0)) $keys = explode('.', $key);
		else $keys = &$key;
		return self::set_value_by_key(&$this->CONFIG, &$keys, $value);
	}
}

?>