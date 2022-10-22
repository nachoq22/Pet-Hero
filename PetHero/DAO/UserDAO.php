<?php
    namespace DAO;

    use \DAO\Connection as Connection;
    use \DAO\QueryType as QueryType;

    use \DAO\IUserDAO as IUserDAO;
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

                $user->__fromDB($row["idUser"],$row["username"]
                ,$row["password"],$row["email"]
                ,$this->dataDao->Get($row["idData"]));

                 array_push($dataList,$user);
            }
            return $dataList;
        }

        public function Get($id){
            $user = null;

            $query = "CALL User_GetById(?)";
            $parameters["idUser"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $user = new User();

                $user->__fromDB($row["idUser"],$row["username"],$row["password"],$row["email"]
                ,$this->dataDao->Get($row["idData"]));
            }
            return $user;
        }

        public function GetbyKeeper($id){
            $user = null;

            $query = "CALL User_GetById(?)";
            $parameters["idUser"] = $id;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $user = new User();

                $user->__fromDBbyKeeper($row["idUser"],$row["username"],$row["password"],$row["email"]
                ,$this->dataDao->Get($row["idData"]));
            }
            return $user;
        }

        public function GetByUsername($username){
            $user = null;

            $query = "CALL User_GetByUsername(?)";
            $parameters["username"] = $username;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $user = new User();

                $user->__fromDB($row["idUser"],$row["username"],$row["password"],$row["email"]
                ,$this->dataDao->Get($row["idData"]));
            }
            return $user;
        }

        public function GetByUsernameByKeeper($username){
            $user = null;

            $query = "CALL User_GetByUsername(?)";
            $parameters["username"] = $username;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $user = new User();

                $user->__fromDBbyKeeper($row["idUser"],$row["username"],$row["password"],$row["email"]
                ,$this->dataDao->Get($row["idData"]));
            }
            return $user;
        }

        public function Login(User $user){
            $rta = 0;
            $query = "CALL User_Login(?,?,?)";
            $parameters["username"] = $user->getUsername();
            $parameters["password"] = $user->getPassword();
            $parameters["rta"] = $rta;
            $this->connection = Connection::GetInstance();
            $resultBD = $this->connection->Execute($query,$parameters,QueryType::StoredProcedure);

            foreach($resultBD as $row){
                $rta = $row["@rta"];
            }
        return $rta;
        }

        public function Add(User $user){
            $query = "CALL PersonalData_Add(?,?,?,?,?)";
            $parameters["username"] = $user->getUsername();
            $parameters["password"] = $user->getPassword();
            $parameters["email"] = $user->getEmail();
            $parameters["idData"] = $user->getData()->getId();
            /*$idLocation = $this->dataDao->Add($user->getData());*/

            /*$parameters["idLocation"] = $idLocatrion; */
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }

        public function Register(User $user){
            $query = "CALL User_Register(?,?,?)";
            $parameters["username"] = $user->getUsername();
            $parameters["password"] = $user->getPassword();
            $parameters["email"] = $user->getEmail();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query,$parameters,QueryType::StoredProcedure);
        }
            
        public function Delete($id){
            $query = "CALL User_Delete(?)";
            $parameters["idUser"] = $id;

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);
        }
    }
?>