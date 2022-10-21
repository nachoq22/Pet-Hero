<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Hero :D</title>
</head>
<body>
    Bienvenido a pet hero, aqui podra buscar a un keeper adecuado para cuidar a su mascota asi como ofrecerse a cuidar otras mascotas!
    <br>
    <a href="Home/ViewRegister">Registrate</a>
    <br>
    <a href="Home/ViewBeKeeper">Be a Keeper!</a>

                        <!--LOCATION-->
    <table style="text-align:center;">
        <thead>
            <tr>
                <th style="width: 15%;">Adress</th>
                <th style="width: 30%;">Neighborhood</th>
                <th style="width: 30%;">City</th>
                <th style="width: 15%;">Province</th>
                <th style="width: 10%;">Country</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($locationList as $location){ ?>
            <tr>
                <td><?php echo $location->getAdress() ?></td>
                    <td><?php echo $location->getNeighborhood() ?></td>
                    <td><?php echo $location->getCity() ?></td>
                    <td><?php echo $location->getProvince() ?></td>
                    <td><?php echo $location->getCountry() ?></td>
            </tr>
        <?php 
        } ?>                          
        </tbody>
    </table>

                    <br><br><br>

                    <!--SIZE-->

    <table style="text-align:center;">
        <thead>
            <tr>
                <th style="width: 15%;">idSize</th>
                <th style="width: 30%;">Name</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($sizeList as $size){ ?>
            <tr>
                <td><?php echo $size->getId() ?></td>
                <td><?php echo $size->getName() ?></td>
            </tr>
        <?php 
        } ?>                          
        </tbody>
    </table>

                        <br><br><br>
                        <!--PET TYPE-->
    <table style="text-align:center;">
        <thead>
            <tr>
                <th style="width: 15%;">idType</th>
                <th style="width: 30%;">Name</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($typeList as $type){ ?>
            <tr>
                <td><?php echo $type->getId() ?></td>
                <td><?php echo $type->getName() ?></td>
            </tr>
        <?php 
        } ?>                          
        </tbody>
    </table>

                        <br><br><br>
                        <!--PET TYPE-->
    <table style="text-align:center;">
        <thead>
            <tr>
                <th style="width: 15%;">IDUser</th>
                <th style="width: 30%;">Username</th>
                <th style="width: 30%;">Email</th>
                <th style="width: 15%;">Password</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($userList as $user){ ?>
            <tr>
                <td><?php echo $user->getId() ?></td>
                <td><?php echo $user->getUsername() ?></td>
                <td><?php echo $user->getEmail() ?></td>
                <td><?php echo $user->getPassword() ?></td>
            </tr>
        <?php 
        } ?>                          
        </tbody>
    </table>
    
</body>
</html>