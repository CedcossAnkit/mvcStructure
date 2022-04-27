<?php

namespace App\Components;

use Phalcon\Escaper;

class Helper
{

    public function hello()
    {
        return "hello world";
    }

    public function Escaper($data)
    {
        $escaper = new Escaper();
        $escaperData = $escaper->escapeHtml($data);
        return $escaperData;
    }
}
