<?php

namespace App\View\Components;

use Illuminate\View\Component;

class deleteConfirmationModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $modalTitle = '';
    public $modalDesc = '';
    public $modalAction = '';
    public function __construct($deletetitle, $deletedesc, $deleteformaction = '')
    {
        $this->modalTitle = $deletetitle;
        $this->modalDesc = $deletedesc;
        $this->modalAction = $deleteformaction;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.delete-confirmation');
    }
}
