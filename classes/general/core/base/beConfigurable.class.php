<?phpclass beConfigurable {    protected $options = array();    public function configure($options = array()) {        $this->setOptions($this->getDefaultOptions());        $this->addOptions($options);    }    public function getDefaultOptions() {        return array();    }    public function setOptions($options) {        $this->options = $options;    }    public function getOption($name) {        return beCoreArray::get($this->options, $name);    }    public function getOptions() {        return $this->options;    }    public function setOption($name, $value) {        $this->options[$name] = $value;        return $this;    }    public function addOptions($options) {        $this->options = array_merge($this->options, $options);        return $this;    }}