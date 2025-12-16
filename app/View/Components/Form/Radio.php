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
    public $questionNumber;
    public $displayLabel;

    public function __construct($id, $label, $options, $required=true, $questionNumber=true)
    {
        $this->id = $id;
        $this->label = $label;
        $this->options = $options;
        $this->required = $required;
        $this->questionNumber = $questionNumber;
        $this->displayLabel = QuestionNumbering::formatLabel($this->label, $this->questionNumber);
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
                    <label for="{{$id}}" class="fw-bold">
                        @if($required) <x-form.required-label /> @endif
                        {!! $displayLabel !!}
                    </label>
                </div>

                <div class="mb-4">
                    <div class="form-check" id="{{$id}}">
                        @foreach($options as $option)
                        <input class="fw-bold form-check-input" type="radio" name="{{$id}}" x-model="{{$id}}" value="{{$option[1]}}" @if(old($id) == $option[1]) checked @endif>
                        <label id="radio-label" class="mr-1" for="{{$id}}">{{$option[0]}}</label>
                        <br>
                        @endforeach
                    </div>
                    <x-form.input-error-message id="{{$id}}" />
                </div>
            </div>
        </x-form.wrapper>
        <style>
        .form-check-input[type=radio] {
            // border-radius: 50%;
            border-color: black;
        }
        </style>
        blade;
    }
}
