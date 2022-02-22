<?php

namespace App\View\Components;

use Illuminate\View\Component;

class confirmationModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $modalTitle = '';
    public $modalDesc = '';

    public function __construct($title, $desc)
    {
        $this->modalTitle = $title;
        $this->modalDesc = $desc;


    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.confirmation-modal');
    }
}
