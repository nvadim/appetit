<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("BD_SETTING_HIDE_NAME"),
	"DESCRIPTION" => GetMessage("BD_SETTING_HIDE_DESCRIPTION"),
	"ICON" => "/images/icon.gif",
	"SORT" => 100,
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "bd",
		"NAME" => GetMessage("BD_GLOBAL_DIR_NAME"),
		"CHILD" => array(
			"ID" => "bd_timer",
			"NAME" => GetMessage("BD_SETTING_HIDE_DIR_NAME")
		),

	),
);
