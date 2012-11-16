<?php
class beMenuRenderer extends beConfigurable {

    public function __construct($options = array()) {

        $this->configure($options);

    }

    public function getDefaultOptions() {

        return array(
            'parentClass' => 'is-parent',
            'curentClass' => 'is-current',
            'itemClass' => 'item',
            'firstItemClass' => 'first',
            'lastItemClass' => 'last',
            'hasChildsClass' => 'has-childs',
            'noChildsClass' => 'no-childs',
        );

    }

    public function renderChilds(beMenu $menu) {

        $html = null;

        foreach($menu->getChilds() as $child) $html .= $this->renderItem($child);

        return $html;

    }

    public function renderItem(beMenu $menu, $classes = array()) {

        $html = $this->renderOpenLiTag($menu, $classes);
        $html .= $this->renderBody($menu);
        if ($menu->hasChilds()) $html .= '<ul>'.$this->renderChilds($menu).'</ul>';
        $html .= '</li>';

        return $html;

    }

    public function renderBody(beMenu $menu) {

        return $menu->isCurrent()
                ? '<span class="link">'.$menu->getLabel().'</span>'
                : '<a class="link" href="'.$menu->getLink().'">'.$menu->getLabel().'</a>'
        ;

    }

    public function renderOpenLiTag(beMenu $menu, $classes = array()) {

        $classes = array_merge($classes, array($this->getOption('itemClass')));
        if ($menu->isCurrent()) $classes[] = $this->getOption('curentClass');
        if ($menu->isParent()) $classes[] = $this->getOption('parentClass');

        return '<li classes="'.implode(' ', $classes).'">';

    }

}

?>
