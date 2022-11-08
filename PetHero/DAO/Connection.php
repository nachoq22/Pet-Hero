<?php
namespace DAO;
use \PDO as PDO;
use \DAO\QueryType as QueryType;
use \Exception as Exception;

    class Connection{
        private $pdo = null;
        private $pdoStatement = null;
        private static $instance = null;

        private function __construct() {
            try{
                $this->pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASS);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(Exception $e){
                throw $e;
            }
        }

        public static function GetInstance(){
            if(self::$instance == null){
                self::$instance = new Connection();
            }
            return self::$instance;
        }

        
        private function Prepare($query){
            try{
                $this->pdoStatement = $this->pdo->prepare($query);
            }catch(Exception $e){
                throw $e;
            }
        }

        private function BindParameters($parameters = array(), $queryTipe = QueryType::Query){
            $i = 0;
            foreach($parameters as $parameterName => $value){
                $i++;
                if($queryTipe == QueryType::Query){
                    $this->pdoStatement->bindParam(":",$parameterName,$parameters[$parameterName]);
                }else{ 
                    $this->pdoStatement->bindParam($i,$parameters[$parameterName]);
                }
            }
        }

        public function Execute($query, $parameters = array(), $queryType = QueryType::Query){
            try{
                $this->Prepare($query);

                $this->BindParameters($parameters, $queryType);

                $this->pdoStatement->execute();

                return $this->pdoStatement->fetchAll();
            }catch(Exception $e){
                throw $e;
            }
        }
        
        public function ExecuteNonQuery($query, $parameters = array(), $queryType = QueryType::Query){            
            try{
                $this->Prepare($query);
                
                $this->BindParameters($parameters, $queryType);

                $this->pdoStatement->execute();

                return $this->pdoStatement->fetchColumn();
            }
            catch(Exception $e){
                throw $e;
            }        	    	
        }

        public function ExecuteLastId($query, $parameters = array(), $queryType = QueryType::Query){            
            try{
                $this->Prepare($query);
                
                $this->BindParameters($parameters, $queryType);

                $this->pdoStatement->execute();

                return $this->pdo->lastInsertId();
            }catch(Exception $ex){
                throw $ex;
            }        	    	
        }
    }
?>