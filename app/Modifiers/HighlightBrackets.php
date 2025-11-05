<?php

namespace App\Modifiers;

use Statamic\Modifiers\Modifier;

class HighlightBrackets extends Modifier
{
    public function index($value)
    {
        // Replace [text] with <span class="line">text</span>
        $value = preg_replace_callback('/\[([^\]]+)\]/', function ($matches) {
            return '<span class="line svg-wrap"><span>' . $matches[1] . '</span></span>';
        }, $value);

        // Replace (text) with <span class="circled">text</span>
        $value = preg_replace_callback('/\(([^\)]+)\)/', function ($matches) {
            return '<span class="circled svg-wrap"><span>' . $matches[1] . '</span></span>';
        }, $value);

        return $value;
    }
}
