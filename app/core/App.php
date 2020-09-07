<?php
class App
{
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();
        // cek ada atau tidak file didalam controllers yang mempunyai nama yang sesuai dengan yang kita inputkan di URL
        if (file_exists('../app/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            // di unset karena sudah dijadikan sebuah controller yaitu Home
            unset($url[0]);
        }
        require_once '../app/controllers/' . $this->controller . '.php';
        // intansiasi supaya bisa memanggil methodnya
        $this->controller = new $this->controller;

        // method, kalau tidak diisi akan tetap menjalankan menthod defaultnya
        if (isset($url[1])) {
            // cek ada gak method di dalam controller yang dituju
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // parameternya
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        // jalankan controller & method, serta kirimkan params 
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/'); // rtrim untuk menghilangkan tanda slash diakhir alamat URL karena kita menginginkan string aja
            // Filter untuk membersihkan URL dari karakter-karakter yang ngaco
            $url = filter_var($url, FILTER_SANITIZE_URL);
            // URL nya kita pecah berdasarkan tanda slash nya menggunakan explode
            $url = explode('/', $url);

            return $url;
        }
    }
}
