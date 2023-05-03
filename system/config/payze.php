<?php 
$_['payze_setting'] = array(
	'general' => array(
		'title' =>  array(),
		'debug' => false,
		'preauthorize' => false
	),
	'order_status' => array(
		'blocked' =>  array(
			'code' => 'blocked',
			'name' => 'text_blocked_status',
			'id' => 1
		),
		'card_added' => array(
			'code' => 'card_added',
			'name' => 'text_card_added_status',
			'id' => 5
		),
		'committed' => array(
			'code' => 'committed',
			'name' => 'text_committed_status',
			'id' => 5
		),
		'created' => array(
			'code' => 'created',
			'name' => 'text_created_status',
			'id' => 1
		),
		'refunded' => array(
			'code' => 'refunded',
			'name' => 'text_refunded_status',
			'id' => 11
		),
		'refunded_partially' => array(
			'code' => 'refunded_partially',
			'name' => 'text_refunded_partially_status',
			'id' => 11
		),
		'rejected' => array(
			'code' => 'rejected',
			'name' => 'text_rejected_status',
			'id' => 8
		),		
		'timeout' => array(
			'code' => 'timeout',
			'name' => 'text_timeout_status',
			'id' => 10
		)
	),
	'language' => array('EN', 'KA', 'RU', 'UZ')
);
?>