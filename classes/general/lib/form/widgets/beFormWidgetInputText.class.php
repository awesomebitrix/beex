<?php
class beFormWidgetInputText extends beFormWidget {

    protected function renderFieldWithAttributes($attributes = array()) {
        $attributes['type'] = 'text';
        return parent::renderFieldWithAttributes($attributes);
    }


}