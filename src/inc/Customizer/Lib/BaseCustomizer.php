<?php

namespace SeanJohn\Customizer\Lib;

use Kirki as Kirki;

class BaseCustomizer
{
    protected $name;
    protected $type;
    protected $description;
    protected $priority = 100;
    protected $disabled = false;
    protected $wp_cust;

    public function __construct()
    {
        add_action('customize_register', [$this, 'on_customize_register']);
    }

    public function on_customize_register($wp_cust) {
        $this->wp_cust = $wp_cust;
        $this->set_panels()->set_sections()->set_controls();
        return $this;
    }

    protected function set_panels()
    {
        return $this;
    }

    protected function set_sections()
    {
        return $this;
    }

    protected function set_controls()
    {
        return $this;
    }

    public function registerSelf()
    {
        if (!$this->isDisabled()) {
            $props = array(
                'priority' => $this->priority,
                'title' => __($this->title, TEXT_DOMAIN),
                );
            if (empty($this->title)) {
                $this->generateTitle();
            }
            if (!empty($this->description)) {
                $props['description'] = __($this->description, TEXT_DOMAIN);
            }
            Kirki::{'add_'.$this->type}($this->name, $props);
        }

        return $this;
    }

    public function isDisabled()
    {
        return $this->disabled;
    }

    public function enable()
    {
        $this->disabled = false;

        return $this;
    }

    public function disable()
    {
        $this->disabled = true;

        return $this;
    }

    public function isValid()
    {
        return isset($this->name) && !empty($this->name)
            && isset($this->type) && !empty($this->type);
    }

    protected function ensureName()
    {
        if (!isset($this->name)) {
            trigger_error('Name must be set:'.get_class($this), E_USER_WARNING);
        }

        return $this;
    }

    protected function ensurePriority($priority)
    {
        $priority = intval($priority);
        $this->priority = ($priority > 0 ? $priority : $this->priority);

        return $this;
    }

    protected function generateTitle()
    {
        if ($this->isValid() && !isset($this->title)) {
            $this->title = ucwords(preg_replace('/[_-]/', ' ', $this->name));
        }

        return $this;
    }
}
