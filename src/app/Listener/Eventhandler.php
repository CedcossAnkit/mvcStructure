<?php

namespace App\Listener;

use Phalcon\Di\Injectable;

class Eventhandler extends Injectable
{

    public function helloEvent($abc)
    {
        die("hii event");
    }
}
