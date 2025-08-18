<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class UrlList extends Component
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
                <div class="col-md-6 mb-3">
                    <label for="{{$id}}" class="fw-bold">{{$displayLabel}} @if($required) <x-form.required-label /> @endif</label>

                    <!-- Add URL button on the left and input on the right -->
                    <div class="input-group">
                        <!-- Styled Add URL button similar to file input -->
                        <button type="button" class="btn btn-outline-secondary text-dark border-1" id="add-url"
                            style="transition: background-color 0.3s ease;">
                            Add URL
                        </button>
                        <input type="text" class="form-control" id="new-url" placeholder="Add a URL" />
                    </div>

                    <!-- Display the added URLs as a list -->
                    <ul class="list-group mt-3" id="url-list">
                        <!-- List of added URLs will go here -->
                    </ul>

                    <!-- Hidden field to store URLs -->
                    <input type="hidden" name="{{$id}}" id="url-field" value="{{ old($id) }}">

                    <x-form.input-error-message id="{{$id}}" />
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const addButton = document.getElementById('add-url');
                    const urlInput = document.getElementById('new-url');
                    const urlList = document.getElementById('url-list');
                    const urlField = document.getElementById('url-field');

                    let urls = [];

                    // Load existing URLs from old input
                    if (urlField.value) {
                        urls = JSON.parse(urlField.value);
                        displayUrls();
                    }

                    addButton.addEventListener('click', function() {
                        const url = urlInput.value.trim();
                        if (url && isValidURL(url)) {
                            urls.push(url);
                            urlInput.value = '';
                            displayUrls();
                            updateHiddenField();
                        } else {
                            alert('Please enter a valid URL.');
                        }
                    });

                    urlInput.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            addButton.click();
                        }
                    });

                    function displayUrls() {
                        urlList.innerHTML = '';
                        urls.forEach((url, index) => {
                            const listItem = document.createElement('li');
                            listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
                            listItem.innerHTML = `
                                <a href="${url}" target="_blank" class="text-decoration-none">${url}</a>
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeUrl(${index})">Remove</button>
                            `;
                            urlList.appendChild(listItem);
                        });
                    }

                    function updateHiddenField() {
                        urlField.value = JSON.stringify(urls);
                    }

                    function isValidURL(string) {
                        try {
                            new URL(string);
                            return true;
                        } catch (_) {
                            return false;
                        }
                    }

                    // Make removeUrl globally accessible
                    window.removeUrl = function(index) {
                        urls.splice(index, 1);
                        displayUrls();
                        updateHiddenField();
                    };
                });
            </script>
        </x-form.wrapper>
        blade;
    }
}
