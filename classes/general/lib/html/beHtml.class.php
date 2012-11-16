<?php
class beHtml {
    public static function renderAttributes($attributes) {
        foreach($attributes as $key => $value) if ( (is_string($value) || is_null($value)) && !trim($value)) unset($attributes[$key]);
        // beDebug::dump($attributes);
        $parts = array();
        foreach($attributes as $name => $value) {
            $parts[] = $name.'="'.(is_array($value)? implode(' ', $value) : $value).'"';
        }
        
        return implode(' ', $parts);    
    }
}