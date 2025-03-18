<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Column2 extends Component
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
            <x-form.wrapper>
                <div class="row">
                    <div class="col-md-6">
                        {{ $col1 }}
                    </div>
                    <div class="col-md-6">
                        {{ $col2 }}
                    </div>
                </div>
            </x-form.wrapper>
        blade;
    }
}
