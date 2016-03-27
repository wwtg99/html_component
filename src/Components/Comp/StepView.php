<?php
/**
 * Created by PhpStorm.
 * User: wwt
 * Date: 2016/3/27 0027
 * Time: 下午 6:26
 */

namespace Components\Comp;


use Components\Common\StyleElement;
use HtmlObject\Element;
use HtmlObject\Text;

class StepView extends StyleElement
{

    /**
     * @var array
     */
    private $steps = [];

    /**
     * @var int
     */
    private $current;

    /**
     * StepView constructor.
     * @param array $steps: [['title'=>'', 'descr'=>''], ...], field descr is optional
     * @param int $current
     */
    public function __construct(array $steps, $current = 0)
    {
        parent::__construct('div');
        $this->steps = $steps;
        $this->current = $current;
        $this->cssClass = ['step_div' => 'ui ordered steps', 'step' => 'step', 'content'=>'content', 'title' =>'title', 'descr' =>'descr', 'current' => 'active', 'completed'=>'completed'];
        $this->styles = [
            'step_div'=>['margin'=>'15px 0 0 0'],
            'step'=>['float'=>'left', 'width'=>'278px', 'height'=>'80px', 'margin'=>'10px 5px 10px 5px', 'padding'=>'10px', 'border'=>'solid 1px rgba(34, 36, 38, 0.15)', 'border-radius'=>'0.28rem'],
            'content'=>['display'=>'block'],
            'title'=>['font-weight'=>'700', 'font-size'=>'1.14em'],
            'descr'=>['font-weight'=>'400'],
            'current'=>['background'=>'#F3F4F5'],
            'completed'=>['color'=>'rgba(40, 40, 40, 0.3)']
        ];
    }

    /**
     * Render element view with data.
     *
     * @param $data
     * @return string
     */
    public function view($data)
    {
        if (array_key_exists('current', $data)) {
            $this->current = $data['current'];
        }
        if (array_key_exists('title_formatter', $data)) {
            $tf = $data['title_formatter'];
        }
        if (array_key_exists('descr_formatter', $data)) {
            $df = $data['descr_formatter'];
        }
        $i = 1;
        foreach ($this->steps as $step) {
            $sdiv = new Element('div');
            $sstyle = $this->getStyle('step');
            if ($i == $this->current) {
                $sdiv->addClass($this->getClass('current'));
                $sstyle .= $this->getStyle('current');
            } elseif ($i < $this->current) {
                $sdiv->addClass($this->getClass('completed'));
                $sstyle .= $this->getStyle('completed');
            }
            $sdiv->addClass($this->getClass('step'))->setAttribute('style', $sstyle);
            $title = array_key_exists('title', $step) ? $step['title'] : '';
            $descr = array_key_exists('descr', $step) ? $step['descr'] : '';
            if (isset($tf) && is_callable($tf)) {
                $title = $tf($title);
            }
            if (isset($df) && is_callable($df)) {
                $descr = $df($descr);
            }
            $contdiv = new Element('div');
            $contdiv->addClass($this->getClass('content'))->setAttribute('style', $this->getStyle('content'));
            $tdiv = new Element('div', new Text($title));
            $tdiv->addClass($this->getClass('title'))->setAttribute('style', $this->getStyle('title'));
            $ddiv = new Element('div', new Text($descr));
            $ddiv->addClass($this->getClass('descr'))->setAttribute('style', $this->getStyle('descr'));
            $contdiv->appendChild($tdiv)->appendChild($ddiv);
            $sdiv->appendChild($contdiv);
            $this->appendChild($sdiv);
            $i++;
        }
        return $this->render();
    }


}