<?php
    namespace DAO;

    use \Connection\Connection as Connection;
    use \Connection\QueryType as QueryType;

    use \Inter\IUserDAO as IUserDAO;
    use \Model\User as User;
    use \DAO\PersonalDataDAO as PersonalDataDAO;
    use \Model\PersonalData as PersonalData;

    class UserDao implements IUserDAO{

        private $connection;
        private $tableName = 'User';

        private $dataDao;

        public function __construct(){
            $this->dataDao = new PersonalDataDAO();
        }


        public function GetAll(){
            $userList = array();

            $query = "CALL User_GetAll()";
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,array(),QueryType::StoredProcedure);
            
            foreach($resultBD as $row){
                $user = new User();

                $user->__fromDB($row["id"],$row["username"]
                ,$row["password"],$row["email"]
                ,$this->dataDao->Get($row["idData"]));

                 array_push($dataList,$user);
            }
            return $dataList;
        }

        public function Get($id){
            $user = null;

            $query = "CALL User_GetById(?)";
            $parameters["id"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $user = new User();

                $user->__fromDB($row["id"],$row["username"],$row["password"],$row["email"]
                ,$this->dataDao->Get($row["idData"]));
            }
            return $user;
        }

        public function Add(User $user){
            $query = "CALL PersonalData_Add(?,?,?,?,?)";
            $parameters["username"] = $user->getUsername();
            $parameters["password"] = $user->getPassword();
            $parameters["email"] = $user->getEmail();
            
            /*$idLocation = $this->dataDao->Add($user->getData());*/

            /*$parameters["idLocation"] = $idLocatrion; */

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }
            
        public function Delete($id){
            $query = "CALL Location_Delete(?)";
            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>