<?php
class beForm extends beConfigurable {
    
    protected $fields = array();
    
    public function __construct($options = array()) {
        $this->configure($options);
    }
    
    public function getDefaultOptions() {
        return array(
            'name' => 'form',
            'method' => 'post',
            'action' => $_SERVER['REQUEST_URI'],
        );
    }
    
    public function canProcess() {
        return beArray::get($_REQUEST, $this->getName()) && $this->bindRequestAndValid();
    }
    
    public function clear() {
        foreach($this->fields as $field) $field->setValue(null);
    }
    
    public function bindRequestAndValid() {
        $this->bindRequest();
        $this->validate();
        return !$this->hasErrors();
    }
    
    public function bindRequest() {
        
        $data = beArray::get($_REQUEST, $this->getName());

        if (!$data) return;
        foreach($this->fields as $name => $field) {
            $value = beArray::get($data, $field->getName());
            $field->setValue($value);
        }
        
    }
    
    public function open($attributes = array()) {
        $attributes = array_merge(array(
            'method' => $this->getOption('method'),
            'action' => $this->getOption('action'),
        ), $attributes);
        return '<form '.beHtml::renderAttributes($attributes).'>';
    }
    
    public function close() {
        return '</form>';
    }
    
    public function add($name, beFormWidget $widget, $options = array()) {
    
        $field = new beFormField($options);
        
        $field->setWidget($widget);
        
        $field->setValidator(new beFormValidator);
        
        $field->setForm($this);
        $field->setName($name);
        
        $this->fields[$name] = $field;
    
    }
    
    public function get($name) {
        return beArray::get($this->fields, $name);
    }

    public function validate() {
        foreach($this->fields as $field) $field->validate(); 
    }
    
    public function hasErrors() {
        foreach($this->fields as $field) if($field->hasErrors()) return true; 
        return false;
    }
    
    public function __get($name) {
        return beArray::get($this->fields, $name);
    }
    
    public function getName() {
        return $this->getOption('name');
    }
    
    public function getFields() {
        return $this->fields;
    }
    
}