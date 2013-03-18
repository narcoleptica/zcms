<?

require_once('include/location.php');
$L = Z_LOCATION::init();
require_once('include/mysql-db.php');
global $DB;
require_once('include/xtemplate.php');
$T = new XTemplate('resource/tracking.htm');
//
function cp1251($data)
{
	if (is_array($data))
	{
		foreach ($data as &$d) { $d = cp1251($d); }
		return $data;
	}
	else return iconv('UTF-8', 'cp1251//IGNORE', urldecode($data));
}
function noSQLinclude($data)
{
	if (is_array($data))
	{
		foreach ($data as &$d) { $d = noSQLinclude($d); }
		return $data;
	}
	elseif (is_string($data))
	{
		static $pattern = array('\\', '"');
		static $replace = array('\\\\', '\\"');
		$return = (string)str_replace($pattern, $replace, (string)$data);
		return $return;
	}
	else return $data;
}
function strTOhtml($data)
{
	if (is_array($data))
	{
		foreach ($data as &$d) { $d = strTOhtml($d); }
		return $data;
	}
	elseif (is_string($data))
	{
		static $pattern = array('&', '<', '>', '"', "'");
		static $replace = array('&#38;', '&#60;', '&#62;', '&#34;', '&#39;');
		$return = str_replace($pattern, $replace, $data);
		return $return;
	}
	else return $data;
}
//
if ($L->pS(array('ajax'), false, -1) !== false)
{
	header('Content-Type: text/plain; charset=windows-1251');
	//
	if ($L->pS(array('ajax'), false, 0, 'shipment-add'))
	{
print_r(cp1251($L->p('s')));
		print 'shipment-add';
	}
	elseif ($L->pS(array('ajax'), false, 0, 'shipment-edit'))
	{
		// print_r(cp1251($L->p()));
		$id = $L->pId('id', 0);
		$s = cp1251($L->p('s'));
		$error = array();
		// code
		try
		{
			if (!isset($s['code']) || !is_string($s['code'])) throw new Exception('code = one');
			$code = trim($s['code']);
			//$code = substr($code, 0, 30);
			if (!preg_match("'" . '^ ([\d\w\-\_\.]{0,30}) $' . "'x", (string)$code, $code)) throw new Exception('code = symbols');
			$code = $code[1];
			$code = noSQLinclude($code);
			$sql = 'UPDATE `z_shipment` s SET s.`code`=IF(LENGTH("%s") > 0, "%s", NULL) WHERE s.`id`="%d";';
			$sql = sprintf($sql, $code, $code, $id);
			if (!$DB->q($sql)) throw new Exception('code = all');
		}
		catch(Exception $E) { $error[] = 'code'; }
		// outsource
		try
		{
			if (!isset($s['outsource_type']) || !is_string($s['outsource_type'])) throw new Exception('outsource = type');
			$outsource_type = substr($s['outsource_type'], 0, 32);
			$outsource_type = noSQLinclude($outsource_type);
			if (!isset($s['outsource_number']) || !is_string($s['outsource_number'])) throw new Exception('outsource = number');
			$outsource_number = substr(trim($s['outsource_number']), 0, 64);
			$outsource_number = (strlen($outsource_number) > 0) ? noSQLinclude($outsource_number) : '-';
			if (!isset($s['outsource_comment']) || !is_string($s['outsource_comment'])) throw new Exception('outsource = comment');
			$outsource_comment = substr($s['outsource_comment'], 0, 255);
			$outsource_comment = noSQLinclude($outsource_comment);
			$sql = 'UPDATE `z_shipment` s SET s.`outsource_type`="%s", s.`outsource_number`="%s", s.`outsource_comment`="%s" WHERE s.`id`="%d";';
			$sql = sprintf($sql, $outsource_type, $outsource_number, $outsource_comment, $id);
			if (!$DB->q($sql)) throw new Exception('outsource = all');
		}
		catch(Exception $E) { $error[] = 'outsource'; }
		// state
		try
		{
			if (!isset($s['state']) || !is_string($s['state'])) throw new Exception('state = one');
			$state = substr($s['state'], 0, 32);
			$state = noSQLinclude($state);
			$sql = 'UPDATE `z_shipment` s SET s.`state`="%s" WHERE s.`id`="%d";';
			$sql = sprintf($sql, $state, $id);
			if (!$DB->q($sql)) throw new Exception('state = all');
		}
		catch(Exception $E) { $error[] = 'state'; }
		// sender
		try
		{
			if (!isset($s['sender_company']) || !is_string($s['sender_company'])) throw new Exception('sender = company');
			$sender_company = substr(trim($s['sender_company']), 0, 255);
			$sender_company = (strlen($sender_company) > 0) ? noSQLinclude($sender_company) : '-';
			if (!isset($s['sender_person']) || !is_string($s['sender_person'])) throw new Exception('sender = person');
			$sender_person = substr(trim($s['sender_person']), 0, 255);
			$sender_person = (strlen($sender_person) > 0) ? noSQLinclude($sender_person) : '-';
			if (!isset($s['sender_zip']) || !is_string($s['sender_zip'])) throw new Exception('sender = zip');
			$sender_zip = substr(trim($s['sender_zip']), 0, 10);
			$sender_zip = (strlen($sender_zip) > 0) ? noSQLinclude($sender_zip) : '?????';
			// if (!isset($s['sender_contry']) || !is_string($s['sender_contry'])) throw new Exception('sender = contry');
			$sender_contry = @substr($s['sender_contry'], 0, 255);
			$sender_contry = noSQLinclude($sender_contry);
			// if (!isset($s['sender_city']) || !is_string($s['sender_city'])) throw new Exception('sender = city');
			$sender_city = @substr($s['sender_city'], 0, 255);
			$sender_city = noSQLinclude($sender_city);
			if (!isset($s['sender_address']) || !is_string($s['sender_address'])) throw new Exception('sender = address');
			$sender_address = substr(trim($s['sender_address']), 0, 255);
			$sender_address = (strlen($sender_address) > 0) ? noSQLinclude($sender_address) : '?';
			if (!isset($s['sender_comment']) || !is_string($s['sender_comment'])) throw new Exception('sender = comment');
			$sender_comment = substr($s['sender_comment'], 0, 255);
			$sender_comment = noSQLinclude($sender_comment);
			$sql = 'UPDATE `z_shipment` s SET s.`sender_company`="%s", s.`sender_person`="%s", s.`sender_zip`="%s", s.`sender_contry`="%s", s.`sender_city`="%s", s.`sender_address`="%s", s.`sender_comment`="%s" WHERE s.`id`="%d";';
			$sql = sprintf($sql, $sender_company, $sender_person, $sender_zip, $sender_contry, $sender_city, $sender_address, $sender_comment, $id);
			if (!$DB->q($sql)) throw new Exception('sender = all');
		}
		catch(Exception $E) { $error[] = 'sender'; }
		// receiver
		try
		{
			if (!isset($s['receiver_company']) || !is_string($s['receiver_company'])) throw new Exception('receiver = company');
			$receiver_company = substr(trim($s['receiver_company']), 0, 255);
			$receiver_company = (strlen($receiver_company) > 0) ? noSQLinclude($receiver_company) : '-';
			if (!isset($s['receiver_person']) || !is_string($s['receiver_person'])) throw new Exception('receiver = person');
			$receiver_person = substr(trim($s['receiver_person']), 0, 255);
			$receiver_person = (strlen($receiver_person) > 0) ? noSQLinclude($receiver_person) : '-';
			if (!isset($s['receiver_zip']) || !is_string($s['receiver_zip'])) throw new Exception('receiver = zip');
			$receiver_zip = substr(trim($s['receiver_zip']), 0, 10);
			$receiver_zip = (strlen($receiver_zip) > 0) ? noSQLinclude($receiver_zip) : '?????';
			// if (!isset($s['receiver_contry']) || !is_string($s['receiver_contry'])) throw new Exception('receiver = contry');
			$receiver_contry = @substr($s['receiver_contry'], 0, 255);
			$receiver_contry = noSQLinclude($receiver_contry);
			// if (!isset($s['receiver_city']) || !is_string($s['receiver_city'])) throw new Exception('receiver = city');
			$receiver_city = @substr($s['receiver_city'], 0, 255);
			$receiver_city = noSQLinclude($receiver_city);
			if (!isset($s['receiver_address']) || !is_string($s['receiver_address'])) throw new Exception('receiver = address');
			$receiver_address = substr(trim($s['receiver_address']), 0, 255);
			$receiver_address = (strlen($receiver_address) > 0) ? noSQLinclude($receiver_address) : '?';
			if (!isset($s['receiver_comment']) || !is_string($s['receiver_comment'])) throw new Exception('receiver = comment');
			$receiver_comment = substr($s['receiver_comment'], 0, 255);
			$receiver_comment = noSQLinclude($receiver_comment);
			$sql = 'UPDATE `z_shipment` s SET s.`receiver_company`="%s", s.`receiver_person`="%s", s.`receiver_zip`="%s", s.`receiver_contry`="%s", s.`receiver_city`="%s", s.`receiver_address`="%s", s.`receiver_comment`="%s" WHERE s.`id`="%d";';
			$sql = sprintf($sql, $receiver_company, $receiver_person, $receiver_zip, $receiver_contry, $receiver_city, $receiver_address, $receiver_comment, $id);
			if (!$DB->q($sql)) throw new Exception('receiver = all');
		}
		catch(Exception $E) { $error[] = 'receiver'; }
		// type
		try
		{
			if (!isset($s['type']) || !is_string($s['type'])) throw new Exception('type = one');
			$type = substr($s['type'], 0, 32);
			$type = noSQLinclude($type);
			$sql = 'UPDATE `z_shipment` s SET s.`type`="%s" WHERE s.`id`="%d";';
			$sql = sprintf($sql, $type, $id);
			if (!$DB->q($sql)) throw new Exception('type = all');
		}
		catch(Exception $E) { $error[] = 'type'; }
		// speed
		try
		{
			if (!isset($s['speed']) || !is_string($s['speed'])) throw new Exception('speed = one');
			$speed = substr($s['speed'], 0, 32);
			$speed = noSQLinclude($speed);
			$sql = 'UPDATE `z_shipment` s SET s.`speed`="%s" WHERE s.`id`="%d";';
			$sql = sprintf($sql, $speed, $id);
			if (!$DB->q($sql)) throw new Exception('speed = all');
		}
		catch(Exception $E) { $error[] = 'speed'; }
		// fee
		try
		{
			if (!isset($s['fee']) || !is_string($s['fee'])) throw new Exception('fee = one');
			$fee = substr($s['fee'], 0, 32);
			$fee = noSQLinclude($fee);
			$sql = 'UPDATE `z_shipment` s SET s.`fee`="%s" WHERE s.`id`="%d";';
			$sql = sprintf($sql, $fee, $id);
			if (!$DB->q($sql)) throw new Exception('fee = all');
		}
		catch(Exception $E) { $error[] = 'fee'; }
		// payer
		try
		{
			if (!isset($s['payer']) || !is_string($s['payer'])) throw new Exception('payer = one');
			$payer = substr($s['payer'], 0, 32);
			$payer = noSQLinclude($payer);
			$sql = 'UPDATE `z_shipment` s SET s.`payer`="%s" WHERE s.`id`="%d";';
			$sql = sprintf($sql, $payer, $id);
			if (!$DB->q($sql)) throw new Exception('payer = all');
		}
		catch(Exception $E) { $error[] = 'payer'; }
		// weight
		try
		{
			if (!isset($s['weight']) || !is_string($s['weight'])) throw new Exception('weight = one');
			$weight = trim($s['weight']);
			//$weight = substr($weight, 0, 11);
			if (!preg_match("'" . '^ ([\d]{1,11}) $' . "'x", (string)$weight, $weight)) throw new Exception('weight = id');
			$weight = (int)$weight[1];
			$sql = 'UPDATE `z_shipment` s SET s.`weight_id`=IFNULL((SELECT `id` FROM z_d_weight WHERE `id`="%d"), 0) WHERE s.`id`="%d";';
			$sql = sprintf($sql, $weight, $id);
			if (!$DB->q($sql)) throw new Exception('weight = all');
		}
		catch(Exception $E) { $error[] = 'weight'; }
		// depth
		try
		{
			if (!isset($s['depth']) || !is_string($s['depth'])) throw new Exception('depth = one');
			$depth = trim($s['depth']);
			//$depth = substr($depth, 0, 6);
			if (!preg_match("'" . '^ ([\d]{0,6}) $' . "'x", (string)$depth, $depth)) throw new Exception('depth = number');
			$depth = $depth[1];
			$sql = 'UPDATE `z_shipment` s SET s.`depth`="%d" WHERE s.`id`="%d";';
			$sql = sprintf($sql, $depth, $id);
			if (!$DB->q($sql)) throw new Exception('depth = all');
		}
		catch(Exception $E) { $error[] = 'depth'; }
		// width
		try
		{
			if (!isset($s['width']) || !is_string($s['width'])) throw new Exception('width = one');
			$width = trim($s['width']);
			//$width = substr($width, 0, 6);
			if (!preg_match("'" . '^ ([\d]{0,6}) $' . "'x", (string)$width, $width)) throw new Exception('width = number');
			$width = $width[1];
			$sql = 'UPDATE `z_shipment` s SET s.`width`="%d" WHERE s.`id`="%d";';
			$sql = sprintf($sql, $width, $id);
			if (!$DB->q($sql)) throw new Exception('width = all');
		}
		catch(Exception $E) { $error[] = 'width'; }
		// height
		try
		{
			if (!isset($s['height']) || !is_string($s['height'])) throw new Exception('height = one');
			$height = trim($s['height']);
			//$height = substr($height, 0, 6);
			if (!preg_match("'" . '^ ([\d]{0,6}) $' . "'x", (string)$height, $height)) throw new Exception('height = number');
			$height = $height[1];
			$sql = 'UPDATE `z_shipment` s SET s.`height`="%d" WHERE s.`id`="%d";';
			$sql = sprintf($sql, $height, $id);
			if (!$DB->q($sql)) throw new Exception('height = all');
		}
		catch(Exception $E) { $error[] = 'height'; }
		// count
		try
		{
			if (!isset($s['count']) || !is_string($s['count'])) throw new Exception('count = one');
			$count = trim($s['count']);
			//$count = substr($count, 0, 6);
			if (!preg_match("'" . '^ ([\d]{0,6}) $' . "'x", (string)$count, $count)) throw new Exception('count = number');
			$count = $count[1];
			$sql = 'UPDATE `z_shipment` s SET s.`count`="%d" WHERE s.`id`="%d";';
			$sql = sprintf($sql, $count, $id);
			if (!$DB->q($sql)) throw new Exception('count = all');
		}
		catch(Exception $E) { $error[] = 'count'; }
		// price
		try
		{
			if (!isset($s['price']) || !is_string($s['price'])) throw new Exception('price = one');
			$price = trim($s['price']);
			//$price = substr($price, 0, 14);
			if (!preg_match("'" . '^ ([\d]{0,10}) (?: [\,\.] ([\d]{0,3}) )?$' . "'x", (string)$price, $price)) throw new Exception('price = number');
			$price = sprintf('%d.%d', $price[1], isset($price[2]) ? $price[2] : 0);
			$price = substr($price, 0, 14);
			$sql = 'UPDATE `z_shipment` s SET s.`price`="%s" WHERE s.`id`="%d";';
			$sql = sprintf($sql, $price, $id);
			if (!$DB->q($sql)) throw new Exception('price = all');
		}
		catch(Exception $E) { $error[] = 'price'; }
		// additional
		try
		{
			$additional = 0;
			if (isset($s['additional']) && is_array($s['additional'])) { foreach ($s['additional'] as $a) { $additional |= pow(2, (int)$a); } }
			$sql = 'UPDATE `z_shipment` s SET s.`additional`="%d" WHERE s.`id`="%d";';
			$sql = sprintf($sql, $additional, $id);
			if (!$DB->q($sql)) throw new Exception('additional = all');
		}
		catch(Exception $E) { $error[] = 'additional'; }
		// comment
		try
		{
			if (!isset($s['comment']) || !is_string($s['comment'])) throw new Exception('comment = one');
			$comment = substr($s['comment'], 0, 60000);
			$comment = noSQLinclude($comment);
			$sql = 'UPDATE `z_shipment` s SET s.`comment`="%s" WHERE s.`id`="%d";';
			$sql = sprintf($sql, $comment, $id);
			if (!$DB->q($sql)) throw new Exception('comment = all');
		}
		catch(Exception $E) { $error[] = 'comment'; }
		print (count($error) > 0) ? sprintf('error:%s%s', "\n", join("\n", $error)) : 'success';
	}
	elseif ($L->pS(array('ajax'), false, 0, 'shipment-delete'))
	{
		// print_r(cp1251($L->p()));
		print 'shipment-delete';
	}
	elseif ($L->pS(array('ajax'), false, 0, 'shipment-history-add'))
	{
		print 'shipment-history-add';
	}
	elseif ($L->pS(array('ajax'), false, 0, 'shipment-history-edit'))
	{
		print 'shipment-history-edit';
	}
	elseif ($L->pS(array('ajax'), false, 0, 'shipment-history-delete'))
	{
		print 'shipment-history-delete';
	}
	else
	{
		sleep(1);
		$p = cp1251($L->p());
		print 'POST:' . "\n"; print_r($p);
	}
}
elseif ($L->gS(array('ajax'), false, -1) !== false)
{
	header('Content-Type: text/html; charset=windows-1251');
	//
	if ($L->gS(array('ajax'), false, 0, 'shipment-view'))
	{
		$sql = '
SELECT s.*, DATE_FORMAT(s.`created`, "%s") AS `created_at`, DATE_FORMAT(s.`created`, "%s") AS `created_date`, DATE_FORMAT(s.`created`, "%s") AS `created_time`, w.value AS `weight`
FROM `z_shipment` s
LEFT JOIN `z_d_weight` w ON s.`weight_id` = w.`id`
WHERE s.`id`=%d;';
		$sql = sprintf($sql, '%d/%m/%Y %H:%i', '%d/%m/%Y', '%H:%i:%s', $L->gId('id', 0));
		$shipment = $DB->q1($sql, 0);
		$shipment = strTOhtml($shipment);
		if ($shipment['code'] === null) $shipment['code'] = '?';
		$shipment['outsource_comment'] = nl2br($shipment['outsource_comment']);
		$shipment['sender_comment'] = nl2br($shipment['sender_comment']);
		$shipment['receiver_comment'] = nl2br($shipment['receiver_comment']);
		if ($shipment['weight'] === null) $shipment['weight'] = '?';
		$shipment['depth'] = ($shipment['depth'] > 0) ? $shipment['depth'] : '-';
		$shipment['width'] = ($shipment['width'] > 0) ? $shipment['width'] : '-';
		$shipment['height'] = ($shipment['height'] > 0) ? $shipment['height'] : '-';
		$shipment['count'] = ($shipment['count'] > 0) ? $shipment['count'] : '?';
		$shipment['price'] = ($shipment['price'] > 0) ? sprintf('%.2f', $shipment['price']) : '';
		$shipment['comment'] = nl2br($shipment['comment']);
		$T->assign('D', $shipment);
		if ($shipment['outsource_type'] !== 'none') $T->parse('view.shipment.outsource');
		if ($shipment['type'] !== 'none') $T->parse('view.shipment.type_' . $shipment['type']);
		if ($shipment['speed'] !== 'none') $T->parse('view.shipment.speed_' . $shipment['speed']);
		if ($shipment['fee'] !== 'none') $T->parse('view.shipment.fee_' . $shipment['fee']);
		if ($shipment['payer'] !== 'none') $T->parse('view.shipment.payer_' . $shipment['payer']);
		if ($shipment['additional'] === 0) $T->parse('view.shipment.additional_0');
		else foreach (array(1, 2, 4, 8, 16, 32) as $s) ($shipment['additional'] & $s) ? $T->parse('view.shipment.additional_' . $s) : 0;
		$T->parse('view.shipment');
		print $T->text('view.shipment');
	}
	elseif ($L->gS(array('ajax'), false, 0, 'contry'))
	{
		$name = cp1251($L->gS(array('name'), 'contry'));
		$contry = cp1251($L->gS(array('value'), ''));
		$sql = '
SELECT l.`name`, IF(l.`name`="%s", 1, 0) AS `selected`
FROM `z_d_location` l
WHERE l.`pid`=0
;
';
		$sql = sprintf($sql, noSQLinclude($contry));
		$data = $DB->q2($sql, 0);
		if (is_array($data))
		{
			foreach ($data as $d)
			{
				$D = array('value'=>strTOhtml($d['name']), 'selected'=>$d['selected'] ? 'selected="selected"' : '', 'text'=>strTOhtml($d['name']));
				$T->insert_loop('contry.option', array('D'=>$D));
			}
		}
		$D = array('name'=>$name, 'value'=>'');
		$T->assign('D', $D);
		$T->parse('contry');
		print $T->text('contry');
	}
	elseif ($L->gS(array('ajax'), false, 0, 'city'))
	{
		print 'xxx';
		exit;
		$name = cp1251($L->gS('name', 'city'));
		$contry = cp1251($L->gS(array('value', 'contry'), ''));
		$city = cp1251($L->gS(array('value'), 'city'));
		$sql = '
';
		$data = $DB->q2($sql, 0);
		if (is_array($data))
		{
			foreach ($data as $d)
			{
				$D = array('value'=>strTOhtml($d['name']), 'selected'=>$d['selected'] ? 'selected="selected"' : '', 'text'=>strTOhtml($d['name']));
				$T->insert_loop('city.option', array('D'=>$D));
			}
		}
		$D = array('name'=>$name, 'value'=>'');
		$T->assign('D', $D);
		$T->parse('city');
		print $T->text('city');
	}
	elseif ($L->gS(array('ajax'), false, 0, 'shipment-form-add'))
	{
		// weight
		$sql = '
SELECT ww.`type`, w.`id`, w.`enable`, w.`show`, w.`value`, w.`style`
FROM
(
	SELECT w.type, w.value, IF(w.value IS NULL, NULL, w.id) AS `id`
	FROM (
		SELECT w.`type`, w.`value`, w.`id`
		FROM `z_d_weight` w
		GROUP BY w.`type`, w.`value` WITH ROLLUP
		HAVING w.type IS NOT NULL
	) w
) ww
LEFT JOIN `z_d_weight` w
ON ww.`id` = w.`id`
ORDER BY ww.`type` DESC, w.order ASC
;';
		$weight = $DB->q2($sql, 0);
		if ($weight && is_array($weight) && (count($weight) > 0))
		{
			foreach ($weight as $w)
			{
				$W = array();
				if ($w['id'] === null)
				{
					$W['value'] = $W['selected'] = '';
					$W['disabled'] = 'disabled="disabled"';
					if ($w['type'] === 'papers') $W['text'] = 'документы';
					elseif ($w['type'] === 'luggage') $W['text'] = 'груз недокументарного характера';
					else $W['text'] = '? ? ?';
					$W['style'] = 'style="color: gray;"';
				}
				else
				{
					$W['value'] = $w['id'];
					$W['selected'] = ($w['id'] === 1) ? 'selected="selected"' : '';
					$W['disabled'] = '';
					$W['text'] = $w['value'];
					$W['style'] = '';
				}
				$T->insert_loop('form.shipment.weight', array('D'=>array('weight'=>$W)));
			}
		}
		//
		$D = array(
				'do'=>'add',
				'id'=>array('name'=>'s[id]', 'value'=>0),
				'created_at'=>'',
				'code'=>array('name'=>'s[code]', 'maxlength'=>30, 'value'=>''),
				'outsource_type'=>array('name'=>'s[outsource_type]', 'selected'=>array()),
				'outsource_number'=>array('name'=>'s[outsource_number]', 'maxlength'=>64, 'value'=>''),
				'outsource_comment'=>array('name'=>'s[outsource_comment]', 'maxlength'=>64, 'value'=>'', 'length'=>0),
				'state'=>array('name'=>'s[state]', 'value'=>array(), 'checked'=>array('queried'=>'checked="checked"')),
				'sender_company'=>array('name'=>'s[sender_company]', 'maxlength'=>30, 'value'=>''),
				'sender_person'=>array('name'=>'s[sender_person]', 'maxlength'=>30, 'value'=>''),
				'sender_zip'=>array('name'=>'s[sender_zip]', 'maxlength'=>10, 'value'=>''),
				'sender_contry'=>array('name'=>'s[sender_contry]', 'value'=>str_replace("'", "\\'", 'Україна')),
				'sender_city'=>array('name'=>'s[sender_city]', 'value'=>str_replace("'", "\\'", 'Київ')),
				'sender_address'=>array('name'=>'s[sender_address]', 'maxlength'=>64, 'value'=>''),
				'sender_comment'=>array('name'=>'s[sender_comment]', 'maxlength'=>64, 'value'=>'', 'length'=>0),
				'receiver_company'=>array('name'=>'s[receiver_company]', 'maxlength'=>30, 'value'=>''),
				'receiver_person'=>array('name'=>'s[receiver_person]', 'maxlength'=>30, 'value'=>''),
				'receiver_zip'=>array('name'=>'s[receiver_zip]', 'maxlength'=>10, 'value'=>''),
				'receiver_contry'=>array('name'=>'s[receiver_contry]', 'value'=>str_replace("'", "\\'", 'Україна')),
				'receiver_city'=>array('name'=>'s[receiver_city]', 'value'=>str_replace("'", "\\'", 'Київ')),
				'receiver_address'=>array('name'=>'s[receiver_address]', 'maxlength'=>64, 'value'=>''),
				'receiver_comment'=>array('name'=>'s[receiver_comment]', 'maxlength'=>64, 'value'=>'', 'length'=>0),
				'type'=>array('name'=>'s[type]', 'selected'=>array('papers'=>'selected="selected"')),
				'speed'=>array('name'=>'s[speed]', 'selected'=>array('express'=>'selected="selected"')),
				'fee'=>array('name'=>'s[fee]', 'selected'=>array('cash'=>'selected="selected"')),
				'payer'=>array('name'=> 's[payer]', 'selected'=>array('sender'=>'selected="selected"')),
				'weight'=>array('name'=>'s[weight]', 'value'=>0),
				'depth'=>array('name'=>'s[depth]', 'maxlength'=>10, 'value'=>''),
				'width'=>array('name'=>'s[width]', 'maxlength'=>10, 'value'=>''),
				'height'=>array('name'=>'s[height]', 'maxlength'=>10, 'value'=>''),
				'count'=>array('name'=>'s[count]', 'maxlength'=>10, 'value'=>1),
				'price'=>array('name'=>'s[price]', 'maxlength'=>10, 'value'=>''),
				'additional'=>array(),
				'comment'=>array('name'=>'s[comment]', 'maxlength'=>10000, 'value'=>'', 'length'=>0)
			);
		// state
		foreach (array('canceled', 'none', 'queried', 'opened', 'moving', 'done') as $i) { $D['state']['value'][$i] = $i; }
		// outsource
		foreach (array('none', 'DHL', 'UPS', 'TNT', 'FedEx', 'Aramex') as $i) { $D['outsource_type']['selected'][$i] = ($i === 'none') ? 'selected="selected"' : ''; }
		// additional
		for ($i = 0; $i < 5; $i++) { $D['additional'][$i] = array('name'=>sprintf('s[additional][%d]', $i), 'value'=>$i, 'checked'=>''); }
		// comment
		$D['sender_comment']['length'] = max($D['sender_comment']['maxlength'] - strlen($D['sender_comment']['value']), 0);
		$D['receiver_comment']['length'] = max($D['receiver_comment']['maxlength'] - strlen($D['receiver_comment']['value']), 0);
		$D['outsource_comment']['length'] = max($D['outsource_comment']['maxlength'] - strlen($D['outsource_comment']['value']), 0);
		$D['comment']['length'] = max($D['comment']['maxlength'] - strlen($D['comment']['value']), 0);
		$T->assign('D', $D);
		$T->parse('form.shipment.outsource');
		$T->parse('form.shipment');
		print $T->text('form.shipment');
	}
	elseif ($L->gS(array('ajax'), false, 0, 'shipment-form-edit'))
	{
		$sql = '
SELECT s.*, DATE_FORMAT(s.`created`, %s) AS `created_at`
FROM `z_shipment` s
WHERE s.`id`=%d;';
		$sql = sprintf($sql, "'%d-%m-%Y %H:%i'", $L->gS('id'));
		$shipment = $DB->q1($sql, 0);
		$shipment = strTOhtml($shipment);
		// weight
		$sql = '
SELECT ww.`type`, w.`id`, w.`enable`, w.`show`, w.`value`, w.`style`
FROM
(
	SELECT w.type, w.value, IF(w.value IS NULL, NULL, w.id) AS `id`
	FROM (
		SELECT w.`type`, w.`value`, w.`id`
		FROM `z_d_weight` w
		GROUP BY w.`type`, w.`value` WITH ROLLUP
		HAVING w.type IS NOT NULL
	) w
) ww
LEFT JOIN `z_d_weight` w
ON ww.`id` = w.`id`
ORDER BY ww.`type` DESC, w.order ASC
;';
		$weight = $DB->q2($sql, 0);
		if ($weight && is_array($weight) && (count($weight) > 0))
		{
			foreach ($weight as $w)
			{
				$W = array();
				if ($w['id'] === null)
				{
					$W['value'] = $W['selected'] = '';
					$W['disabled'] = 'disabled="disabled"';
					if ($w['type'] === 'papers') $W['text'] = 'документы';
					elseif ($w['type'] === 'luggage') $W['text'] = 'груз недокументарного характера';
					else $W['text'] = '? ? ?';
					$W['style'] = 'style="color: gray;"';
				}
				else
				{
					$W['value'] = $w['id'];
					$W['selected'] = ($w['id'] === $shipment['weight_id']) ? 'selected="selected"' : '';
					$W['disabled'] = '';
					$W['text'] = $w['value'];
					$W['style'] = '';
				}
				$T->insert_loop('form.shipment.weight', array('D'=>array('weight'=>$W)));
			}
		}
		//
		$shipment['depth'] = ($shipment['depth'] > 0) ? $shipment['depth'] : '';
		$shipment['width'] = ($shipment['width'] > 0) ? $shipment['width'] : '';
		$shipment['height'] = ($shipment['height'] > 0) ? $shipment['height'] : '';
		$shipment['count'] = ($shipment['count'] > 0) ? $shipment['count'] : '';
		$shipment['price'] = ($shipment['price'] > 0) ? sprintf('%.2f', $shipment['price']) : '';
		$D = array(
				'do'=>'edit',
				'id'=>array('name'=>'s[id]', 'value'=>$shipment['id']),
				'created_at'=>$shipment['created_at'],
				'code'=>array('name'=>'s[code]', 'maxlength'=>30, 'value'=>$shipment['code']),
				'outsource_type'=>array('name'=>'s[outsource_type]', 'selected'=>array()),
				'outsource_number'=>array('name'=>'s[outsource_number]', 'maxlength'=>64, 'value'=>$shipment['outsource_number']),
				'outsource_comment'=>array('name'=>'s[outsource_comment]', 'maxlength'=>64, 'value'=>$shipment['outsource_comment'], 'length'=>0),
				'state'=>array('name'=>'s[state]', 'value'=>array(), 'checked'=>array($shipment['state']=>'checked="checked"')),
				'sender_company'=>array('name'=>'s[sender_company]', 'maxlength'=>30, 'value'=>$shipment['sender_company']),
				'sender_person'=>array('name'=>'s[sender_person]', 'maxlength'=>30, 'value'=>$shipment['sender_person']),
				'sender_zip'=>array('name'=>'s[sender_zip]', 'maxlength'=>10, 'value'=>$shipment['sender_zip']),
				'sender_contry'=>array('name'=>'s[sender_contry]', 'value'=>str_replace("'", "\\'", $shipment['sender_contry'])),
				'sender_city'=>array('name'=>'s[sender_city]', 'value'=>str_replace("'", "\\'", $shipment['sender_city'])),
				'sender_address'=>array('name'=>'s[sender_address]', 'maxlength'=>64, 'value'=>$shipment['sender_address']),
				'sender_comment'=>array('name'=>'s[sender_comment]', 'maxlength'=>64, 'value'=>$shipment['sender_comment'], 'length'=>0),
				'receiver_company'=>array('name'=>'s[receiver_company]', 'maxlength'=>30, 'value'=>$shipment['receiver_company']),
				'receiver_person'=>array('name'=>'s[receiver_person]', 'maxlength'=>30, 'value'=>$shipment['receiver_person']),
				'receiver_zip'=>array('name'=>'s[receiver_zip]', 'maxlength'=>10, 'value'=>$shipment['receiver_zip']),
				'receiver_contry'=>array('name'=>'s[receiver_contry]', 'value'=>str_replace("'", "\\'", $shipment['receiver_contry'])),
				'receiver_city'=>array('name'=>'s[receiver_city]', 'value'=>str_replace("'", "\\'", $shipment['receiver_city'])),
				'receiver_address'=>array('name'=>'s[receiver_address]', 'maxlength'=>64, 'value'=>$shipment['receiver_address']),
				'receiver_comment'=>array('name'=>'s[receiver_comment]', 'maxlength'=>64, 'value'=>$shipment['receiver_comment'], 'length'=>0),
				'type'=>array('name'=>'s[type]', 'selected'=>array($shipment['type']=>'selected="selected"')),
				'speed'=>array('name'=>'s[speed]', 'selected'=>array($shipment['speed']=>'selected="selected"')),
				'fee'=>array('name'=>'s[fee]', 'selected'=>array($shipment['fee']=>'selected="selected"')),
				'payer'=>array('name'=> 's[payer]', 'selected'=>array($shipment['payer']=>'selected="selected"')),
				'weight'=>array('name'=>'s[weight]', 'value'=>0),
				'depth'=>array('name'=>'s[depth]', 'maxlength'=>10, 'value'=>$shipment['depth']),
				'width'=>array('name'=>'s[width]', 'maxlength'=>10, 'value'=>$shipment['width']),
				'height'=>array('name'=>'s[height]', 'maxlength'=>10, 'value'=>$shipment['height']),
				'count'=>array('name'=>'s[count]', 'maxlength'=>10, 'value'=>$shipment['count']),
				'price'=>array('name'=>'s[price]', 'maxlength'=>10, 'value'=>$shipment['price']),
				'additional'=>array(),
				'comment'=>array('name'=>'s[comment]', 'maxlength'=>10000, 'value'=>$shipment['comment'], 'length'=>0)
			);
		// state
		foreach (array('canceled', 'none', 'queried', 'opened', 'moving', 'done') as $i) { $D['state']['value'][$i] = $i; }
		// outsource
		foreach (array('none', 'DHL', 'UPS', 'TNT', 'FedEx', 'Aramex') as $i) { $D['outsource_type']['selected'][$i] = ($i === $shipment['outsource_type']) ? 'selected="selected"' : ''; }
		// additional
		for ($i = 0; $i < 5; $i++)
		{
			$ii = pow(2, $i);
			$D['additional'][$i] = array('name'=>sprintf('s[additional][%d]', $i), 'value'=>$i, 'checked'=>(($ii & $shipment['additional']) == $ii) ? 'checked="checked"' : '');
		}
		// comment
		$D['sender_comment']['length'] = max($D['sender_comment']['maxlength'] - strlen($D['sender_comment']['value']), 0);
		$D['receiver_comment']['length'] = max($D['receiver_comment']['maxlength'] - strlen($D['receiver_comment']['value']), 0);
		$D['outsource_comment']['length'] = max($D['outsource_comment']['maxlength'] - strlen($D['outsource_comment']['value']), 0);
		$D['comment']['length'] = max($D['comment']['maxlength'] - strlen($D['comment']['value']), 0);
		$T->assign('D', $D);
		$T->parse('form.shipment.outsource');
		$T->parse('form.shipment');
		print $T->text('form.shipment');
	}
	elseif ($L->gS(array('ajax'), false, 0, 'shipment-history-list'))
	{
		print 'shipment-history-list';
	}
	elseif ($L->gS(array('ajax'), false, 0, 'shipment-history-form-add'))
	{
		print 'shipment-history-form-add';
	}
	elseif ($L->gS(array('ajax'), false, 0, 'shipment-rows'))
	{
		print 'shipment-rows';
	}
	elseif ($L->gS(array('ajax'), false, 0, 'shipment-row'))
	{
		print 'shipment-row';
	}
	else
	{
		sleep(1);
		$g = cp1251($L->g());
		print 'GET:' . "\n"; print_r($g);
	}
}
else
{
	header('Content-Type: text/html; charset=windows-1251');
	session_start();
	$P = array(
			'items'=>$DB->q0('SELECT COUNT(*) FROM `z_shipment` s', 0, 0),
			'item_per_page'=>10,
			'page'=>$L->gI(array('p'), 1, 1) - 1,
			'page_range'=>3
		);
	$P['pages'] = (int)ceil($P['items'] / $P['item_per_page']);
	$P['page'] = min($P['page'], $P['pages'] - 1);
	$P['item_start'] = $P['page'] * $P['item_per_page'];
	// list
	$sql = '
SELECT s.*, DATE_FORMAT(s.`created`, "%s") AS `created_at`, DATE_FORMAT(s.`created`, "%s") AS `created_date`, DATE_FORMAT(s.`created`, "%s") AS `created_time`, w.value AS `weight`
FROM `z_shipment` s
LEFT JOIN `z_d_weight` w ON s.`weight_id` = w.`id`
ORDER BY `created_date` ASC, s.`code` ASC
LIMIT %d, %d
;';
	$sql = sprintf($sql, '%d/%m/%Y %H:%i', '%d/%m/%Y', '%H:%i:%s', $P['item_start'], $P['item_per_page']);
	$data = $DB->q2($sql, 'a');
	if ($data && is_array($data) && (count($data) > 0))
	{
		$i = 0;
		foreach($data as $d)
		{
			$d = strTOhtml($d);
			$d['i'] = $i;
			$d['color'] = $i % 2;
			//$d['outsource_comment'] = nl2br($d['outsource_comment']);
			//$d['sender_comment'] = nl2br($d['sender_comment']);
			//$d['receiver_comment'] = nl2br($d['receiver_comment']);
			//$d['comment'] = nl2br($d['comment']);
			$T->assign('D', $d);
			//if ($d['outsource_type'] !== 'none') $T->parse('list.rows.row.outsource');
			//if ($d['type'] !== 'none') $T->parse('list.rows.row.type_' . $d['type']);
			//if ($d['speed'] !== 'none') $T->parse('list.rows.row.speed_' . $d['speed']);
			//if ($d['fee'] !== 'none') $T->parse('list.rows.row.fee_' . $d['fee']);
			//if ($d['payer'] !== 'none') $T->parse('list.rows.row.payer_' . $d['payer']);
			//if ($d['additional'] === 0) $T->parse('list.rows.row.additional_0');
			//else foreach (array(1, 2, 4, 8, 16, 32) as $a) ($d['additional'] & $a) ? $T->parse('list.rows.row.additional_' . $a) : 0;
			$T->insert_loop('list.rows.row', null);
			$i++;
		}
		$T->parse('list.rows');
	}
	else $T->parse('list.empty');
	$T->parse('list');
	// pages && goto
	$pages = array();
	$pages[] = 0;
	if ($P['pages'] > 1)
	{
		if (($P['page'] - $P['page_range']) > 1) $pages[] = null;
		for ($i = max($P['page'] - $P['page_range'], 1), $I = min($P['page'] + $P['page_range'], $P['pages'] - 2); $i <= $I; $i++) { $pages[] = $i; }
		if (($P['page'] + $P['page_range']) < $P['pages'] - 2) $pages[] = null;
		$pages[] = $P['pages'] - 1;
		foreach ($pages as $p)
		{
			if ($p === null) $T->parse('pages.page.delimiter');
			else
			{
				$D = array(
						'href'=>'?p=' . ($p + 1),
						'title'=>$p + 1
					);
				$T->assign('D', $D);
				$T->parse(($p === $P['page']) ? 'pages.page.current' : 'pages.page.link');
			}
			$T->insert_loop('pages.page', null);
		}
		$D = array(
				'value'=>$P['page'] + 1
			);
		$T->assign('D', $D);
		$T->parse('pages.goto');
	}
	$T->parse('pages');
	// html
	$DATA = array(
			'title'=>'tracking - admin',
			'description'=>'',
			'keywords'=>'',
			'content'=>$T->text('list'),
			'pages'=>$T->text('pages')
		);
	$T->assign('DATA', $DATA);
	$T->parse('html');
	print $T->text('html');
	session_write_close();
	exit;
}

?>