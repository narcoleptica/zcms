<?

class Z_LOCATION
{

	final static private function array_merge(&$target, $source, $flag = 0, $I = 0)
	{
		$__FUNCTION__ = __FUNCTION__;
		if ((int)$I > 1000) throw new Exception('Location::array_merge. Is to depth (iteration = ' . $I . ').');
		elseif (is_array($target) && is_array($source))
		{
			$return = true;
			$flag_replace_by_new = ($flag < 0) ? false : true;
			foreach ($source as $k => $v)
			{
				if (!array_key_exists($k, $target)) $target[$k] = $v;
				elseif (is_array($target[$k]) && is_array($v)) $return &= self:: $__FUNCTION__($target[$k], $v, $flag, (int)$I + 1);
				elseif ($flag_replace_by_new) $target[$k] = $v;
			}
			unset($flag_replace_by_new);
			return $return;
		}
		return false;
	}
	final static public function is_id($data, $depth = 20) { return preg_match('"^ [1-9] [\d]{0,' . max(0, (int)$depth - 1) . '} $"x', (string)$data); }
	final static public function is_number($data) { return preg_match('"^ [\-\+]? [1-9] [\d]* $"x', (string)$data); }

	static private $KEY = array( 'root' => 0, 'method' => 1, 'domain' => 2, 'request' => 3, 'query' => 4, 'post' => 5, 'anchor' => 6 );
	static private $default_data_inited = null;
	static private $default_data = array();

	final static private function initing_default()
	{
		if (self::$default_data_inited !== null) return self::$default_data_inited;
		try
		{
			// $_SERVER
			if (is_array($_SERVER));
			elseif (is_array($HTTP_SERVER_VARS)) $_SERVER = &$HTTP_SERVER_VARS;
			elseif (!is_array($_SERVER)) throw new Exception('Location::initing_default. SERVER not found.');
			// $_POST
			if (is_array($_POST));
			elseif (is_array($HTTP_POST_VARS)) $_POST = &$HTTP_POST_VARS;
			elseif (!is_array($_POST)) throw new Exception('Location::initing_default. POST not found.');
			// root: /xxx/xxx/xx
			if (isset($_SERVER['DOCUMENT_ROOT']))
			{
				$root = (string)$_SERVER['DOCUMENT_ROOT'];
				$root = preg_replace('"[\/\\\\]"xu', '/', $root);
				$root = preg_replace('" [\/]+ $"xu', '/', $root);
				self::$default_data[self::$KEY['root']] = $root;
				unset($root);
			}
			else self::$default_data[self::$KEY['root']] = '';
			// method: http | https | ftp
			if (isset($_SERVER['SERVER_PORT']))
			{
				$ports = array( 80 => 'http', 443 => 'https', 21 => 'ftp' );
				$port = (int)$_SERVER['SERVER_PORT'];
				$method = $ports[array_key_exists($port, $ports) ? $port : 80];
				self::$default_data[self::$KEY['method']] = $method;
				unset($port, $method);
			}
			else self::$default_data[self::$KEY['method']] = 'http';
			// domain: [H+] a.b.c [H-]
			if (isset($_SERVER['HTTP_HOST']))
			{
				$domain = (string)$_SERVER['HTTP_HOST'];
				$domain = (strlen($domain) > 0) ? explode('.', $domain) : array();
				self::$default_data[self::$KEY['domain']] = $domain;
				unset($domain);
			}
			else self::$default_data[self::$KEY['domain']] = array('localhost');
			// request: [R-] /x/y/z/ [R+]
			if (isset($_SERVER['SCRIPT_URL'])) // SCRIPT_URL | REDIRECT_URL | REQUEST_URI
			{
				$request = (string)$_SERVER['SCRIPT_URL'];
				$request = preg_replace('"[\/\\\\]"xu', '/', $request);
				$request = preg_replace('"^ [\/]+ "xu', '', $request);
				$request = preg_replace('" [\/]+ $"xu', '', $request);
				$request = (strlen($request) > 0) ? explode('/', $request) : array();
				self::$default_data[self::$KEY['request']] = $request;
				unset($request);
			}
			else self::$default_data[self::$KEY['request']] = array();
			// query(get): ?param1=data1&param2=data2
			if (isset($_SERVER['QUERY_STRING']))
			{
				$query = (string)$_SERVER['QUERY_STRING'];
				parse_str($query, $query);
				self::$default_data[self::$KEY['query']] = $query;
				unset($query);
			}
			else self::$default_data[self::$KEY['query']] = array();
			// post: array()
			self::$default_data[self::$KEY['post']] = $_POST;
			// anchor: #xxx
			self::$default_data[self::$KEY['anchor']] = '';
			// initialization flag
			self::$default_data_inited = true;
		}
		catch (Exception $E) { self::$default_data_inited = false; }
		return self::$default_data_inited;
	}


