<?php

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

if(class_exists('centrobank')) return;

Class centrobank extends CModule
{
	var $MODULE_ID = 'centrobank';
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $error = '';

	function __construct()
	{
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen('/index.php'));
		include($path.'/version.php');

		if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion))
		{
			$this->MODULE_VERSION = $arModuleVersion['VERSION'];
			$this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
		}
		else
		{
			$this->MODULE_VERSION = CB_VERSION;
			$this->MODULE_VERSION_DATE = CB_VERSION_DATE;
		}

		$this->MODULE_NAME = Loc::getMessage('CB_INSTALL_NAME');
		$this->MODULE_DESCRIPTION = Loc::getMessage('CB_INSTALL_DESCRIPTION');
	}

	function InstallDB()
    {
        global $DB;
        $this->errors = false;
		$sql = file_get_contents(__DIR__ .'/db/install.sql');
		
		if ($sql)
		{
			Bitrix\Main\Application::getConnection()->query($sql);
		}
    }

    function UnInstallDB()
    {
        global $DB;
        $this->errors = false;
        $sql = file_get_contents(__DIR__ .'/db/uninstall.sql');
		
		if ($sql)
		{
			Bitrix\Main\Application::getConnection()->query($sql);
		}
    }


	function DoInstall()
	{
		$this->InstallDB();
        $this->InstallEvents();
        $this->InstallFiles();
        \Bitrix\Main\ModuleManager::RegisterModule("centrobank");
        return true;
	}

	function InstallEvents()
    {
        return true;
    }

    function UnInstallEvents()
    {
        return true;
    }

    function InstallFiles()
    {
        return true;
    }

    function UnInstallFiles()
    {
        return true;
    }

	function DoUninstall()
	{
		$this->UnInstallDB();
        $this->UnInstallEvents();
		$this->UnInstallFiles();
		
		\Bitrix\Main\ModuleManager::UnRegisterModule("centrobank");
		
        return true;
	}

}
?>