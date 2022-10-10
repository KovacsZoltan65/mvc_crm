<?php

/**
 * Anchor.php
 * User: kzoltan
 * Date: 2022-06-30
 * Time: 13:20
 */

namespace app\core\form;

/**
 * Description of Anchor
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @package namespace app\core\form
 * @version 1.0
 */
class Anchor
{
    public array $attributes = [];
    
    /**
     * 
     * @param array $attributes
     *              [
     *                  'id'    => '',
     *                  'name'  => '',
     *                  'class' => '',
     *                  'title' => '',
     *                  'href'  => '',
     *                  'icon'  => '',
     *              ]
     */
    public function __construct(array $attributes)
    {    
        $this->attributes = $attributes;
    }
    
    public function __toString()
    {
        $name = ( !isset($this->attributes['name']) || $this->attributes['name'] == '' ) ? $this->attributes['id'] : $this->attributes['name'];
        
        $type = (isset($this->attributes['type'])) ? $this->attributes['type'] : 'button';
        
        $style = ( isset($this->attributes['style']) ) ? 'style="' . $this->attributes['style'] . '"' : '';
        
        $anchor = '<a href="' . $this->attributes['href'] . '" 
                      id="' . $this->attributes['id'] . '"
                      name="' . $name . '"
                      ' . $style . '
                      type="' . $type . '"
                      class="' . $this->attributes['class'] . '">';
        
        $anchor .= (isset($this->attributes['title'])) ? 
            $this->attributes['title'] : 
            '<i class="' . $this->attributes['icon'] . '"></i>';
        
        $anchor .= '</a>';
        
        return $anchor;
    }
}
