<?php


namespace crystlbrd\FormMonkey\Input;


use crystlbrd\FormMonkey\Input;

class StringInput extends Input
{
    /**
     * Generates the HTML
     * @return string
     */
    public function render(): string
    {
        $html = '<input type="text" name="' . $this->Name . '"';
        $html .= '>';

        return $html;
    }
}