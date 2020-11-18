<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	'NAME' => GetMessage('CB_COMPLEX_NAME'),
	'DESCRIPTION' => GetMessage('CB_COMPLEX_DESCRIPTION'),
	'PATH' => array(
		'ID' => 'content',
		'CHILD' => array(
			'ID' => 'centrobank',
			'NAME' => GetMessage('CB_NAME')
		)
	),
	'CACHE_PATH' => 'Y'	
);
?>