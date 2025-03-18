<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class InputErrorMessage extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public $id)
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
            @error($id)
                <script>
                    element = document.getElementById("{{$id}}");
                    element.classList.add("is-invalid");
                </script>
                <div class="invalid-feedback d-block">
                    {{$errors->first($id)}}
                </div>
            @enderror
        blade;
    }
}
