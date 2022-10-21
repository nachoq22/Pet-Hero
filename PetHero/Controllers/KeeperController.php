<?php
    namespace Controllers;
    use \DAO\KeeperDAO as KeeperDAO;
    use \DAO\PersonalDataDAO as PersonalDataDAO;
    use \Model\Keeper as Keeper;
    use \Model\PersonalData as PersonalData;

    class KeeperController
    {
        private $KeeperDAO;
        private $PersonalDataDAO;

        public function __construct(){
            $this->KeeperDAO = new KeeperDAO;
            $this->PersonalDataDAO = new PersonalDataDAO;
        }

        public function AddPersonalData($name, $surname, $sex, $dni, $adress, $neighborhood, $city, $province, $country)
        {
            $location = new Location();
            $location->__fromRequest($adress, $neighborhood, $city, $province, $country);
            
            $personalData = new PersonalData();
            $personalData-> __fromDB($idData,$name,$surname,$sex,$dni,$location);

    
        }

    }



?>