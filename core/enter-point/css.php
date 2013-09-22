<html>

<head>
	<title>css</title>
</head>

<body>

css.php

<pre>
SERVER:
<?var_dump($_SERVER);?>

GET:
<?var_dump($_GET);?>

POST:
<?var_dump($_POST);?>

ENV:
<?var_dump($_ENV);?>
</pre>

</body>

</html>

<?
exit;

//$L->set('http://nets2/t/a.css?x=1&y[x]=2');

try
{
	require_once('lib/lib.php');
	$LOCATION->set(array('-request' => 'modules'));
	$file = $LOCATION->file();
	if (!is_file($file)) throw new Exception('CSS file [' . $file . '] not exists.');
	$cashe_file = preg_replace('"([\.] [^\.]+) $"xu', '.cashe$1', $file);
	header('Content-Type: text/css');
	if (is_file($cashe_file)) $print = file_get_contents($cashe_file);
	else
	{
		$print = file_get_contents($file);
		// оптимизация: пробелы в начале и в конце
		$print = preg_replace('"(?: ^[\s]+ | [\s]+$ )"xmu', '', $print);
		// оптимизация: пробелы в середине
		$print = preg_replace('"[\;][\s]+"xu', ';', $print);
		// оптимизация: вставка кртинок
		$image_max_size = (int)(1024 * 100);
		$compress = 1.5; // коэффициент превышения размера
		$offset = 0;
		while (preg_match('"url [\(] (.*?) [\)]"iSxmu', $print, $url, PREG_OFFSET_CAPTURE, $offset))
		{
			$url = array('text' => $url[1][0], 'begin' => max(0, (int)$url[0][1]), 'end' => strlen($url[0][0]));
			$offset = $url['end'] = $url['begin'] + $url['end'];
			$url['text'] = preg_replace('"^ [\\\'] (.*?) [\\\'] $"x', '$1', $url['text']);
			$url['text'] = preg_replace('"^ [\"] (.*?) [\"] $"x', '$1', $url['text']);
			$url['file'] = $L->file($url['text']);
			if (!is_file($url['file'])) continue;
			elseif (filesize($url['file']) > $image_max_size) continue;
			elseif (preg_match('"[\.] (gif) $"x', $url['file'])) $url['mime'] = 'image/gif';
			elseif (preg_match('"[\.] (jpe?g) $"x', $url['file'])) $url['mime'] = 'image/jpeg';
			elseif (preg_match('"[\.] (png) $"x', $url['file'])) $url['mime'] = 'image/png';
			elseif (preg_match('"[\.] (tif) $"x', $url['file'])) $url['mime'] = 'image/tif';
			else continue;
			$url['file'] = file_get_contents($url['file']);
			$url['file-length'] = strlen($url['file']);
			$url['file'] = base64_encode($url['file']);
			if (strlen($url['file']) > (int)($compress * $url['file-length'])) continue;
			$url['file'] = sprintf('url(data:%s;base64,%s)', $url['mime'], $url['file']);
			$print = substr($print, 0, $url['begin']) . $url['file'] . substr($print, $url['end']);
			$offset = $url['begin'] + strlen($url['file']);
		}
		// создание кещ-файла
		!preg_match('"[\.] (php) $"xu', $file) ? file_put_contents($cashe_file, $print) : 0;
	}
	print $print;
	unset($print, $file, $cashe_file, $url);
}
catch (Exception $e)
{
	require_once('404.php');
}

?>