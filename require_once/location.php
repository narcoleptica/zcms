<?

class Z_LOCATION
{

	const PRE = 'PRE';
	const HOST = 'HOST';
	const PATH = 'PATH';
	const DATA = 'DATA';
	const POST = 'POST';
	const ROOT = 'ROOT';
	const PDATA = 'PDATA';

	static private $toPATTERN = array(
			self::PRE => '^(https?|ftp|file)$',
			self::HOST => '^[\\w\\d\\-\\_\\:\\@]+$',
			self::PATH => '^[\\w\\d\\-\\_\\%\\+]+$',
			self::DATA => '^[\\w\\d\\-\\_\\%\\+]+$',
			self::POST => '^[\\w\\d\\-\\_]+$'
		);

	final static private function toPRE(&$old, $new = null)
	{
		return (string)(preg_match("'" . self::$toPATTERN[self::PRE] . "'", (string)$new) ? $new : $old);
	}

	final static private function toHOST(&$old, $new = null, $flag = 0)
	{
		$f = (int)$flag;
		if (is_array($new))
		{
			$host = ($f === 0) ? array() : $old;
			$PATTERN = "'" . self::$toPATTERN[self::HOST] . "'";
			foreach($new as $d)
			{
				$d = (string)$d;
				if (!(strlen($d) > 0)) continue;
				if (!preg_match($PATTERN, $d)) continue;
				($f > 0) ? array_unshift($host, $d) : array_push($host, $d);
			}
			return $host;
		}
		elseif (is_string($new))
		{
			$host = split('\\.', (string)$new);
			if ($f > 0)$host = array_reverse($host, true);
			$F = __FUNCTION__;
			return self::$F($old, $host, $f);
		}
		return $old;
	}

	final static private function toPATH(&$old, $new = null, $flag = 0)
	{
		$f = (int)$flag;
		if (is_array($new))
		{
			$path = ($f === 0) ? array() : $old;
			$PATTERN = "'" . self::$toPATTERN[self::PATH] . "'";
			foreach($new as $d)
			{
				$d = (string)$d;
				if (!(strlen($d) > 0)) continue;
				//if (!preg_match($PATTERN, $d)) continue;
				$d = (string)urlencode((string)urldecode((string)$d));
				($f < 0) ? array_unshift($path, $d) : array_push($path, $d);
			}
			return $path;
		}
		elseif (is_scalar($new))
		{
			$path = (string)$new;
			$path = (string)preg_replace("'" . '^\\/?(.*?)\\/?(?:\\?.*)?$' . "'", '\\1', (string)$new);
			$path = split('\\/', $path);
			if ($f < 0) $path = array_reverse($path, true);
			$F = __FUNCTION__;
			return self::$F($old, $path, $f);
		}
		return $old;
	}

	final static private function toDATA(&$old, $new = null, $flag = 0) // flag > 0 - новов значене актуальнее
	{
		$f = (int)$flag;
		if (is_array($new))
		{
			$data = ($f === 0) ? array() : $old;
			$PATTERN = "'" . self::$toPATTERN[self::DATA] . "'";
			foreach($new as $key => $d)
			{
				//if (!(strlen($d) > 0)) continue;
				//if (!preg_match($PATTERN, $key)) continue;
				//if (!preg_match($PATTERN, $d)) continue;
				if (is_int($key)) $data[] = $d;
				elseif (!array_key_exists($key, $data) || ($f > 0)) $data[$key] = $d;
			}
			return $data;
		}
		elseif (is_scalar($new))
		{
			parse_str((string)$new, $data);
			$F = __FUNCTION__;
			return self::$F($old, $data, &$flag);
		}
		return $old;
	}

	final static private function toPOST(&$old, $new = null)
	{
		return (string)(preg_match("'" . self::$toPATTERN[self::POST] . "'", (string)$new) ? $new : $old);
	}


	const PRE_DEFAULT = 'http';

	static private $defaultDataInited = false;
	static private $defaultData = array(
			self::PRE => self::PRE_DEFAULT, // http | https | ftp
			self::HOST => array(), // domain: [H+] a.b.c [H-]
			self::PATH => array(), // request: [P-] /x/y/z/ [P+]
			self::DATA => array(), // get-data: ?param1=data1&param2=data2
			self::POST => '', // anchor: #xxx
			self::ROOT => '', // root: /xxx/xxx/xx/
			self::PDATA => array() // post-data: array()
		);

