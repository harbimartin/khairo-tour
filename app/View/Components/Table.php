<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Table extends Component
{
    public $column;
    public $datas;
    public $datef;
    public $import;
    public $idk;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($column, $datas, $datef = false, $import = false, $idk = 'id'){
        $this->column = $column;
        $this->datas = $datas;
        $this->datef = $datef;
        $this->import = $import;
        $this->idk = $idk;
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
