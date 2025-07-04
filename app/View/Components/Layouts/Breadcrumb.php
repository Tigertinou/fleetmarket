<?php

namespace App\View\Components\Layouts;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public array $breadcrumb;
    /**
     * Create a new component instance.
     */
    public function __construct(array $breadcrumb = [])
    {
        $this->breadcrumb = $breadcrumb;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layouts.breadcrumb');
    }
}