	private $constant_data = null;

	final public function set_root($root)
	{
		$root = realpath($root);
		$root = preg_replace('"[\/\\\\]"xu', '/', $root);
		$root = preg_replace('" [\/]+ $"xu', '/', $root);
		if (is_dir($root)) $this->constant_data[self::$KEY['root']] = $root;
		return true;
	}

	final public function set_method($method)
	{
		static $METHOD = array( 80 => 'http', 443 => 'https', 21 => 'ftp', 'http' => 'http', 'https' => 'https', 'ftp' => 'ftp' );
		$method = (string)strtolower((string)$method);
		if (array_key_exists($method, $METHOD)) $this->constant_data[self::$KEY['method']] = $METHOD[$method];
		return true;
	}

	// flag = 0 - замена
	// flag > 0 - добавление в начало (прямой порядок)
	// flag < 0 - добавление в конец (обратный порялок)
	final public function set_domain($domain, $flag = 0)
	{
		static $__FUNCTION__ = __FUNCTION__;
		if (is_array($domain) && !(count(preg_grep('"^[\w\d\-\_]+$"u', $domain, PREG_GREP_INVERT)) > 0))
		{
			$flag = (int)$flag;
			if ($flag < 0)
			{
				$merge = 'array_push';
				$domains = array_reverse($domain, true);
			}
			else
			{
				$merge = 'array_unshift';
				$domains = $domain;
				if ($flag === 0) $this->constant_data[self::$KEY['domain']] = array();
			}
			if (count($domains) > 0)
			{
				array_unshift($domains, &$this->constant_data[self::$KEY['domain']]);
				call_user_func_array($merge, $domains);
			}
			unset($merge, $domains);
		}
		elseif (is_string($domain) && preg_match('"^[\w\d\-\_\.]*$"u', $domain))
		{
			$domains = preg_replace('"[\s]"', '', $domain);
			$domains = preg_replace('"[\.\,]"', '.', $domains);
			$domains = preg_replace('"(^[\.]|[\.]$)"', '', $domains);
			$domains = (strlen($domain) > 0) ? explode('.', $domains) : array();
			$this->$__FUNCTION__($domains, $flag);
			unset($domains);
		}
		else return false;
		return true;
	}

	// flag = 0 - замена
	// flag > 0 - добавление в конец (обратный порялок)
	// flag < 0 - добавление в начало (прямой порядок)
	final public function set_request($request, $flag = 0)
	{
		static $__FUNCTION__ = __FUNCTION__;
		if (is_array($request) && !(count(preg_grep('"^[\w\d\-\_\.]+$"u', $request, PREG_GREP_INVERT)) > 0))
		{
			$flag = (int)$flag;
			if ($flag > 0)
			{
				$merge = 'array_push';
				$requests = array_reverse($request, true);
			}
			else
			{
				$merge = 'array_unshift';
				$requests = $request;
				if ($flag === 0) $this->constant_data[self::$KEY['request']] = array();
			}
			if (count($requests) > 0)
			{
				array_unshift($requests, &$this->constant_data[self::$KEY['request']]);
				call_user_func_array($merge, $requests);
			}
			unset($merge, $requests);
		}
		elseif (is_string($request) && preg_match('"^[\w\d\-\_\.\/\\\\]*$"u', $request))
		{
			$requests = preg_replace('"[\s]"', '', $request);
			$requests = preg_replace('"[\/\\\\]"', '/', $requests);
			$requests = preg_replace('"(^[\/]|[\/]$)"', '', $requests);
			$requests = (strlen($request) > 0) ? explode('/', $requests) : array();
			$this->$__FUNCTION__($requests, $flag);
			unset($requests);
		}
		else return false;
		return true;
	}

	// flag = 0 - замена
	// flag > 0 - новов значене актуальнее
	// flag < 0 - старое значене актуальнее
	final public function set_query($query, $flag = 1)
	{
		static $__FUNCTION__ = __FUNCTION__;
		if (is_array($query))
		{
			$flag = (int)$flag;
			if ($flag < 0) self::array_merge($this->constant_data[self::$KEY['query']], $query, -1);
			elseif ($flag > 0) self::array_merge($this->constant_data[self::$KEY['query']], $query, 1);
			else $this->constant_data[self::$KEY['query']] = $query;
		}
		elseif (is_string($query) && (strlen($query) > 0))
		{
			parse_str($query, $querys);
			if (is_array($querys)) $this->$__FUNCTION__($querys, $flag);
			unset($querys);
		}
		else return false;
		return true;
	}

