<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class NumberInput extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public $id, public $label, public $placeholder=null, public $required=true)
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $this->placeholder = $placeholder ?? $this->label;
        return <<<'blade'
            <x-form.wrapper>
                <label for="{{$id}}">{{$label}}@if($required) <x-form.required-label /> @endif</label>
                <input class="form-control" type="number" name="{{$id}}" id="{{$id}}" placeholder="{{$placeholder}}" value="{{ old($id) }}">
                <x-form.input-error-message id="{{$id}}" />
            </x-form.wrapper>
        blade;
    }
}
