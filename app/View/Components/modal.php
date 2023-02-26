<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $target;
    public $type;
    public $title;
    public $body;
    public $buttonMessage;
    
    public function __construct($target, $type, $title, $body, $buttonMessage)
    {
        $this->target = $target;
        $this->type = $type;
        $this->title = $title;
        $this->body = $body;
        $this->buttonMessage = $buttonMessage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
