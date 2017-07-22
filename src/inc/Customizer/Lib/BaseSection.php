<?php

namespace SeanJohn\Customizer\Lib;

class BaseSection extends BaseCustomizer
{
    protected $childType = 'control';
    protected $children;
    protected $_children = array();

    public function registerSelf()
    {
        parent::registerSelf();

        return $this->registerChildren();
    }

    public function registerChildren()
    {
        if ($this->isValid() && !$this->isDisabled()) {
            foreach ($this->children as $c => $child) {
                $fullName = __NAMESPACE.'\\'.ucfirst($this->childType).'s\\'.$child;
                $priority = ($s + 1) * 10;
                $c;
                if (class_exists($fullName)) {
                    $c = new $fullName($priority, (!$this->isDisabled() ? $this->name : ''));
                } elseif (class_exists($child)) {
                    $c = new $child($priority, (!$this->isDisabled() ? $this->name : ''));
                }
                $this->_children[$child] = $c;
            }
        }

        return $this;
    }

    public function isValid()
    {
        return parent::isValid() && isset($this->childType) && !empty($this->childType) && is_array($this->children);
    }
}
