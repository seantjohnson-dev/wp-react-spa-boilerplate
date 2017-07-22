<?php

  namespace SeanJohn\Lib;
  use SeanJohn\Lib\BaseClass;
  use SeanJohn\Utils\Utils;

  class ManagerClass extends BaseClass {

    protected $instances = [];
    protected $defaults = [
      'classes' => []
    ];

    public function __construct($options = [])
    {
      parent::__construct($options);
      $this->initInstances();
    }

    protected function initInstances() {
      $instances = [];
      $classesConfig = Utils::ensureArray($this->getOption('classes'));
      foreach($classesConfig as $className=>$classOptions) {
        if (class_exists($className)) {
          $instances[$className] = new $className($classOptions);
        }
      }
      return $this->setInstances($instances);
    }

    public function getInstances() {
      return $this->instances;
    }

    public function getInstance($instance) {
      if (array_key_exists($instance, $this->instances)) {
        return $this->instances[$instance];
      }
      return false;
    }

    protected function setInstances($instances) {
      $this->instances = $instances;
      return $this;
    }

    protected function setOptions($options, $replace = false)
    {
        if (isset($options['classes']) && is_array($options['classes'])) {
          $this->options['classes'] = array_merge($this->defaults['classes'], ($replace ? $options['classes'] : array_merge($this->options, $options['classes'])));
        }
        return $this;
    }

  }
