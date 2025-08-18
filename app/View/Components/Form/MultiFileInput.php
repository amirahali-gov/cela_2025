<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class MultiFileInput extends Component
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
        public $accept = 'image/*,.pdf', 
        public $required = true, 
        public $helperText = "You may upload more than one file here. Please upload valid images or PDF files. Size of image should not be more than 2MB.",
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
                    <label for="{{$id}}" class="form-label fw-bold">{{$displayLabel}} @if($required) <x-form.required-label /> @endif</label>
                </div>

                <div class="col-md-6">
                    <input type="file" class="form-control" accept="{{$accept}}" name="{{$id}}[]" id="{{$id}}" multiple>
                    <small class="d-block form-text text-muted">{{$helperText}}</small>
                </div>
            </div>
            <x-form.input-error-message id="{{$id}}" />
        </x-form.wrapper>
        blade;
    }
}
