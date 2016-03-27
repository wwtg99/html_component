<?php
/**
 * Created by PhpStorm.
 * User: wwt
 * Date: 2016/3/27 0027
 * Time: 下午 4:53
 */

namespace Components\Comp;


use Components\Common\StyleElement;
use HtmlObject\Element;
use HtmlObject\Text;

class ListView extends StyleElement
{

    /**
     * @var int
     */
    private $columns;

    /**
     * @var string
     */
    private $align;

    /**
     * ListView constructor.
     * @param int $columns
     * @param string $align
     */
    public function __construct($columns = 1, $align = 'left')
    {
        parent::__construct('div');
        $this->columns = $columns;
        $this->align = $align;
        $this->cssClass = ['list_div' => 'list_div', 'list_item' => 'list_item', 'list_label' =>'list_label', 'list_text' =>'list_text'];
        $this->styles = [
            'list_div' => ['width' => '100%'],
            'list_item' => ['display' => 'inline-block', 'padding' => '5px'],
            'list_label' => ['font-weight' => 'bold', 'width' => '50%', 'display' => 'inline-block'],
            'list_text' => ['width' => '50%', 'display' => 'inline-block']
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
        //align
        switch ($this->align) {
            case 'center': $a = ['text-align'=>'center']; break;
            case 'right': $a = ['text-align'=>'right']; break;
            case 'left':
            default: $a = ['text-align'=>'left'];
        }
        $this->styles['list_div'] = array_merge($this->styles['list_div'], $a);
        //width
        $wid = floor(100 / $this->columns) - 1;
        //data and formatter
        $this->styles['list_item'] = array_merge($this->styles['list_item'], ['width'=>"$wid%"]);
        if (array_key_exists('data', $data)) {
            $d = $data['data'];
        } else {
            $d = $data;
        }
        if (array_key_exists('label_formatter', $data)) {
            $lf = $data['label_formatter'];
        }
        if (array_key_exists('text_formatter', $data)) {
            $tf = $data['text_formatter'];
        }
        foreach ($d as $k => $v) {
            $ltext = $k;
            if(isset($lf) && is_callable($lf)) {
                $ltext = $lf($k);
            }
            $label = new Element('label', new Text($ltext));
            $label->addClass($this->getClass('list_label'))->setAttribute('style', $this->getStyle('list_label'));
            $ttext = $v;
            if(isset($tf) && is_callable($tf)) {
                $ttext = $tf($v);
            }
            $text = new Element('span', new Text($ttext));
            $text->addClass($this->getClass('list_text'))->setAttribute('style', $this->getStyle('list_text'));
            $item = new Element('div');
            $item->addClass('list_item')->setAttribute('style', $this->getStyle('list_item'));
            $item->appendChild($label)->appendChild($text);
            $this->appendChild($item);
            $this->addClass('list_div')->setAttribute('style', $this->getStyle('list_div'));
        }
        return $this->render();
    }


}