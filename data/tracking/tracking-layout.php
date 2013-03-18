<?

function shipment_rows($page = 0)
{
	global $DB;
	$T = templateHtml('modules/tracking/tracking.htm');
	$P = array(
			'item_at_page' => 10,
			'item_count' => $DB->q0('SELECT COUNT(*) FROM `z_shipment` s', 0, 0),
			'page' => max(0, (int)$page)
		);
	$P = pagesInit($P);
	// shipment.noempty
	$sql = '
SELECT s.*, DATE_FORMAT(s.`created`, "%s") AS `created_at`, DATE_FORMAT(s.`created`, "%s") AS `created_date`, DATE_FORMAT(s.`created`, "%s") AS `created_time`, w.value AS `weight`
FROM `z_shipment` s
LEFT JOIN `z_d_weight` w ON s.`weight_id` = w.`id`
ORDER BY `created_date` ASC, s.`code` ASC
LIMIT %d, %d
;';
	$sql = sprintf($sql, '%d/%m/%Y %H:%i', '%d/%m/%Y', '%H:%i:%s', $P['item_first'], $P['item_at_page']);
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
			//if ($d['outsource_type'] !== 'none') $T->parse('shipment.data.row_all.row_one.outsource');
			//if ($d['type'] !== 'none') $T->parse(sprintf('shipment.data.row_all.row_one.type_%s', $d['type']));
			//if ($d['speed'] !== 'none') $T->parse(sprintf('shipment.data.row_all.row_one.speed_%s', $d['speed']));
			//if ($d['fee'] !== 'none') $T->parse(sprintf('shipment.data.row_all.row_one.fee_%s', $d['fee']));
			//if ($d['payer'] !== 'none') $T->parse(sprintf('shipment.data.row_all.row_one.payer_%s', $d['payer']));
			//if ($d['additional'] === 0) $T->parse('shipment.data.row_all.row_one.additional_0');
			//else foreach (array(1, 2, 4, 8, 16, 32) as $a) ($d['additional'] & $a) ? $T->parse('shipment.data.row_all.row_one.additional_' . $a) : 0;
			$T->insert_loop('shipment.data.row_all.row_one', null);
			$i++;
		}
		$T->parse('shipment.data.row_all');
		$T->parse('shipment.data');
	}
	else $T->parse('shipment.empty');
	$T->parse('shipment');

	// html
	print $T->text('shipment') . pagesHtml('tracking', $P);
}

?>