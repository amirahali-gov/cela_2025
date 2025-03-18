<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Select extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public $id, public $label, public $options, public $required=true)
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
            <label for="{{$id}}">{{$label}}@if($required) <x-form.required-label /> @endif</label>
            <select class="form-control" id="{{$id}}" name="{{$id}}">
                <option value=""></option>
                @foreach($options as $option)
                    <option value="{{ $option[1] }}" @if(old($id) == $option[1]) selected @endif>{{ $option[0] }}</option>
                @endforeach
            </select>
            <x-form.input-error-message id="{{$id}}" />
        </x-form.wrapper>
        blade;
    }
}
