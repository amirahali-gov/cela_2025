<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class FileInput extends Component
{
    public $displayLabel;

    public function __construct(
        public $id,
        public $label,
        public $accept = 'image/*,.pdf',
        public $required = true,
        public $helperText = 'Please upload a valid image or PDF file. The image size should not exceed 2MB.',
        public $questionNumber = true
    ) {
        $this->displayLabel = QuestionNumbering::formatLabel($this->label, $this->questionNumber);
    }

    public function render()
    {
        return <<<'blade'
<x-form.wrapper>
    <div class="row">
        <div class="col-12">
            <label for="{{$id}}" class="fw-bold">
                @if($required) <x-form.required-label /> @endif
                {!! $displayLabel !!}
            </label>
        </div>

        <div class="mb-4">
            <div class="input-group mb-3">
                <input type="file" class="form-control" accept="{{ $accept }}" name="{{ $id }}" id="{{ $id }}">
            </div>

            {{-- Preview uploaded files --}}
            <div id="{{ $id }}-preview">
                @php
                    $uploaded = session("uploadedFiles.{$id}") ?? null;
                    $files = [];

                    if ($uploaded) {
                        if (isset($uploaded['path'])) {
                            $files[] = $uploaded; // single file
                        } elseif (is_array($uploaded)) {
                            $files = $uploaded; // multi file array
                        }
                    }

                    $isSingle = true; // set to false if using a multi-file component
                @endphp

                @foreach($files as $file)
                    <p>Uploaded: <a href="{{ asset('storage/' . $file['path']) }}" target="_blank">{{ $file['name'] }}</a></p>
                @endforeach
            </div>

            <small class="d-block form-text text-muted">{{ $helperText }}</small>
            <x-form.input-error-message id="{{ $id }}" />
        </div>
    </div>
</x-form.wrapper>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('{{ $id }}');
    const preview = document.getElementById('{{ $id }}-preview');

    input.addEventListener('change', function () {
        preview.innerHTML = ''; // Clear previous previews

        @if($isSingle)
            if (input.files.length > 0) {
                const file = input.files[0];
                const p = document.createElement('p');
                const link = document.createElement('a');
                link.href = URL.createObjectURL(file);
                link.target = '_blank';
                link.textContent = file.name;
                p.textContent = 'Uploaded: ';
                p.appendChild(link);
                preview.appendChild(p);
            }
        @else
            for (let i = 0; i < input.files.length; i++) {
                const file = input.files[i];
                const p = document.createElement('p');
                const link = document.createElement('a');
                link.href = URL.createObjectURL(file);
                link.target = '_blank';
                link.textContent = file.name;
                p.textContent = 'Uploaded: ';
                p.appendChild(link);
                preview.appendChild(p);
            }
        @endif
    });
});
</script>
blade;
    }
}
