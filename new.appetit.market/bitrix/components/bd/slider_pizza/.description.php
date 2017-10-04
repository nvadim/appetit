<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("BD_TIMER_NAME"),
	"DESCRIPTION" => GetMessage("BD_TIMER_DESCRIPTION"),
	"ICON" => "/images/icon.gif",
	"SORT" => 100,
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "bd",
		"NAME" => GetMessage("BD_GLOBAL_DIR_NAME"),
		"CHILD" => array(
			"ID" => "bd_timer",
			"NAME" => GetMessage("BD_TIMER_DIR_NAME")
		),

	),
);
