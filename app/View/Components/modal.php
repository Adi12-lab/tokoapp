<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $target;
    public $title;
    public $body;
    public $buttonHtml;
    public $submitText;
    public $type;
    public $action;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct( $target, $type, $buttonHtml, $title, $body, $submitText, $action)
    {
        $this->target = $target;
        $this->type = $type;
        $this->buttonHtml = $buttonHtml;
        $this->title = $title;
        $this->body = $body;
        $this->submitText = $submitText;
        $this->action = $action;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
