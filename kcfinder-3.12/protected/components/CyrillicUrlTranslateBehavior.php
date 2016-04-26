<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date 05.03.2015
 */

class CyrillicUrlTranslateBehavior extends CActiveRecordBehavior{

    public $inputAttributeName = NULL;
    public $outputAttributeName = NULL;

    public function beforeValidate($event){
        $model = $this->owner;
        if(strlen($model->{$this->outputAttributeName}) > 0){
            $model->{$this->outputAttributeName} = self::cyrillicToLatin($model->{$this->outputAttributeName});
        }
        else{
            $model->{$this->outputAttributeName} = self::cyrillicToLatin($model->{$this->inputAttributeName});
        }
        return parent::beforeValidate($event);
    }

    /**
     * @param $text
     * @param bool $toLowCase
     * @return string
     */
    public static function cyrillicToLatin($text, $toLowCase = TRUE) {
        $matrix = array(
            "й" => "j", "ц" => "c", "у" => "u", "к" => "k", "е" => "e", "н" => "n",
            "г" => "g", "ш" => "sh", "щ" => "shc", "з" => "z", "х" => "h", "ъ" => "",
            "ф" => "f", "ы" => "y", "в" => "v", "а" => "a", "п" => "p", "р" => "r",
            "о" => "o", "л" => "l", "д" => "d", "ж" => "zh", "э" => "e", "ё" => "e",
            "я" => "ya", "ч" => "ch", "с" => "s", "м" => "m", "и" => "i", "т" => "t",
            "ь" => "", "б" => "b", "ю" => "u",
            "Й" => "j", "Ц" => "C", "У" => "U", "К" => "K", "Е" => "E", "Н" => "N",
            "Г" => "G", "Ш" => "SH", "Щ" => "SCH", "З" => "Z", "Х" => "H", "Ъ" => "",
            "Ф" => "F", "Ы" => "Y", "В" => "V", "А" => "A", "П" => "P", "Р" => "R",
            "О" => "O", "Л" => "L", "Д" => "D", "Ж" => "ZH", "Э" => "E", "Ё" => "E",
            "Я" => "YA", "Ч" => "CH", "С" => "S", "М" => "M", "И" => "I", "Т" => "T",
            "Ь" => "", "Б" => "B", "Ю" => "U",
            "«" => "", "»" => "", " " => "-",
            "\"" => "", "\." => "", "–" => "-", "\," => "", "\(" => "", "\)" => "",
            "\?" => "", "\!" => "", "\:" => "",
            '#' => '', '№' => '', ' - ' => '-', '/' => '-', '  ' => '-',
        );

        // Enforce the maximum component length
        $maxlength = 100;
        $text = implode(array_slice(explode('<br>', wordwrap(trim(strip_tags(html_entity_decode($text))), $maxlength, '<br>', false)), 0, 1));
        //$text = substr(, 0, $maxlength);

        foreach ($matrix as $from => $to) {
            $text = mb_eregi_replace($from, $to, $text);
        }

        // Optionally convert to lower case.
        if ($toLowCase) {
            $text = strtolower($text);
        }
        return $text;
    }
}