<?php
    namespace DAO;

    use Models\Location as Location;

    interface ILocationDAO
    {
        function Add(Location $Location);
        function GetAll();
        function GetById($id);
        function Remove($id);
    }

?>