<?php

namespace App\Widgets;

class CopyrightWidget extends Widget
{
    public function run($options = []): array
    {
        $vars = [];

        $vars['year'] = date('Y');

        return $vars;
    }
}