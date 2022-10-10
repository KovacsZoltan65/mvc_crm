<?php

/**
 * Button.php
 * User: kzoltan
 * Date: 2022-06-29
 * Time: 18:45
 */

namespace app\core\form;

/**
 * Description of Button
 * Class Button
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core\form
 * @version 1.0
 */
class Button
{
    const TYPE_BUTTON = 'button',
        TYPE_SUBMIT = 'submit',
        TYPE_RESET = 'reset',
        TYPE_MODAL = 'modal';
    public $type = self::TYPE_BUTTON;
    
    public array $attributes = [];
    /**
     * 
     * @param array $attributes
     *              [
     *                  'id'      => '',
     *                  'name'    => '',
     *                  'class'   => '',
     *                  'title'   => '',
     *                  'onclick' => ''
     *              ]
     */
    public function __construct(array $attributes)
    {
        $this->type = self::TYPE_BUTTON;
        $this->attributes = $attributes;
    }
    
    public function button()
    {
        $this->type = self::TYPE_BUTTON;
        return $this;
    }
    
    public function submit()
    {
        $this->type = self::TYPE_SUBMIT;
        return $this;
    }
    
    public function reset()
    {
        $this->type = self::TYPE_RESET;
        return $this;
    }
    
    public function modal()
    {
        $this->type = self::TYPE_MODAL;
        return $this;
    }
    
    public function __toString()
    {
        $name = ( !isset($this->attributes['name']) || $this->attributes['name'] == '' ) 
            ? $this->attributes['id'] 
            : $this->attributes['name'];
        $onclick = ( !isset($this->attribute['onclick']) || $this->attribute['onclick'] == '' ) 
            ? '' 
            : $this->attribute['onclick'];
        
        $title = (isset($this->attributes['title'])) ? 
            $this->attributes['title'] : 
            '<i class="' . $this->attributes['icon'] . '"></i>';
        
        $style = ( isset($this->attributes['style']) ) ? ' style="' . $this->attributes['style'] . '"' : '';
        
        $data_dismiss = ( isset($this->attributes['data-dismiss']) ) ? ' data-dismiss="' . $this->attributes['data-dismiss'] . '"' : '';
        
        $data_id = ( isset($this->attributes['data-id']) ) ? $this->attributes['data-id'] : 0;
        
        $button = '';
        switch ($this->type) {
            case self::TYPE_MODAL:
                $data_whatever = ( isset($this->attributes['data-whatever']) ) ? $this->attributes['data-whatever'] : '';
                $button = '<button id="' . $this->attributes['id'] . '" 
                                   name="' . $name . '" 
                                   type="' . $this->type . '" 
                                   class="' . $this->attributes['class'] . '" 
                                   ' . $style . '
                                   data-toggle="' . $this->attributes['data-toggle'] . '" 
                                   data-target="' . $this->attributes['data-target'] . '" 
                                   data-whatever="' . $data_whatever . '"
                                   data-id="' . $data_id . '">
                        ' . $title . '
                    </button>';
                break;
            case self::TYPE_BUTTON:
            case self::TYPE_RESET:
            case self::TYPE_SUBMIT:
                $button = '<button type="' . $this->type . '" 
                                   id="' . $this->attributes['id'] . '" 
                                   name="' . $name . '" 
                                   class="' . $this->attributes['class'] . '" 
                                   ' . $style . '
                                   onclick="' . $onclick . '"' 
                    . $data_dismiss . '>' . $title;
                $button .= '</button>';
                break;
            default:
                break;
        }
        
        return $button;
        
    }
}