	final static private function initingDefault()
	{
		if (self::$defaultDataInited) return false;
		self::$defaultDataInited = true;
		try
		{
			if (isset($_SERVER)) $S = &$_SERVER;
			elseif (isset($HTTP_SERVER_VARS)) $S = &$HTTP_SERVER_VARS;
			if (!is_array($S)) throw new Exception('SERVER not found');
			$D = &self::$defaultData;
			// pre
			static $PORTs = array(
					'-' => self::PRE_DEFAULT,
					80 => 'http',
					443 => 'https',
					21 => 'ftp'
				);
			$s0 = 'SERVER_PORT';
			if (array_key_exists($s0, $S)) $D[self::PRE] = self::toPRE($D[self::PRE], (string)$PORTs[array_key_exists($S[$s0], $PORTs) ? $S[$s0] : '-']);
			// host
			$s1 = 'HTTP_HOST';
			if (array_key_exists($s1, $S)) $D[self::HOST] = self::toHOST($D[self::HOST], (string)$S[$s1], 0);
			// path
			static $s2 = 'REDIRECT_URL';
			static $s3 = 'REQUEST_URI';
			if (array_key_exists($s2, $S)) $D[self::PATH] = self::toPATH($D[self::PATH], (string)$S[$s2], 0);
			elseif (array_key_exists($s3, $S)) $D[self::PATH] = self::toPATH($D[self::PATH], (string)$S[$s3], 0);
			// data
			static $s4 = 'QUERY_STRING';
			if (array_key_exists($s4, $S)) $D[self::DATA] = self::toDATA($D[self::DATA], (string)$S[$s4], 0);
			// post
			$D[self::POST] = '';
			// root
			static $s5 = 'DOCUMENT_ROOT';
			if (array_key_exists($s5, $S)) $D[self::ROOT] = preg_replace("'" . '\\/+$' . "'", '', (string)$S[$s5]);
		}
		catch (Exception $E) { }
		//
		try
		{
			if (isset($_POST)) $P = &$_POST;
			elseif (isset($HTTP_POST_VARS)) $P = &$HTTP_POST_VARS;
			if (!is_array($P)) throw new Exception('POST not found');
			$D = &self::$defaultData;
			// pdata
			$D[self::PDATA] = $P;
		}
		catch (Exception $E) { }
	}


	private $constantData = null;

	final static public function init($new = null) { $C = __CLASS__; $return = new $C(); $return->initing($new); return $return; }

	final public function __construct($pre = null, $host = null, $path = null, $data = null, $post = null, $flag = '')
	{
		self::initingDefault();
		$this->constantData = self::$defaultData;
		if (is_array($pre)) $new = (array)$pre;
		else
		{
			$new = array('FLAG' => $flag);
			if ($pre !== null) $new['PRE'] = $pre;
			if ($host !== null) $new['HOST'] = $host;
			if ($path !== null) $new['PATH'] = $path;
			if ($data !== null) $new['DATA'] = $data;
			if ($post !== null) $new['POST'] = $post;
		}
		$this->initing($new);
	}

	final public function __destruct() { }

	final public function __clone() { self::initingDefault(); }

	final public function __sleep() { return array('constantData'); }

	final public function __wakeup() { self::initingDefault(); }

	final public function __toString() { return $this->href(); }


