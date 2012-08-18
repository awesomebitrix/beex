<?php
class beString {

    public static function morph($number, $form1, $form2, $form3) {

        $lastDigit = intval(substr($number,-1));
        if ($number>=5 && $number<=20) $form = $form3;
        elseif (in_array($lastDigit, array(1))) $form = $form1;
        elseif (in_array($lastDigit, array(2,3,4)))$form = $form2;
        else return $form = $form3;
        return $form;

    }

}
