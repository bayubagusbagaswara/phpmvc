<?php

class Home extends Controller
{
    // methode defaultnya
    public function index()
    {
        // tampilkan view yang disipan di folder views
        $data['judul'] = 'Home';
        $data['nama'] = $this->model('User_model')->getUser();
        $this->view('templates/header', $data);
        $this->view('home/index', $data);
        $this->view('templates/footer');
    }
}
