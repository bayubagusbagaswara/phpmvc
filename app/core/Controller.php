<?php

class Controller
{
    // bikin method view dan sapa tau ada data yg akan dikirimkan 
    public function view($view, $data = [])
    {
        require_once '../app/views/' . $view . '.php';
    }

    public function model($model)
    {
        require_once '../app/models/' . $model . '.php';
        return new $model; // intansiasi 
    }
}
