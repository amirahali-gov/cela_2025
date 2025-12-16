<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class TextInput extends Component
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
        public $placeholder = null,
        public $type = "text",
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
        $placeholder = $this->placeholder ?? $this->label;
        
        return <<<'blade'
            <x-form.wrapper>
                <div class="row align-items-center">
                    <!-- Label taking 12 columns -->
                    <div class="col-12">
                        <label for="{{$id}}" class="fw-bold">
                            @if($required) <x-form.required-label /> @endif
                            {!! $displayLabel !!}
                        </label>
                    </div>
                    <!-- Input field taking 6 columns -->
                    <div class="mb-4">
                        <input class="form-control" type="{{$type}}" name="{{$id}}" id="{{$id}}" placeholder="{{$placeholder}}" value="{{ old($id) }}">
                        <x-form.input-error-message id="{{$id}}" />
                    </div>
                </div>
            </x-form.wrapper>
        blade;
    }
}
