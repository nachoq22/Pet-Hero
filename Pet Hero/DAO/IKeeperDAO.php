<?php
    namespace DAO;

    use Models\Keeper as Keeper;

    interface IKeeperDAO
    {
        function Add(Keeper $Keeper);
        function GetAll();
        function GetById($id);
        function Remove($id);
    }

?>