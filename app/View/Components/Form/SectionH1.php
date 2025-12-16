<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class SectionH1 extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return <<<'blade'
            <h1 class="text-center mt-4">{{ $slot }}</h1>
            <hr><br><br>
        <style>
            h1.text-center.mt-4 {
                font-size: 2rem;
                color: #3f3f3fff;
            }
        </style>
        blade;
    }
}