	// flag = 0 - замена
	// flag > 0 - новов значене актуальнее
	// flag < 0 - старое значене актуальнее
	final public function set_post($post, $flag = 0)
	{
		static $__FUNCTION__ = __FUNCTION__;
		if (is_array($post))
		{
			$flag = (int)$flag;
			if ($flag < 0) self::array_merge($this->constant_data[self::$KEY['post']], $post, -1);
			elseif ($flag > 0) self::array_merge($this->constant_data[self::$KEY['post']], $post, 1);
			else $this->constant_data[self::$KEY['post']] = $post;
		}
		elseif (is_string($post) && (strlen($post) > 0))
		{
			parse_str($post, $posts);
			if (is_array($posts)) $this->$__FUNCTION__($posts, $flag);
			unset($posts);
		}
		else return false;
		return true;
	}

	final public function set_anchor($anchor)
	{
		$anchor = (string)$anchor;
		if (preg_match('"^[\w\d\-\_]+$"xu', $anchor)) $this->constant_data[self::$KEY['anchor']] = $anchor;
		return true;
	}

	final public function set($set = null, $url_or_file = 'url')
	{
		static $__FUNCTION__ = __FUNCTION__;
		static $RE = array(
				'url' => '"^ (?:([\w]+)[\:][\/]{2})? ([\w\d\-\_\.]*) (?:([\w\d\-\_\.\/\\\\]+))? (?:[\?]([^\#]+))? (?:[\#](.*))? $"x',
				'file' => '"^ ([\w\d\-\_\.\:\/\\\\]+) $"x'
			);
		switch ($url_or_file)
		{
			case 'url':
			case 'u':
				$url_or_file = 'url';
				break;
			case 'file':
			case 'f':
				$url_or_file = 'file';
				break;
			default: $url_or_file = 'url';
		}
		if (is_array($set))
		{
			static $SET = array(
					'set_root' => array('root'),
					'set_method' => array('method', 'm', 'pre'),
					'set_domain' => array(
							'domain', '=domain' => array(0), '+domain' => array(1), '-domain' => array(-1),
							'host', '=host' => array(0), '+host' => array(1), '-host' => array(-1),
							'server', '=server' => array(0), '+server' => array(1), '-server' => array(-1),
							'd', '=d' => array(0), '+d' => array(1), '-d' => array(-1),
							'h', '=h' => array(0), '+h' => array(1), '-h' => array(-1)
						),
					'set_request' => array(
						'request', '=request' => array(0), '+request' => array(1), '-request' => array(-1),
						'path', '=path' => array(0), '+path' => array(1), '-path' => array(-1),
						'r', '=r' => array(0), '+r' => array(1), '-r' => array(-1)
						),
					'set_query' => array(
							'query', '=query' => array(0), '+query' => array(1), '-query' => array(-1),
							'get', '=get' => array(0), '+get' => array(1), '-get' => array(-1),
							'search', '=search' => array(0), '+search' => array(1), '-search' => array(-1),
							'q', '=q' => array(0), '+q' => array(1), '-q' => array(-1),
							'g', '=g' => array(0), '+g' => array(1), '-g' => array(-1)
						),
					'set_post' => array(
							'post', '=post' => array(0), '+post' => array(1), '-post' => array(-1),
							'p', '=p' => array(0), '+p' => array(1), '-p' => array(-1)
						),
					'set_anchor' => array('anchor', 'a')
				);
			$set = array_change_key_case($set, CASE_LOWER);
			foreach ($SET as $call => $keys)
			{
				if (!$call) throw new Exception('Location->set. Wrong call.');
				if (!is_array($keys)) throw new Exception('Location->set. Wrong keys.');
				foreach ($keys as $key => $value)
				{
					if (is_string($value))
					{
						if (!array_key_exists($value, $set)) continue;
						call_user_func_array(array($this, $call), array($set[$value]));
						break;
					}
					elseif (is_array($value))
					{
						if (!array_key_exists($key, $set)) continue;
						array_unshift($value, $set[$key]);
						call_user_func_array(array($this, $call), $value);
						break;
					}
				}
			}
		}
		/*
		elseif (is_string($set))
		{
			$sets = parse_url($set, PHP_URL_SCHEME | PHP_URL_HOST | PHP_URL_PORT | PHP_URL_USER | PHP_URL_PASS | PHP_URL_PATH | PHP_URL_QUERY | PHP_URL_FRAGMENT);
			$sets = array('method' => $sets['scheme'], 'user' => $sets['user'], 'password' => $sets['pass'], 'domain' => $sets['host'], 'request' => $sets['path'], 'query' => $sets['query'], 'anchor' => $sets['fragment']);
			$this->$__FUNCTION__($sets);
		}
		*/
		elseif (is_string($set) && preg_match($RE[$url_or_file], $set, $sets))
		{
			if ($url_or_file === 'url')
			{
				$method = isset($sets[1]) ? $sets[1] : '';
				$domain = isset($sets[3]) ? $sets[2] : '';
				$request = isset($sets[3]) ? $sets[3] : '';
				$query = isset($sets[4]) ? $sets[4] : '';
				$anchor = isset($sets[5]) ? $sets[5] : '';
				$sets = array('method' => $method, 'domain' => $domain, 'request' => $request, 'query' => $query, 'anchor' => $anchor);
				$this->$__FUNCTION__($sets);
			}
			elseif ($url_or_file === 'file')
			{
				$request = isset($sets[1]) ? $sets[1] : '';
				$sets = array('request' => $request);
				$this->$__FUNCTION__($sets);
			}
			else return false;
		}
		else return false;
		return true;
	}