	final public function initing($new = null, $flag = null)
	{
		if (is_array($new))
		{
			$new = array_change_key_case($new, CASE_UPPER);
			// flag
			if (array_key_exists('FLAG', $new)) $flag = $new['FLAG'];
			elseif (array_key_exists('F', $new)) $flag = $new['F'];
			elseif (array_key_exists(5, $new)) $flag = $new[5];
			$flag = (string)$flag;
			$fH = preg_match("'H[\\-\\+]'i", $flag) ? preg_replace("'" . '^.*?H(\\-|\\+).*$' . "'i", '${1}1', $flag) : 0;
			$fP = preg_match("'P[\\-\\+]'i", $flag) ? preg_replace("'" . '^.*?P(\\-|\\+).*$' . "'i", '${1}1', $flag) : 0;
			$fD = preg_match("'D[\\-\\+]'i", $flag) ? preg_replace("'" . '^.*?D(\\-|\\+).*$' . "'i", '${1}1', $flag) : 0;
			// pre
			if (array_key_exists('PRE', $new)) $this->setPRE($new['PRE']);
			elseif (array_key_exists(0, $new)) $this->setPRE($new[0]);
			// host
			if (array_key_exists('HOST', $new)) $this->setHOST($new['HOST'], $fH);
			elseif (array_key_exists('H', $new)) $this->setHOST($new['H'], $fH);
			elseif (array_key_exists(1, $new)) $this->setHOST($new[1], $fH);
			// path
			if (array_key_exists('PATH', $new)) $this->setPATH($new['PATH'], $fP);
			elseif (array_key_exists('P', $new)) $this->setPATH($new['P'], $fP);
			elseif (array_key_exists(2, $new)) $this->setPATH($new[2], $fP);
			// data
			if (array_key_exists('DATA', $new)) $this->setDATA($new['DATA'], $fD);
			elseif (array_key_exists('D', $new)) $this->setDATA($new['D'], $fD);
			elseif (array_key_exists('GET', $new)) $this->setDATA($new['GET'], $fD);
			elseif (array_key_exists('G', $new)) $this->setDATA($new['G'], $fD);
			elseif (array_key_exists(3, $new)) $this->setDATA($new[3], $fD);
			// post
			if (array_key_exists('POST', $new)) $this->setPOST($new['POST']);
			elseif (array_key_exists(4, $new)) $this->setPOST($new[4]);
		}
		elseif (is_string($new))
		{
			$new = parse_url($new, PHP_URL_SCHEME | PHP_URL_HOST | PHP_URL_PORT | PHP_URL_USER | PHP_URL_PASS | PHP_URL_PATH | PHP_URL_QUERY | PHP_URL_FRAGMENT);
			$flag = (string)$flag;
			$fH = preg_match("'H[\\-\\+]'i", $flag) ? preg_replace("'" . '^.*?H(\\-|\\+).*$' . "'i", '${1}1', $flag) : 0;
			$fP = preg_match("'P[\\-\\+]'i", $flag) ? preg_replace("'" . '^.*?P(\\-|\\+).*$' . "'i", '${1}1', $flag) : 0;
			$fD = preg_match("'D[\\-\\+]'i", $flag) ? preg_replace("'" . '^.*?D(\\-|\\+).*$' . "'i", '${1}1', $flag) : 0;
			if (array_key_exists('scheme', $new)) $this->setPRE($new['scheme']);
			//if (array_key_exists('user', $new)) $login = $new['user'];
			//if (array_key_exists('pass', $new)) $password = $new['pass'];
			if (array_key_exists('host', $new)) $this->setHOST($new['host'], $fH);
			if (array_key_exists('path', $new)) $this->setPATH($new['path'], $fP);
			if (array_key_exists('query', $new)) $this->setDATA($new['query'], $fD);
			if (array_key_exists('fragment', $new)) $this->setPOST($new['fragment']);
		}
		return true;
	}

	final public function setPRE($data = null) { $C = &$this->constantData[self::PRE]; $C = self::toPRE($C, $data); return $C; }

	final public function setHOST($data = null, $flag = 0) { $C = &$this->constantData[self::HOST]; $C = self::toHOST($C, $data, $flag); return $C; }

	final public function setPATH($data = null, $flag = 0) { $C = &$this->constantData[self::PATH]; $C = self::toPATH($C, $data, $flag); return $C; }

	final public function setDATA($data = null, $flag = 1) { $C = &$this->constantData[self::DATA]; $C = self::toDATA($C, $data, $flag); return $C; }

	final public function setPOST($data = null) { $C = &$this->constantData[self::POST]; $C = self::toPOST($C, $data); return $C; }


	final public function getPRE() { $C = &$this->constantData[self::PRE]; return $C; }

	final public function getHOST($index = null) { $C = &$this->constantData[self::HOST]; return ($index === null) ? $C : (array_key_exists($index, $C) ? $C[$index] : null); }

	final public function getPATH($index = null) { $C = &$this->constantData[self::PATH]; return ($index === null) ? $C : (array_key_exists($index, $C) ? $C[$index] : null); return (($index !== null) && array_key_exists($index, $C)) ? $C[$index] : $C; }

