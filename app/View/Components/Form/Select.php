<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class Select extends Component
{
    public $displayLabel;
    
    // New property for Alpine binding
    public $xModel;

    public function __construct(
        public $id, 
        public $label, 
        public $options, 
        public $required = true,
        public $questionNumber = true,
        $xModel = null  // optional Alpine binding
    ) {
        $this->displayLabel = QuestionNumbering::formatLabel($this->label, $this->questionNumber);
        $this->xModel = $xModel;
    }

    public function render()
    {
        return <<<blade
        <x-form.wrapper>
            <div class="row">
                <div class="col-12">
                    <label for="{{ \$id }}" class="fw-bold">{{ \$displayLabel }} @if(\$required) <x-form.required-label /> @endif</label>
                </div>

                <div class="col-md-8 mb-4 position-relative">
                    <select 
                        class="form-control pr-4" 
                        id="{{ \$id }}" 
                        name="{{ \$id }}"
                        @if(\$xModel) x-model="{{ \$xModel }}" @endif
                    >
                        <option value=""></option>
                        @foreach(\$options as \$option)
                            <option value="{{ \$option[1] }}" @if(old(\$id) == \$option[1]) selected @endif>{{ \$option[0] }}</option>
                        @endforeach
                    </select>

                    <!-- Chevron arrow -->
                    <span class="position-absolute" style="right:1.75rem; top:50%; transform:translateY(-50%); pointer-events:none; color:#555;">
                        &#9662;
                    </span>

                    <x-form.input-error-message id="{{ \$id }}" />
                </div>
            </div>
        </x-form.wrapper>
        blade;
    }
}
