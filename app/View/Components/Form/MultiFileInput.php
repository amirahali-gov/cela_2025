<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class MultiFileInput extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public $id, public $label, public $accept='image/*,.pdf', public $required=true, public $helperText="You may upload more than one file here. Please upload valid images or PDF files. Size of image should not be more than 2MB."){}

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return <<<'blade'
            <x-form.wrapper>
                <label for="{{ $id }}">{{ $label }} @if($required) <x-form.required-label /> @endif</label>
                <input type="file" class="form-control-file" accept="{{ $accept }}" name="{{ $id }}[]" id="{{ $id }}" multiple>
                <small class="d-block form-text text-muted">{{$helperText}}</small>
                <x-form.input-error-message id="{{$id}}" />
            </x-form.wrapper>
        blade;
    }
}


