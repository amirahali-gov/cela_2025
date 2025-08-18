<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class QuestionNumbering extends Component
{
    private static $questionCounter = 0;
    private static $resetOnNextCall = false;

    /**
     * Reset the question counter to start from 1
     */
    public static function reset()
    {
        self::$resetOnNextCall = true;
    }

    /**
     * Get the next question number
     */
    public static function getNext()
    {
        if (self::$resetOnNextCall) {
            self::$questionCounter = 0;
            self::$resetOnNextCall = false;
        }
        
        return ++self::$questionCounter;
    }

    /**
     * Get the current question number without incrementing
     */
    public static function getCurrent()
    {
        return self::$questionCounter;
    }

    /**
     * Format a label with question number
     */
    public static function formatLabel($label, $includeNumber = true)
    {
        if (!$includeNumber) {
            return $label;
        }
        
        $number = self::getNext();
        return "{$number}. {$label}";
    }

    public function render()
    {
        return '';
    }
} 