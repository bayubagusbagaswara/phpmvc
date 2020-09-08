<?php

class Mahasiswa_model
{

    private $table = 'mahasiswa';
    private $db;

    // saat dipanggil construct langsung konek ke class database nya
    public function __construct()
    {
        $this->db = new Database;
    }

    // buat method untuk mengambil datanya
    public function getAllMahasiswa()
    {
        $this->db->query('SELECT * FROM ' . $this->table);
        return $this->db->resultSet();
    }
}
