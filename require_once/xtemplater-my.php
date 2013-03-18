<?

require_once('xtemplate.php');
$XT = new XTemplate('../template/index.html');
$HTML = array(
		'description' => '',
		'keywords' => '',
		'title' => '',
		'styles' => '',
		'scripts' => '',
		'content' => ''
	);
$XT->assign('HTML', $HTML);

?>