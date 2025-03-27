<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class FileInput extends Component
{
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
        public $helperText = 'Please upload a valid image or PDF file. Size of image should not be more than 2MB.'
    ) {
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
                <div class="row">

                <div class="col-12">
                    <label for="{{$id}}" class="fw-bold">{{$label}} @if($required) <x-form.required-label /> @endif</label>
                </div>

                <div class="col-md-6 mb-4">
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" accept="{{ $accept }}" name="{{ $id }}" id="{{ $id }}">
                        </div>
                        <small class="d-block form-text text-muted">{{ $helperText }}</small>
                        <x-form.input-error-message id="{{ $id }}" />
                    </div>
                </div>
            </x-form.wrapper>
        blade;
    }
}