	final public function get_root() { return $this->constant_data[self::$KEY['root']]; }
	final public function get_method() { return $this->constant_data[self::$KEY['method']]; }
	final public function get_domain($join = false) { $d = &$this->constant_data[self::$KEY['domain']]; return ($flag === true) ? join('.', $d) : $d; }
	final public function get_request($join = false) { $r = &$this->constant_data[self::$KEY['request']]; return ($flag === true) ? join('.', $r) : $r; }
	final public function get_query($join = false) { }
	final public function get_post($join = false) { }
	final public function get_anchor() { return $this->constant_data[self::$KEY['anchor']]; }
	final public function get($join = false) {
		$return = array();
		foreach ($this->constant_data as $key => $value)
		{
			$call = sprintf('get_%s', $key);
			$return[$key] = $this->$call($join);
		}
		return $return;
	}

	final public function href($href = null)
	{
		$backup = $this->constant_data;
		$this->set($href, 'url');
		$set = &$this->constant_data;
		$method = (strlen($set[self::$KEY['method']]) > 0) ? sprintf('%s://', $set[self::$KEY['method']]) : '';
		$domain = (is_array($set[self::$KEY['domain']]) && (count($set[self::$KEY['domain']]) > 0)) ? join('.', $set[self::$KEY['domain']]) : '';
		$request = (is_array($set[self::$KEY['request']]) && (count($set[self::$KEY['request']]) > 0)) ? sprintf('/%s', join('/', $set[self::$KEY['request']])) : '/';
		$query = (is_array($set[self::$KEY['query']]) && (count($set[self::$KEY['query']]) > 0)) ? sprintf('?%s', http_build_query($set[self::$KEY['query']])) : '';
		$anchor = (strlen($set[self::$KEY['anchor']]) > 0) ? sprintf('#%s', $set[self::$KEY['anchor']]) : '';
		$return = sprintf('%s%s%s%s%s', $method, $domain, $request, $query, $anchor);
		$this->constant_data = $backup;
		unset($backup, $set, $method, $domain, $request, $query, $anchor);
		return $return;
	}

	final public function file($file = null, $absolute = true)
	{
		$backup = $this->constant_data;
		$this->set($file, 'file');
		$set = &$this->constant_data;
		$root = (strlen($set[self::$KEY['root']]) > 0) ? sprintf('%s', $set[self::$KEY['root']]) : '';
		$request = (is_array($set[self::$KEY['request']]) && (count($set[self::$KEY['request']]) > 0)) ? sprintf('/%s', join('/', $set[self::$KEY['request']])) : '/';
		switch ($absolute)
		{
			case true: $return = sprintf('%s%s', $root, $request); break;
			case false: case '': $return = preg_replace('"^ [\/]"x', '', $request); break;
			case '/': $return = $request; break;
			default: $return = sprintf('%s%s', $root, $request);
		}
		$this->constant_data = $backup;
		unset($backup, $set, $root, $request);
		return $return;
	}

	final static public function init($set = null) { $C = __CLASS__; return new $C($set); }
	final public function __construct($set = null) { self::initing_default(); $this->constant_data = self::$default_data; $this->set($set, 'url'); }
	final public function __destruct() { }
	final public function __clone() { self::initing_default(); }
	final public function __sleep() { return array('constant_data'); }
	final public function __wakeup() { self::initing_default(); }
	final public function __toString() { return $this->href(); }

