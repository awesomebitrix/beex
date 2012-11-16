<?php
class beFormWidget {

    protected $attributes = array();
    
    protected $field = null;
    
    public function renderLabel($label = null) {
        
        if ($label === null) $label = $this->field->getOption('label');
        
        $id = $this->getAttributeId();
        return '<label for="'.$id.'">'.$label.'</label>';
    }
    
    public function renderField($attributes = array()) {
        $attributes = array_merge(array(
            'name' => $this->getAttributeName(),
            'id' => $this->getAttributeId(),
            'value' => $this->field->getValue(),
        ), $attributes);
        
        return $this->renderFieldWithAttributes($attributes);
    }
    
    public function renderErrors() {
    
        $errors = $this->field->getErrors();
        if (!$errors) return null;
        
        return '<ul class="error-list"><li>'.implode('</li><li>', $errors).'</li></ul>';
        
    }
    
    protected function renderFieldWithAttributes($attributes = array()) {
        return '<input '.$this->attributesToHtml($attributes).' />';        
    }
    
    protected function attributesToHtml($attributes) {
        return beHtml::renderAttributes($attributes);
    }
    
    public function getAttributeName() {
        $name = $this->getAttribute('name');
        if (!$name) $name = $this->generateAttributeName();
        return $name;        
    }
    
    public function getAttributeId() {
        $id = $this->getAttribute('id');
        if (!$id) $id = $this->generateAttributeId();
        return $id;
    }
    
    protected function generateAttributeName() {
        
        if (!$this->field) return null;
        $form = $this->field->getForm();
        if (!$form) return null;
        
        return $form->getName().'['.$this->field->getName().']';
        
    }
    
    protected function generateAttributeId() {
        
        if (!$this->field) return null;
        $form = $this->field->getForm();
        if (!$form) return null;
        
        return $form->getName().'__'.$this->field->getName();
        
    }
    
    public function setAttribute($name, $value) {
        $this->attributes[$name] = $value;
    }
    
    public function getAttribute($name) {
        return beArray::get($this->attributes, $name);
    }
    
    public function setField(beFormField $field) {
        $this->field = $field;
        return $this;
    }
    
}