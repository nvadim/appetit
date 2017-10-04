<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("BD_VK_REPOST_NAME"),
	"DESCRIPTION" => GetMessage("BD_VK_REPOST_DESCRIPTION"),
	"ICON" => "/images/icon.gif",
	"SORT" => 100,
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "bd",
		"NAME" => GetMessage("BD_GLOBAL_DIR_NAME"),
		"CHILD" => array(
			"ID" => "bd_vk_repost",
			"NAME" => GetMessage("BD_VK_REPOST_DIR_NAME")
		),

	),
);
