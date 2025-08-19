<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class MultiTextInput extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public $id, public $label, public $count, public $placeholder=null, public $required=true)
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
                <label for="{{$id}}">
                    @if($required) <x-form.required-label /> @endif
                    {{$label}}
                </label>
                @for($i=1; $i<=$count; $i++)
                    <input class="form-control mb-2 col-md-6" type="text" name="{{$id}}[]" id="{{$id}}{{$i}}" placeholder="{{$placeholder}}" value="{{ old($id)[$i-1] ?? '' }}">
                @endfor
                <x-form.input-error-message id="{{$id}}" />
            </x-form.wrapper>
        blade;
    }
}
