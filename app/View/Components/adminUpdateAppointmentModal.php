<?php

namespace App\View\Components;

use Illuminate\View\Component;

class adminUpdateAppointmentModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $modalTitle = '';
    public function __construct($title)
    {
        $this->modalTitle = $title;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.update-modal');
    }
}
