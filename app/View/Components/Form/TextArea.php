<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class TextArea extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public $id, public $label, public $placeholder=null, public $type="text", public $required=true, public $rows=5)
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $placeholder = $placeholder ?? $this->label;
        return <<<'blade'
            <x-form.wrapper>
                <label for="{{$id}}">{{$label}} @if($required) <x-form.required-label /> @endif</label>
                <textarea class="form-control" type="{{$type}}" name="{{$id}}" id="{{$id}}" placeholder="{{$placeholder}}" value="{{ old($id) }}" rows={{$rows}}>{{ old($id) }}</textarea>
                <x-form.input-error-message id="{{$id}}" />
            </x-form.wrapper>
        blade;
    }
}
