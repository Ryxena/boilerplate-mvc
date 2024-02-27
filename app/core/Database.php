<?php
    class Database {
        private $host = DB_HOST;
        private $user = DB_USER;
        private $database = DB_NAME;
        private $dbh;
        private $stmt;

        public function __construct() {
            // $dsn = "mysql:host={$this->host};dbname={$this->database}";
            $option = [
                PDO::ATTR_PERSISTENT => TRUE,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];
            try {
                $this->dbh = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->user, "", $option);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }

        public function query($sql){
            $this->stmt = $this->dbh->prepare($sql);
        }

        public function bind($param, $value, $type = null) {
            if(is_null($type)){
                switch (true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    
                    default:
                        $type = PDO::PARAM_STR;
                        break;
                }
            }
            $this->stmt->bindValue($param, $value, $type);
        }

        public function single(){
            $this->stmt->execute();
            return $this->stmt->fetch(PDO::FETCH_ASSOC);
        }
        public function resultSet(){
            $this->stmt->execute();
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function execute(){
            $this->stmt->execute();
        }
        public function rowcount(){
            return $this->stmt->rowcount();
        }
    }
?>