	final public function getDATA($key = null) { $C = &$this->constantData[self::DATA]; return ($key === null) ? $C : (array_key_exists($key, $C) ? $C[$key] : null); }

	final public function getPOST() { $C = &$this->constantData[self::POST]; return $C; }


	final public function pre() { return $this->getPRE(); }

	final public function host($index = null) { return $this->getHOST($index); }

	final public function path($index = null) { return $this->getPATH($index); }

	final public function data($key = null) { return $this->getDATA($key); }

	final public function post() { return $this->getPOST(); }

	final public function href($pre = null, $host = null, $path = null, $data = null, $post = null, $flag = '')
	{
		if (is_array($pre))
		{
			$new = array_change_key_case($pre, CASE_UPPER);
			$pre = $host = $path = $data = $post = $flag = null;
			// pre
			if (array_key_exists('PRE', $new)) $pre = $new['PRE'];
			elseif (array_key_exists(0, $new)) $pre = $new[0];
			// host
			if (array_key_exists('HOST', $new)) $host = $new['HOST'];
			elseif (array_key_exists('H', $new)) $host = $new['H'];
			elseif (array_key_exists(1, $new)) $host = $new[1];
			// path
			if (array_key_exists('PATH', $new)) $path = $new['PATH'];
			elseif (array_key_exists('P', $new)) $path = $new['P'];
			elseif (array_key_exists(2, $new)) $path = $new[2];
			// data
			if (array_key_exists('DATA', $new)) $data = $new['DATA'];
			elseif (array_key_exists('D', $new)) $data = $new['D'];
			elseif (array_key_exists('GET', $new)) $data = $new['GET'];
			elseif (array_key_exists('G', $new)) $data = $new['G'];
			elseif (array_key_exists(3, $new)) $data = $new[3];
			// post
			if (array_key_exists('POST', $new)) $post = $new['POST'];
			elseif (array_key_exists(4, $new)) $post = $new[4];
			// flag
			if (array_key_exists('FLAG', $new)) $flag = $new['FLAG'];
			elseif (array_key_exists('F', $new)) $flag = $new['F'];
			elseif (array_key_exists(5, $new)) $flag = $new[5];
			$F = __FUNCTION__;
			return $this->$F($pre, $host, $path, $data, $post, $flag);
		}
		else
		{
			$C = &$this->constantData;
			$PATH = $path;
			$flag = (string)$flag;
			$fH = preg_match("'H[\\-\\+]'i", $flag) ? preg_replace("'" . '^.*?H(\\-|\\+).*$' . "'i", '${1}1', $flag) : 0;
			$fP = preg_match("'P[\\-\\+]'i", $flag) ? preg_replace("'" . '^.*?P(\\-|\\+).*$' . "'i", '${1}1', $flag) : 0;
			$fD = preg_match("'D[\\-\\+]'i", $flag) ? preg_replace("'" . '^.*?D(\\-|\\+).*$' . "'i", '${1}1', $flag) : 0;
			$pre = ($pre === null) ? $C[self::PRE] : (($pre === false) ? '' : $this->toPRE($C[self::PRE], $pre));
			$host = ($host === null) ? $C[self::HOST] : $this->toHOST($C[self::HOST], $host, $fH);
			$path = ($path === null) ? $C[self::PATH] : $this->toPATH($C[self::PATH], $path, $fP);
			$data = ($data === null) ? $C[self::DATA] : $this->toDATA($C[self::DATA], $data, $fD);
			$post = ($post === null) ? $C[self::POST] : $this->toPOST($C[self::POST], $post);
			//
			$pre = (strlen($pre) > 0) ? sprintf('%s://', $pre) : '';
			$host = is_array($host) && (count($host) > 0) ? join('.', $host) : '';
			$path = is_array($path) && (count($path) > 0) ? sprintf('/%s/', join('/', $path)) : '/';
			$data = is_array($data) && (count($data) > 0) ? sprintf('?%s', http_build_query($data)) : '';
			$post = (strlen($post) > 0) ? sprintf('#%s', $post) : '';
			if (($PATH === '') && ($path === '/') && !(strlen($data) > 0) && !(strlen($post) > 0)) $path = '';
			$return = sprintf('%s%s%s%s%s', $pre, $host, $path, $data, $post);
			return $return;
		}
	}


