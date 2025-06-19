<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public $breadcrumb = [];

    public function initBreadcrumb()
    {
        $this->breadcrumb[] = [];
    }
}
