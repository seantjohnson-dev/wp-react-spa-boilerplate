<?php

namespace SeanJohn\Customizer\Lib;

class BaseControl extends BaseCustomizer
{
    protected $type = 'control';
    protected $fieldType;
    protected $default;
    protected $optionType;

    public function isValid()
    {
        return parent::isValid() && isset($this->fieldType) && !empty($this->fieldType);
    }
}
