<?php
class beMenu extends beConfigurable {

    protected $data = null;

    protected $parent = null;

    protected $level = 0;

    protected $childs = array();

    protected $renderer = null;
    
    protected $isParent = null;

    public function __construct($data = array()) {

        $this->configure();
    
        $this->setData($data);

        $this->parent = $parent;

    }

    public function getDefaultOptions() {

        return array('renderer' => 'beMenuRenderer');

    }

    public function getChilds() {
    
        return $this->childs;
    
    }
    
    public function fromBitrixTree($tree) {

        $current = $this;

        foreach($tree as $item) {

            if ($item['DEPTH_LEVEL'] == $current->getData('DEPTH_LEVEL')) {
                $current = $current->getParent()->addChild($item);
            }
            elseif ($item['DEPTH_LEVEL'] > $current->getData('DEPTH_LEVEL')) {
                $current = $current->addChild($item);
            }
            elseif ($item['DEPTH_LEVEL'] < $current->getData('DEPTH_LEVEL')) {
                $current = $current->getParentByData('DEPTH_LEVEL', $item['DEPTH_LEVEL']-1)->addChild($item);
            }

        }

        return $this;

    }

    public function childsToBitrixMenuTree() {
    
        $items = array();
        
        foreach($this->childs as $child) $items = array_merge($items, $child->toBitrixMenuTree());
        
        return $items;
    
    }

    public function toBitrixMenuTree() {
            
        $items = array_merge(
            array($this->renderBitrixMenuItem()),
            $this->childsToBitrixMenuTree()
        );
                
        return $items;
        
    }
    
    public function renderBitrixMenuItem() {
    
        return array(
                $this->getData('TEXT'), 
                $this->getData('LINK'), 
                array(), 
                array('FROM_IBLOCK' => 1, 'DEPTH_LEVEL' => $this->getLevel()),             
            );
    
    }
    
    public function setData($data) {

        $this->data = $data;

        return $this;

    }

    public function setParent(beMenu $parent) {

        $this->parent = $parent;

        return $this;

    }

    public function getParent() {

        return $this->parent;

    }

    public function addChild($child) {

        if (!$child instanceof beMenu) {
            $className = get_class($this);
            $child = new $className($child);
        }

        $child->setParent($this);
        $child->setLevel($this->getLevel() + 1);

        $this->childs[] = $child;

        return $child;

    }

    public function setLevel($level) {

        $this->level = $level;

        return $this;

    }

    public function getLevel() {

        return $this->level;

    }

    public function getCountChilds() {

        return count($this->childs);

    }

    public function getParentByLevel($level) {

        $current = $this;
        while ($current) {
            if ($current->level == $level) return $current;
            $current = $current->parent;
        }

        return $null;

    }

    public function getParentByData($name, $value) {

        $current = $this;
        while ($current) {
            if ($current->getData($name) == $value) return $current;
            $current = $current->parent;
        }

        return $null;

    }

    public function render() {

        return $this->getRenderer()->renderChilds($this);

    }

    public function getRenderer() {

        if (!$this->renderer) $this->buildRenderer();

        return $this->renderer;

    }

    protected function buildRenderer() {

        $rendererClass = $this->getOption('renderer');

        if ($rendererClass) $this->renderer = new $rendererClass();

    }

/*
    public function render($classes = array(), $renderAll = true) {

        $classes = array_merge($classes, array('item'));
        if ($this->isActive()) $classes[] = 'open';
        if ($this->isCurrent()) $classes[] = 'active';
        if (!$this->hasChilds()) $classes[] = 'no-childs';
        $html = '<li class="'.implode(' ', $classes).'">';
        $html .= '<a href="'.$this->options['LINK'].'">'.$this->options['TEXT'].'</a>';
        if (($renderAll || $this->isActive()) && count($this->childs)) $html .= '<ul>'.$this->renderChilds($renderAll).'</ul>';
        $html .= '</li>';

        return $html;

    }
 *
 */

    public function hasChilds() {

        return $this->getCountChilds()? true : false;

    }

 /*
    public function renderChilds($renderAll = true) {
        $htmlParts = array();
        $number = 0;
        $count = count($this->childs);
        foreach($this->childs as $child) {
            $classes = array();
            if ($number == 0) $classes[] = 'first';
            if ($number == $count-1) $classes[] = 'last';
            $htmlParts[] = $child->render($classes, $renderAll);
            $number++;
        }
        return $count? implode('', $htmlParts) : null;
    }
  *
  */

    public function isHightlight() {
                
        if (!$this->isCurrent() && $this->isParent() && !$this->hasChilds()) return true;
                
        return false;
        
    }
  
    public function isCurrent() {

        global $APPLICATION;
        
        $curentUrl = $APPLICATION->GetCurPage();
        $curentUrlWitoutIndexPhp = preg_replace('%index.php$%six', '', $curentUrl);
        
        return in_array($this->data['LINK'], array($curentUrl, $curentUrlWitoutIndexPhp));

    }

    public function isParent() {
    
        if (null == $this->isParent) $this->isParent = $this->checkIsParent();
        
        return $this->isParent;

    }
    
    protected function checkIsParent() {
    
        if ($this->data['SELECTED'] && !$this->isCurrent()) return true;
    
        foreach($this->childs as $child) if ($child->isCurrent() || $child->isParent()) return true;        

        return false;
        
    }

    public function getLabel() {

        return $this->getData('TEXT');

    }

    public function getLink() {

        return $this->getData('LINK');

    }

    public function getData($name = null) {
    
        return beArray::get($this->data, $name);

    }
    
    public function getAllData() {  
    
        return $this->data;
        
    }

}
