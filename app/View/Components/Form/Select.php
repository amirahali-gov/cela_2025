<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Select extends Component
{
    public $displayLabel;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public $id, 
        public $label, 
        public $options, 
        public $required = true,
        public $questionNumber = true
    ) {
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
            <div class="row">
                <div class="col-12">
                    <label for="{{$id}}" class="fw-bold">{{$displayLabel}} @if($required) <x-form.required-label /> @endif</label>
                </div>

                <div class="col-md-6 mb-4">
                    <select class="form-control" id="{{$id}}" name="{{$id}}">
                        <option value=""></option>
                        @foreach($options as $option)
                            <option value="{{ $option[1] }}" @if(old($id) == $option[1]) selected @endif>{{ $option[0] }}</option>
                        @endforeach
                    </select>
                    <x-form.input-error-message id="{{$id}}" />
                </div>
            </div>
        </x-form.wrapper>
        blade;
    }
}
