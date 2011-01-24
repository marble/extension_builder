{namespace k=Tx_ExtbaseKickstarter_ViewHelpers}<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

<f:for each="{extension.Plugins}" as="plugin">
Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'<k:uppercaseFirst>{plugin.key}</k:uppercaseFirst>',
	'{plugin.name}'
);

//$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_{plugin.key}'] = 'pi_flexform';
//t3lib_extMgm::addPiFlexFormValue($_EXTKEY . '_{plugin.key}', 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_{plugin.key}.xml');

</f:for>

<f:for each="{extension.BackendModules}" as="backendModule">
	/**
	* Registers a Backend Module
	*/
	Tx_Extbase_Utility_Extension::registerModule(
		$_EXTKEY,
		'{backendModule.mainModule}',	 // Make module a submodule of '{backendModule.mainModule}'
		'{backendModule.key}',	// Submodule key
		'',						// Position
		array(
			<f:for each="{extension.domainObjectsForWhichAControllerShouldBeBuilt}" as="domainObject">'{domainObject.name}' => 'list, show, new, create, edit, update, delete',</f:for>
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_{backendModule.key}.xml',
		)
	);
</f:for>

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', '{extension.name}');



<f:for each="{extension.domainObjects}" as="domainObject">
t3lib_extMgm::addLLrefForTCAdescr('{domainObject.databaseTableName}', 'EXT:{extension.extensionKey}/Resources/Private/Language/locallang_csh_{domainObject.databaseTableName}.xml');
t3lib_extMgm::allowTableOnStandardPages('{domainObject.databaseTableName}');
$TCA['{domainObject.databaseTableName}'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:{extension.extensionKey}/Resources/Private/Language/locallang_db.xml:{domainObject.databaseTableName}',
		'label' 			=> '{domainObject.listModuleValueLabel}',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/{domainObject.name}.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/{domainObject.databaseTableName}.gif'
	)
);
</f:for>

?>