<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Update extends Component
{
    public $column;
    public $url;
    public $title;
    public $datas;
    public $error;
    public $select;
    public $idk;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($column, $url, $title, $data, $select = '',$idk = 'id',  $error = ''){
        $this->idk = $idk;
        $this->column = $column;
        $this->title = $title;
        $this->url = $url;
        $this->datas = $data;
        $this->error = $error;
        $this->select = $select;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render(){
        return view('components.update');
    }
}
