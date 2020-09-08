<?php
class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $db_name = DB_NAME;

    // untuk koneksinya
    private $dbh;
    private $stmt;

    public function __construct()
    {
        // data source name
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name;

        // option ketika kita ingin mengoptimasi koneksi ke database kita
        $option = [
            // untuk menjaga koneksi terus de DB
            PDO::ATTR_PERSISTENT => true,
            // apabila ada error koneksi
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $option);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    // kita butuh function untuk menjalankan query
    // apakah usernya ingin SELECT, INSERT, DELETE
    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    // binding datanya, sapa tau didalam datanya ada warenya, istilahnya adalah parameternya
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        // agar  terhindar dari SQL Injection, karena query dieksekusi setelah stringnya dibersihin dahulu

        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        $this->stmt->execute();
    }
    // setelah ditampilkan kalian ingin banyak datanya atau satu aja, contoh: SELECT ALL MAHASISWA
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // kalau datanya hanya satu
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}
