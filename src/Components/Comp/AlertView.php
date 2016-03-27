<?php
/**
 * Created by PhpStorm.
 * User: wwt
 * Date: 2016/3/27 0027
 * Time: 下午 6:11
 */

namespace Components\Comp;


use Components\Common\StyleElement;
use HtmlObject\Text;

class AlertView extends StyleElement
{

    /**
     * @var string
     */
    private $level;

    /**
     * AlertView constructor.
     * Based on Bootstrap.
     * @param string $level
     */
    public function __construct($level = 'info')
    {
        parent::__construct('div');
        $this->level = $level;
        $this->cssClass = ['alert' => ['text-center', 'alert']];
        $this->styles = [];
    }

    /**
     * Render element view with data.
     *
     * @param $data
     * @return string
     */
    public function view($data)
    {
        switch($this->level) {
            case 'success': $css = 'alert-success'; break;
            case 'info': $css = 'alert-info'; break;
            case 'warning': $css = 'alert-warning'; break;
            case 'danger': $css = 'alert-danger'; break;
            default: $css = 'alert-info'; break;
        }
        array_push($this->cssClass['alert'], $css);
        if (is_array($data) && array_key_exists('message', $data)) {
            $msg = $data['message'];
        } else {
            $msg = (string)$data;
        }
        if (is_array($data) && array_key_exists('formatter', $data)) {
            $mf = $data['formatter'];
            if (is_callable($mf)) {
                $msg = $mf($msg);
            }
        }
        $this->setValue(new Text($msg))->addClass($this->getClass('alert'))->setAttribute('role', 'alert');
        return $this->render();
    }


}