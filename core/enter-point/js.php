<? //$L->set('http://nets2/t/a.js?x=1&y[x]=2');

try
{
	require_once('lib/lib.php');
	$file = $L->file();
	if (!is_file($file)) throw new Exception('JS file [' . $file . '] not exists.');
	$cashe_file = preg_replace('"([\.] [^\.]+) $"x', '.cashe$1', $file);
	header('Content-Type: text/javascript');
	if (is_file($cashe_file)) $print = file_get_contents($cashe_file);
	else
	{
		$print = file_get_contents($file);
		// оптимизация: пробелы в начале и в конце
		$print = preg_replace('"(?: ^[\s]+ | [\s]+$ )"xmu', '', $print);
		// создание кещ-файла
		!preg_match('"[\.] (php) $"xu', $file) ? file_put_contents($cashe_file, $print) : 0;
	}
	print $print;
	unset($print, $file, $cashe_file);
}
catch (Exception $e)
{
	require_once('404.php');
}

?>