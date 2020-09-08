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

    public function getMahasiswaById($id)
    {
        // untuk menyimpan data yang akan dibinding, jadi id nya tidak langsung dimasukkin ke $id untuk menghindari SQL Injection
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id=:id');
        // id nya baru dimasukkin
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function tambahDataMahasiswa($data)
    {
        $query  = "INSERT INTO mahasiswa
        VALUES 
        ('', :nama, :nrp, :email, :jurusan)";
        $this->db->query($query);
        $this->db->bind('nama', $data['nama']);
        $this->db->bind('nrp', $data['nrp']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('jurusan', $data['jurusan']);

        // tinggal di eksekusi
        $this->db->execute();

        return $this->db->rowCount();
    }
    public function hapusDataMahasiswa($id)
    {
        $query = "DELETE FROM mahasiswa WHERE id =:id";
        $this->db->query($query);
        $this->db->bind('id', $id);
        $this->db->execute();
        return $this->db->rowCount();
    }
}
