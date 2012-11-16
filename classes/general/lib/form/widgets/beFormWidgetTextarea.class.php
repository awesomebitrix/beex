<?php
class beFormWidgetTextarea extends beFormWidget {

    protected function renderFieldWithAttributes($attributes = array()) {
        unset($attributes['value']);
        return '<textarea '.$this->attributesToHtml($attributes).'>'.$this->field->getValue().'</textarea>';
    }


}