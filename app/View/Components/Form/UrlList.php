<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class UrlList extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public $id, public $label, public $required = true)
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
        <x-form.wrapper>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="{{$id}}" class="fw-bold">{{$label}} @if($required) <x-form.required-label /> @endif</label>

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
        </x-form.wrapper>

        <script>
            // Validate and add URL to the list
            document.getElementById('add-url').addEventListener('click', function() {
                var urlInput = document.getElementById('new-url');
                var urlValue = urlInput.value.trim();

                // Simple URL validation
                var regex = /^(https?:\/\/)?([\w\d\.-]+)\.([a-z]{2,6})(\/[\w\d\.-]*)*\/?$/i;
                if (urlValue && regex.test(urlValue)) {
                    // Create a new list item with the URL
                    var listItem = document.createElement('li');
                    listItem.classList.add('list-group-item');

                    // Create an anchor tag inside the list item
                    var link = document.createElement('a');
                    link.href = urlValue;
                    link.target = '_blank';
                    link.rel = 'noopener noreferrer';
                    link.textContent = urlValue;

                    listItem.appendChild(link);
                    document.getElementById('url-list').appendChild(listItem);

                    // Add the URL to the hidden input field (as JSON)
                    var urlField = document.getElementById('url-field');
                    var urls = urlField.value ? JSON.parse(urlField.value) : [];
                    urls.push(urlValue);
                    urlField.value = JSON.stringify(urls);

                    // Clear the input field after adding the URL
                    urlInput.value = '';
                } else {
                    alert('Please enter a valid URL');
                }
            });
        </script>

        <style>
            /* Ensure the button matches the input field border and hover effects */
            #add-url {
                background-color: #f8f9fa !important; /* Match the input's border color */
                border-color: #dee2e6;
                border-width: 1px;
                transition: background-color 0.3s ease;
            }

            #add-url:hover {
                background-color: #f8f9fa !important; /* Match the file input hover effect */
            }
        </style>
        blade;
    }
}
