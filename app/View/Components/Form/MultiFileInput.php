<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class MultiFileInput extends Component
{
    public $displayLabel;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public $id,
        public $label,
        public $accept = 'image/*,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx',
        public $required = true,
        public $helperText = 'Please upload valid files. Maximum 2MB per file.',
        public $questionNumber = true
    ) {
        $this->displayLabel = QuestionNumbering::formatLabel($this->label, $this->questionNumber);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return <<<blade
<x-form.wrapper>
    <div x-data="multiFileManager('{$this->id}')">
        <div class="row">
            <div class="col-12">
                <label for="{$this->id}" class="fw-bold">{$this->displayLabel} @if(\$required) <x-form.required-label /> @endif</label>
            </div>

            <div class="col-12 mb-4">
                <input type="file" class="form-control" name="{$this->id}[]" id="{$this->id}" multiple accept="{$this->accept}" @change="previewFiles">
                <small class="d-block form-text text-muted">{$this->helperText}</small>
                <x-form.input-error-message id="{$this->id}" />
            </div>

            <!-- Previously uploaded files -->
            @if(session("uploadedFiles.{$this->id}"))
                <ul class="list-group mb-2">
                    @foreach(session("uploadedFiles.{$this->id}") as \$uploadedFile)
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            x-show="!deletedFiles.includes('{{ basename(\$uploadedFile) }}')">
                            <div class="d-flex align-items-center">
                                <img :src="prevFileIcon('{{ \$uploadedFile }}')" class="me-2" width="24" height="24" />
                                <a href="{{ asset('storage/' . \$uploadedFile) }}" target="_blank">{{ basename(\$uploadedFile) }}</a>
                            </div>
                            <button type="button" class="btn btn-sm btn-danger" @click="removeUploadedFile('{{ basename(\$uploadedFile) }}')">✕</button>
                        </li>
                    @endforeach
                </ul>
            @endif

            <!-- New files preview -->
            <ul class="list-group mt-2">
                <template x-for="(file, index) in newFiles" :key="index">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img :src="fileIcon(file)" class="me-2" width="24" height="24">
                            <span x-text="file.name"></span>
                        </div>
                        <button type="button" class="btn btn-outline-danger btn-sm" @click="removeNewFile(index)">✕</button>
                    </li>
                </template>
            </ul>
        </div>
    </div>
</x-form.wrapper>

<script>
function multiFileManager(inputId) {
    return {
        newFiles: [],
        deletedFiles: [],

        previewFiles(event) {
            this.newFiles = [...this.newFiles, ...Array.from(event.target.files)];
            let dt = new DataTransfer();
            this.newFiles.forEach(f => dt.items.add(f));
            document.getElementById(inputId).files = dt.files;
        },

        removeNewFile(index) {
            this.newFiles.splice(index, 1);
            let dt = new DataTransfer();
            this.newFiles.forEach(f => dt.items.add(f));
            document.getElementById(inputId).files = dt.files;
        },

        async removeUploadedFile(filename) {
            try {
                let response = await fetch(`/files/\${inputId}/\${filename}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                });
                if (response.ok) {
                    this.deletedFiles.push(filename);
                } else {
                    alert('Failed to delete file.');
                }
            } catch (e) {
                console.error(e);
            }
        },

        fileIcon(file) {
            const ext = file.name.split('.').pop().toLowerCase();
            switch(ext) {
                case 'pdf': return '/images/pdf.png';
                case 'doc': case 'docx': return '/images/doc.png';
                case 'xls': case 'xlsx': return '/images/xls.png';
                case 'ppt': case 'pptx': return '/images/ppt.png';
                case 'jpg': case 'jpeg': case 'png': case 'gif': return '/images/photo.png';
                default: return '/images/file.png';
            }
        },

        prevFileIcon(filepath) {
            const ext = filepath.split('.').pop().toLowerCase();
            switch(ext) {
                case 'pdf': return '/images/pdf.png';
                case 'doc': case 'docx': return '/images/doc.png';
                case 'xls': case 'xlsx': return '/images/xls.png';
                case 'ppt': case 'pptx': return '/images/ppt.png';
                case 'jpg': case 'jpeg': case 'png': case 'gif': return '/images/photo.png';
                default: return '/images/file.png';
            }
        }
    }
}
</script>
blade;
    }
}
