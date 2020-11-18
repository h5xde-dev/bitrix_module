<?

if(!CModule::IncludeModule('iblock'))
	return false;

IncludeModuleLangFile(__FILE__);


CModule::AddAutoloadClasses(
	'centrobank',
	array(
		'Centrobank' => 'classes/general/centrobank.php',
	)
);

?>