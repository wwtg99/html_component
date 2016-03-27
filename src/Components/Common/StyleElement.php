<?php
/**
 * Created by PhpStorm.
 * User: wwt
 * Date: 2016/3/22 0022
 * Time: 下午 5:31
 */

namespace Components\Common;


use HtmlObject\Element;

abstract class StyleElement extends Element
{
    /**
     * [key => ['name' => 'style', ...], ...]
     *
     * @var array
     */
    protected $styles = [];

    /**
     * [key => ['class', ...], ...]
     *
     * @var array
     */
    protected $cssClass = [];

    /**
     * Render element view with data.
     *
     * @param $data
     * @return string
     */
    abstract public function view($data);

    /**
     * @return array
     */
    public function getStyles()
    {
        return $this->styles;
    }

    /**
     * @param array $styles
     * @return StyleElement
     */
    public function setStyles($styles)
    {
        $this->styles = $styles;
        return $this;
    }

    /**
     * @return array
     */
    public function getCssClass()
    {
        return $this->cssClass;
    }

    /**
     * @param array $cssClass
     * @return StyleElement
     */
    public function setCssClass($cssClass)
    {
        $this->cssClass = $cssClass;
        return $this;
    }

    /**
     * @param string $name
     * @return string
     */
    protected function getClass($name)
    {
        if (array_key_exists($name, $this->cssClass)) {
            if (is_array($this->cssClass[$name])) {
                return implode(' ', $this->cssClass[$name]);
            } else {
                return $this->cssClass[$name];
            }
        }
        return '';
    }

    /**
     * @param string $name
     * @return string
     */
    protected function getStyle($name)
    {
        if (array_key_exists($name, $this->styles)) {
            if ($this->styles[$name]) {
                return $this->formatStyle($this->styles[$name]);
            }
        }
        return '';
    }

    /**
     * @param array $styles
     * @return string
     */
    protected function formatStyle(array $styles)
    {
        if (!$styles) {
            return '';
        }
        $s = [];
        foreach ($styles as $k => $v) {
            array_push($s, "$k: $v;");
        }
        return implode(' ', $s);
    }
}