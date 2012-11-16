<?php
class beFormField extends beConfigurable {
    
    protected $name;
    protected $widget;
    protected $validator;
    protected $value;
    protected $renderParts = array();  
    protected $form;
    
    public function __construct($options = array()) {
        $this->configure($options);
    }
    
    public function getDefaultOptions() {
        return array(
        );
    }
    
    public function setForm(beForm $form) {
        $this->form = $form;
        return $this;
    }
    
    public function getForm() {
        return $this->form;
    }
    
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }
    
    public function getValue() {
        return $this->value;
    }
    
    public function setName($name) {
        $this->name = $name;
        return $this;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setWidget(beFormWidget $widget) {
        $this->widget = $widget;
        $this->widget->setField($this);
        return $this;
    }
    
    public function getWidget() {
        return $this->widget;
    }
    
    public function setValidator(beFormValidator $validator) {
        $this->validator = $validator;
        return $this;
    }
    
    public function validate() {
        $this->validator->execute($this->value);
    }
    
    
    public function label($text = null) {
        if (is_null($text)) $text = $this->getOption('label');
        $this->renderParts[] = $this->widget->renderLabel($text);
        return $this;
    }
        
    public function field($attributes = array()) {
        $this->renderParts[] = $this->widget->renderField($attributes);
        return $this;
    }
    
    public function errors() {
        $this->renderParts[] = $this->widget->renderErrors();
        return $this;
    }    
        
    public function __toString() {
    
        if (!$this->renderParts) $this->label()->field()->errors();
    
        $html = implode('', $this->renderParts);
        
        $this->renderParts = array();
        
        return $html;
    
    }
    public function hasErrors() {
        return (bool)$this->getErrors();
    }
    
    public function getErrors() {
        return $this->validator->getErrors();
    }
    
}
