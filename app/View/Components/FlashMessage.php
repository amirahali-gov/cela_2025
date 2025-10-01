<?php

namespace App\View\Components;

use Illuminate\View\Component;

/**
 * FlashMessage Component
 * 
 * Displays flash messages stored in the session as Bootstrap alerts.
 * Supports success, error, warning, info, general messages, and submission errors.
 * All alerts are dismissible and use Bootstrap styling.
 * 
 * Usage: <x-flash-message />
 * 
 * You can flash messages by using the session()->flash() method in your controller.
 * Available types: success, error, warning, info, message, submissionError
 * 
 * Example:
 * $request->session()->flash('success', 'Application submitted successfully!');
 * 
 */
class FlashMessage extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Render the flash message component view.
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('components.flash-message');
    }
} 