	final static private function &__data(&$data, $keys, $throw = array('exception', 0))
	{
		$d = &$data;
		if ($keys === null) $return = &$d;
		elseif (is_scalar($keys))
		{
			$k = $keys;
			if (!is_array($d) || !array_key_exists($k, $d)) throw new Exception($throw[0], $throw[1]);
			$return = &$d[$k];
		}
		elseif (is_array($keys))
		{
			foreach($keys as $k)
			{
				if (!is_array($d) || !array_key_exists($k, $d)) throw new Exception($throw[0], $throw[1]);
				$d = &$d[$k];
			}
			$return = &$d;
		}
		else throw new Exception($throw[0], $throw[1]);
		return $return;
	}

	final static private function dataByKeys(&$data, $keys = null, $default = false) { try { return self::__data($data, $keys); } catch (Exception $E) { return $default; } }

	final static private function dataByKeysToId(&$data, $keys = null, $default = null, $value = null)
	{
		try
		{
			$return = (string)self::__data($data, $keys);
			if (!preg_match("'" . '^[1-9]\\d{0,19}$' . "'", $return)) throw new Exception('wrong ID format');
			if ($value !== null) return ($return === $value) ? true : false;
			return $return;
		}
		catch (Exception $E) { return $default; }
	}

	final static private function dataByKeysToInteger(&$data, $keys = null, $default = null, $min = null, $max = null)
	{
		try
		{
			$return = (int)self::__data($data, $keys);
			if (($min !== null) && ($min > $return)) throw new Exception('INTEGER less then min');
			if (($max !== null) && ($max < $return)) throw new Exception('INTEGER more then max');
			return $return;
		}
		catch (Exception $E) { return $default; }
	}

	final static private function dataByKeysToNumber(&$data, $keys = null, $default = null, $value = null)
	{
		try
		{
			$return = (string)self::__data($data, $keys);
			if (!preg_match("'" . '^[\\-\\+]?[1-9]\\d*$' . "'", $return)) throw new Exception('wrong NUMBER format');
			if ($value !== null) return ($return == $value) ? true : false;
			return $return;
		}
		catch (Exception $E) { return $default; }
	}

	final static private function dataByKeysToString(&$data, $keys = null, $default = null, $case = null, $value = null)
	{
		try
		{
			$return = (string)self::__data($data, $keys);
			if ($case !== null)
			{
				$case = (int)$case;
				if ($case > 0) $return = strtoupper($return);
				if ($case < 0) $return = strtolower($return);
			}
			if ($value !== null) return ($return == $value) ? true : false;
			return $return;
		}
		catch (Exception $E) { return $default; }
	}


	final public function h($index = null, $default = false) { return self::dataByKeys($this->constantData[self::HOST], $index, $default); }

	final public function hId($keys = null, $default = 0, $value = null) { return self::dataByKeysToId($this->constantData[self::HOST], $keys, $default, $value); }

	final public function hInteger($keys = null, $default = 0, $min = null, $max = null) { return self::dataByKeysToInteger($this->constantData[self::HOST], $keys, $default, $min, $max); }

	final public function hNumber($keys = null, $default = 0, $value = null) { return self::dataByKeysToNumber($this->constantData[self::HOST], $keys, $default, $value); }

	final public function hString($keys = null, $default = '', $case = null, $value = null) { return self::dataByKeysToString($this->constantData[self::HOST], $keys, $default, $case, $value); }

	final public function hInt($keys = null, $default = 0, $min = null, $max = null) { return $this->hInteger($keys, $default, $min, $max); }

	final public function hI($keys = null, $default = 0, $min = null, $max = null) { return $this->hInteger($keys, $default, $min, $max); }

	final public function hNum($keys = null, $default = 0, $value = null) { return $this->hNumber($keys, $default, $value); }

	final public function hN($keys = null, $default = 0, $value = null) { return $this->hNumber($keys, $default, $value); }

	final public function hStr($keys = null, $default = '', $case = null, $value = null) { return $this->hString($keys, $default, $case, $value); }

	final public function hS($keys = null, $default = '', $case = null, $value = null) { return $this->hString($keys, $default, $case, $value); }


	final public function r($index = null, $default = false) { return self::dataByKeys($this->constantData[self::PATH], $index, $default); }

	final public function rId($keys = null, $default = 0, $value = null) { return self::dataByKeysToId($this->constantData[self::PATH], $keys, $default, $value); }

