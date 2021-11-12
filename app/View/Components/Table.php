<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Table extends Component
{
    public $column;
    public $datas;
    public $datef;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($column, $datas, $datef = false){
        $this->column = $column;
        $this->datas = $datas;
        $this->datef = $datef;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render(){
        return view('components.table');
    }
}
