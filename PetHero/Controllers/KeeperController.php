<?php
    namespace Controllers;
    use \DAO\KeeperDAO as KeeperDAO;
    use \DAO\PersonalDataDAO as PersonalDataDAO;
    use \DAO\LocationDAO as LocationDAO;
    use \Model\Keeper as Keeper;
    use \Model\PersonalData as PersonalData;
    use \Model\Location as Location;
    class KeeperController
    {
        private $keeperDAO;
        private $personalDataDAO;
        private $locationDAO;
        public function __construct(){
            $this->keeperDAO = new KeeperDAO();
            $this->personalDataDAO = new PersonalDataDAO();
            $this->locationDAO = new LocationDAO();
        }

        public function AddPersonalData($name, $surname, $sex, $dni) //$adress, $neighborhood, $city, $province, $country)
        {
            /*$location = new Location();
            $location->__fromRequest($adress, $neighborhood, $city, $province, $country);*/
            $personalData = new PersonalData();
            $personalData-> __fromRequest($name,$surname,$sex,$dni);
            $this->personalDataDAO->Add($personalData);
            var_dump($this->personalDataDAO->Get(7));
        }

        public function AddKeeper()
        {
            $keeper = new Keeper();
            $keeper->
            $this->KeeperDAO->Add($keeper);
        }

    }



?>