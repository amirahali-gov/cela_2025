<x-form.wrapper>
    <div x-data="multiFileManager('{{ $id }}', {{ session()->has('uploadedFiles') && isset(session('uploadedFiles')[$id]) ? 'true' : 'false' }})">
        <div class="row">
            <div class="col-12">
                <label for="{{ $id }}" class="fw-bold">
                    {{ $displayLabel }}
                    @if($required) <x-form.required-label /> @endif
                </label>
            </div>

            <div class="col-12 mb-4">
                <input type="file"
                       class="form-control"
                       name="{{ $id }}[]"
                       id="{{ $id }}"
                       multiple
                       accept="{{ $accept }}"
                       @change="previewFiles">
                <small class="d-block form-text text-muted">{{ $helperText }}</small>
                <x-form.input-error-message id="{{ $id }}" />
            </div>

            {{-- Combined files list --}}
            <ul class="list-group mt-2">
                <template x-for="file in allFiles" :key="file.name">
                    <li class="list-group-item d-flex justify-content-between align-items-center" 
                        x-show="!deletedFiles.includes(file.name)">
                        <div class="d-flex align-items-center">
                            <img :src="file.icon" class="me-2" width="24" height="24">

                            <!-- Show link if file.url exists -->
                            <template x-if="file.url">
                                <a x-text="file.name" :href="file.url" target="_blank"></a>
                            </template>
                            <template x-if="!file.url">
                                <span x-text="file.name"></span>
                            </template>

                        </div>
                        <button type="button" class="btn btn-outline-danger btn-sm fw-bold"
                                @click="removeFile(file)">✕</button>
                    </li>
                </template>
            </ul>
        </div>
    </div>
</x-form.wrapper>

<script>
function multiFileManager(inputId, hasSessionFiles = false) {
    return {
        newFiles: [],

        sessionFiles: hasSessionFiles
            ? Object.values(@json(session('uploadedFiles')[$id] ?? []))
                .map(f => ({
                    ...f,
                    name: f.name,
                    url: f.path ? `/storage/${f.path}` : '',
                    icon: (function(filepath) {
                        const ext = filepath.split('.').pop().toLowerCase();
                        switch(ext){
                            case 'pdf': return "{{ asset('images/pdf.png') }}";
                            case 'doc': case 'docx': return "{{ asset('images/doc.png') }}";
                            case 'xls': case 'xlsx': return "{{ asset('images/xls.png') }}";
                            case 'ppt': case 'pptx': return "{{ asset('images/ppt.png') }}";
                            case 'jpg': case 'jpeg': case 'png': case 'gif': return "{{ asset('images/photo.png') }}";
                            default: return "{{ asset('images/file.png') }}";
                        }
                    })(f.path || f.name)
                }))
            : [],

        deletedFiles: [],

        get allFiles() {
            return [
                ...this.sessionFiles,
                ...this.newFiles.map(f => ({
                    name: f.name,
                    file: f,
                    url: URL.createObjectURL(f), // Temporary browser preview for new files
                    icon: this.fileIcon(f)
                }))
            ];
        },

        previewFiles(event) {
            this.newFiles = [...this.newFiles, ...Array.from(event.target.files)];

            let dt = new DataTransfer();
            this.newFiles.forEach(f => dt.items.add(f));
            document.getElementById(inputId).files = dt.files;
        },

        removeFile(file) {
            if (file.file) {
                // Remove new file
                this.newFiles = this.newFiles.filter(f => f !== file.file);
                let dt = new DataTransfer();
                this.newFiles.forEach(f => dt.items.add(f));
                document.getElementById(inputId).files = dt.files;
            } else {
                // Remove session file
                this.removeUploadedFile(file.name, true);
            }
        },

        async removeUploadedFile(filename, isSessionFile = false) {
            if (!isSessionFile) return;

            try {
                let response = await fetch(`/session-files/${inputId}/${filename}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                });

                if (response.ok) {
                    this.deletedFiles.push(filename);
                    this.sessionFiles = this.sessionFiles.filter(f => f.name !== filename);
                } else {
                    alert('Failed to delete session file.');
                }
            } catch (e) {
                console.error(e);
                alert('Failed to delete session file.');
            }
        },

        fileIcon(file) {
            const ext = file.name.split('.').pop().toLowerCase();
            switch(ext){
                case 'pdf': return "{{ asset('images/pdf.png') }}";
                case 'doc': case 'docx': return "{{ asset('images/doc.png') }}";
                case 'xls': case 'xlsx': return "{{ asset('images/xls.png') }}";
                case 'ppt': case 'pptx': return "{{ asset('images/ppt.png') }}";
                case 'jpg': case 'jpeg': case 'png': case 'gif': return "{{ asset('images/photo.png') }}";
                default: return "{{ asset('images/file.png') }}";
            }
        }
    }
}
</script>
