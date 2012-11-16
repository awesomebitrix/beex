<?php
class beMenu extends beConfigurable {

    protected $data = null;

    protected $parent = null;

    protected $level = 0;

    protected $childs = array();

    protected $renderer = null;

    public function __construct($data = array()) {

        $this->setData($data);

        $this->parent = $parent;

    }

    public function getDefaultOptions() {

        return array('renderer' => 'beMenuRenderer');

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

    public function toBitrixMenuTree() {
        
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

    public function isCurrent() {

        global $APPLICATION;

        return ($this->data['LINK'] == $APPLICATION->GetCurPage());

    }

    public function isParrent() {

        foreach($this->childs as $child) if ($child->isCurrent()) return true;

        return false;

    }

    public function getLabel() {

        return $this->getData('TEXT');

    }

    public function getLink() {

        return $this->getData('LINK');

    }

    public function getData($name) {

        return beArray::get($this->data, $name);

    }

}
