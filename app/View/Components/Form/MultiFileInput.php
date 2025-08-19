<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class MultiFileInput extends Component
{
    public $id;
    public $label;
    public $accept;
    public $required;
    public $helperText;
    public $displayLabel;

    public function __construct(
        $id,
        $label,
        $accept = 'image/*,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx',
        $required = true,
        $helperText = 'Please upload valid files. Maximum 2MB per file.',
        $questionNumber = true
    ) {
        $this->id = $id;
        $this->label = $label;
        $this->accept = $accept;
        $this->required = $required;
        $this->helperText = $helperText;

        $this->displayLabel = QuestionNumbering::formatLabel($label, $questionNumber);
    }

    public function render()
    {
        return view('components.form.multi-file-input', [
            'id' => $this->id,
            'displayLabel' => $this->displayLabel,
            'accept' => $this->accept,
            'required' => $this->required,
            'helperText' => $this->helperText,
        ]);
    }
}
