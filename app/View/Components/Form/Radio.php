<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Radio extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $id;
    public $label;
    public $options;
    public $required;

    public function __construct($id, $label, $options, $required=true)
    {
        $this->id = $id;
        $this->label = $label;
        $this->options = $options;
        $this->required = $required;
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

            <div class= "row">
                <div class="col-12">
                    <label for="{{$id}}" class="fw-bold">{{$label}} @if($required) <x-form.required-label /> @endif</label>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="form-check">
                        @foreach($options as $option)
                        <input class="fw-bold form-check-input" type="radio" name="{{$id}}" id="{{$id}}"x-model="{{$id}}" value="{{$option[1]}}" @if(old($id) == $option[1]) checked @endif>
                        <label class="form-check-label mr-1" for="{{$id}}">{{$option[0]}}</label>
                        <br>
                        @endforeach
                    </div>
                    <x-form.input-error-message id="{{$id}}" />
                </div>
            </div>
        </x-form.wrapper>
        <style>
        .form-check-input[type=radio] {
            border-radius: 50%;
            border-color: black;
        }
        </style>
        blade;
    }
}
