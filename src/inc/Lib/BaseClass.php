<?php

  namespace SeanJohn\Lib;
  use SeanJohn\Utils\Utils;

  class BaseClass {

    protected $defaults = [];
    protected $options = [];

    public function __construct($options = [])
    {
      $this->setOptions(Utils::ensureArray($options));
    }

    /**
     * Gets the value of a single option.
     *
     * @return mixed
     */
    public function getOption($option)
    {
        return (array_key_exists($option, $this->options) ? $this->options[$option] : false);
    }

    /**
     * Sets the value of a single option.
     *
     * @param string $key the option key
     * @param mixed $option the option value
     *
     * @return self
     */
    protected function setOption($key, $option)
    {
        if (!empty($key)) {
          $this->options[$key] = $option;
        }
        return $this;
    }

    /**
     * Gets the value of options.
     *
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Sets the value of options.
     *
     * @param mixed $options the options
     *
     * @return self
     */
    protected function setOptions($options, $replace = false)
    {
        $this->options = array_merge($this->defaults, ($replace ? $options : array_merge($this->options, $options)));
        return $this;
    }

    public function getDefaults() {
      return $this->defaults;
    }

  }