	final public function root() { return $this->constant_data[self::$KEY['root']]; }
	final public function method() { return $this->constant_data[self::$KEY['method']]; }
	final public function domain($index = null, $else = null)
	{
		$domain = &$this->constant_data[self::$KEY['domain']];
		$count = count($domain);
		if ($index === null) return $domain;
		elseif (!is_array($domain) || !($count > 0)) throw new Exception('Location->domain. Wrong constant_data.');
		elseif ($index === 'first') return $domain[count($domain)];
		elseif ($index === 'last') return $domain[0];
		elseif (array_key_exists($index, $domain)) return $domain[$index];
		elseif ($else === null) throw new Exception('Location->domain. Unknown index [' . $index . '].');
		else return $else;
	}
	final public function domains() { return join('/', $this->request()); }
	final public function request($index = null, $else = null)
	{
		$request = &$this->constant_data[self::$KEY['request']];
		$count = count($request);
		if ($index === null) return $request;
		elseif (!is_array($request) || !($count > 0)) throw new Exception('Location->request. Wrong constant_data.');
		elseif ($index === 'first') return $request[0];
		elseif ($index === 'last') return $request[count($request)];
		elseif (array_key_exists($index, $request)) return $request[$index];
		elseif ($else === null) throw new Exception('Location->request. Unknown index [' . $index . '].');
		else return $else;
	}
	final public function requests() { return join('/', $this->request()); }
	final public function query($index = null, $else = null)
	{
		$query = &$this->constant_data[self::$KEY['query']];
		if ($index === null) return $query;
		elseif (!is_array($query) || !(count($query) > 0)) throw new Exception('Location->query. Wrong constant_data.');
		elseif (is_array($index))
		{
			foreach ($index as $i)
			{
				if (is_array($query) && array_key_exists($i, $query)) $query = &$query[$i];
				elseif ($else === null) throw new Exception('Location->query. Unknown index [' . join('.', $index) . '].');
				else return $else;
			}
			return $query;
		}
		elseif (!array_key_exists($index, $query)) return $query[$index];
		elseif ($else === null) throw new Exception('Location->query. Unknown index [' . $index . '].');
		else return $else;
	}
	final public function qId($index = null, $else = 0)
	{
		try { $data = $this->query(&$index, &$else); return self::is_id(&$data) ? $data : $else; }
		catch (Exception $e) { return $else; }
	}
	final public function gI($index = null, $else = 0)
	{
		try { $data = $this->query(&$index, &$else); return self::is_number(&$data) ? $data : $else; }
		catch (Exception $e) { return $else; }
	}
	final public function gN($index = null, $else = 0)
	{
		try { $data = $this->query(&$index, &$else); return self::is_number(&$data) ? $data : $else; }
		catch (Exception $e) { return $else; }
	}
	final public function gS($index = null, $else = '')
	{
		try { $data = $this->query(&$index, &$else); return is_string($data) ? $data : $else; }
		catch (Exception $e) { return $else; }
	}
	final public function post($index = null, $else = null)
	{
		$post = &$this->constant_data[self::$KEY['post']];
		if ($index === null) return $post;
		elseif (!is_array($post) || !(count($query) > 0)) throw new Exception('Location->post. Wrong constant_data.');
		elseif (is_array($index))
		{
			foreach ($index as $i)
			{
				if (is_array($post) && array_key_exists($i, $post)) $post = &$post[$i];
				elseif ($else === null) throw new Exception('Location->post. Unknown index [' . join('.', $index) . '].');
				else return $else;
			}
			return $post;
		}
		elseif (array_key_exists($index, $post)) return $post[$index];
		elseif ($else === null) throw new Exception('Location->post. Unknown index [' . $index . '].');
		else return $else;
	}
	final public function pId($index = null, $else = 0)
	{
		try { $data = $this->post(&$index, &$else); return self::is_id(&$data) ? $data : $else; }
		catch (Exception $e) { return $else; }
	}
	final public function pI($index = null, $else = 0)
	{
		try { $data = $this->post(&$index, &$else); return self::is_number(&$data) ? $data : $else; }
		catch (Exception $e) { return $else; }
	}
	final public function pN($index = null, $else = 0)
	{
		try { $data = $this->post(&$index, &$else); return self::is_number(&$data) ? $data : $else; }
		catch (Exception $e) { return $else; }
	}
	final public function pS($index = null, $else = '')
	{
		try { $data = $this->post(&$index, &$else); return is_string($data) ? $data : $else; }
		catch (Exception $e) { return $else; }
	}
	final public function anchor() { return $this->constant_data[self::$KEY['anchor']]; }
}

?>