<html>

<head>
	<title>ajax</title>
</head>

<body>

ajax.php

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

//$L->set('http://nets2/t/a.ajax?x=1&y[x]=2');

try
{

echo '<pre>';
	require_once('lib/lib.php');
echo '<br><br>===<br>';
var_dump($CL);
echo '</pre>';
exit;
$CL->file('/module.cl');
var_dump($CL);
	echo $file = $L->file(null, false);
var_dump($L->file('', false));
	if (!is_file($file)) throw new Exception('AJAX file [' . $file . '] not exists.');
	header('Content-Type: text/plain');
	$print = file_get_contents($file);
	if (preg_match('" [\<] [\?] .*? [\?] [\>] "x', $print))
	{
		ob_start();
		eval("?>\n" . $print . "\n<?");
		$print = ob_get_contents();
		ob_end_clean();
	}
	var_dump($print);
	//print $print;
}
catch (Exception $e)
{
	require_once('404.php');
}

?>