<?php

namespace App\Listener\Entity;

class PostListener
{
    public function preUpdate()
    {
        dump('Listener preUpdate (from Entity)');
    }

}