	final public function rInteger($keys = null, $default = 0, $min = null, $max = null) { return self::dataByKeysToInteger($this->constantData[self::PATH], $keys, $default, $min, $max); }

	final public function rNumber($keys = null, $default = 0, $value = null) { return self::dataByKeysToNumber($this->constantData[self::PATH], $keys, $default, $value); }

	final public function rString($keys = null, $default = '', $case = null, $value = null) { return self::dataByKeysToString($this->constantData[self::PATH], $keys, $default, $case, $value); }

	final public function rInt($keys = null, $default = 0, $min = null, $max = null) { return $this->rInteger($keys, $default, $min, $max); }

	final public function rI($keys = null, $default = 0, $min = null, $max = null) { return $this->rInteger($keys, $default, $min, $max); }

	final public function rNum($keys = null, $default = 0, $value = null) { return $this->rNumber($keys, $default, $value); }

	final public function rN($keys = null, $default = 0, $value = null) { return $this->rNumber($keys, $default, $value); }

	final public function rStr($keys = null, $default = '', $case = null, $value = null) { return $this->rString($keys, $default, $case, $value); }

	final public function rS($keys = null, $default = '', $case = null, $value = null) { return $this->rString($keys, $default, $case, $value); }


	final public function g($keys = null, $default = false) { return self::dataByKeys($this->constantData[self::DATA], $keys, $default); }

	final public function gId($keys = null, $default = 0, $value = null) { return self::dataByKeysToId($this->constantData[self::DATA], $keys, $default, $value); }

	final public function gInteger($keys = null, $default = 0, $min = null, $max = null) { return self::dataByKeysToInteger($this->constantData[self::DATA], $keys, $default, $min, $max); }

	final public function gNumber($keys = null, $default = 0, $value = null) { return self::dataByKeysToNumber($this->constantData[self::DATA], $keys, $default, $value); }

	final public function gString($keys = null, $default = '', $case = null, $value = null) { return self::dataByKeysToString($this->constantData[self::DATA], $keys, $default, $case, $value); }

	final public function gInt($keys = null, $default = 0, $min = null, $max = null) { return $this->gInteger($keys, $default, $min, $max); }

	final public function gI($keys = null, $default = 0, $min = null, $max = null) { return $this->gInteger($keys, $default, $min, $max); }

	final public function gNum($keys = null, $default = 0, $value = null) { return $this->gNumber($keys, $default, $value); }

	final public function gN($keys = null, $default = 0, $value = null) { return $this->gNumber($keys, $default, $value); }

	final public function gStr($keys = null, $default = '', $case = null, $value = null) { return $this->gString($keys, $default, $case, $value); }

	final public function gS($keys = null, $default = '', $case = null, $value = null) { return $this->gString($keys, $default, $case, $value); }


	final public function p($keys = null, $default = false) { return self::dataByKeys($this->constantData[self::PDATA], $keys, $default); }

	final public function pId($keys = null, $default = 0, $value = null) { return self::dataByKeysToId($this->constantData[self::PDATA], $keys, $default, $value); }

	final public function pInteger($keys = null, $default = 0, $min = null, $max = null) { return self::dataByKeysToInteger($this->constantData[self::PDATA], $keys, $default, $min, $max); }

	final public function pNumber($keys = null, $default = 0, $value = null) { return self::dataByKeysToNumber($this->constantData[self::PDATA], $keys, $default, $value); }

	final public function pString($keys = null, $default = '', $case = null, $value = null) { return self::dataByKeysToString($this->constantData[self::PDATA], $keys, $default, $case, $value); }

	final public function pInt($keys = null, $default = 0, $min = null, $max = null) { return $this->pInteger($keys, $default, $min, $max); }

	final public function pI($keys = null, $default = 0, $min = null, $max = null) { return $this->pInteger($keys, $default, $min, $max); }

	final public function pNum($keys = null, $default = 0, $value = null) { return $this->pNumber($keys, $default, $value); }

	final public function pN($keys = null, $default = 0, $value = null) { return $this->pNumber($keys, $default, $value); }

	final public function pStr($keys = null, $default = '', $case = null, $value = null) { return $this->pString($keys, $default, $case, $value); }

	final public function pS($keys = null, $default = '', $case = null, $value = null) { return $this->pString($keys, $default, $case, $value); }

}

?>