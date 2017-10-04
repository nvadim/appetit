<?
/**
* Helper
*/
class Helper
{

    static function FormatHTMLPhone($text)
    {
        return preg_replace('/(\+7\s\([\d]{3}\))\s([\d]{3}-[\d]{2}-[\d]{2})/', '$1 <strong>$2</strong>', $text);
    }

    static function WrapHTMLPhone($text)
    {
        $phone = preg_replace('/[^\d]/', '', $text);
        return '<a href="tel:'.$phone.'" class="phone-link">'.$text.'</a>';
    }

    static function WrapFormatHTMLPhone($text)
    {
        return self::WrapHTMLPhone(self::FormatHTMLPhone($text));
    }
}

CModule::AddAutoloadClasses(
    '',
    array(
        '\Aers\Migration' => '/local/lib/Aers/Migration.php',
        '\Aers\BasketController' => '/local/lib/Aers/BasketController.php',
    )
);

function p($data)
{
    global $USER;
    if ($USER->IsAdmin()) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}