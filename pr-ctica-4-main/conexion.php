<?php
    class Conexion extends PDO{
        private $tipo = 'mysqld';
        private $host = "localhost";
        private $nombredb = 'id18705996_dbtenis';
        private $usuario = 'id18705996_dbtenisuser';
        private $contra = "HCz-e!V2\/yCRu";
        
        public function __construct(){
            try {
                parent::__construct("{$this->tipo}:dbname={$this->nombredb};host={$this->host};charset=utf8",$this->usuario,$this->contra);
            } catch (PDOException $e) {
                echo 'Existe un error: '.$e->getMessage();
            }
        }
    }
 ?>