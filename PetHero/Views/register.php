<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logear</title>
</head>
<body>
        <form action="<?php echo FRONT_ROOT."/Home/Register" ?>" method="post">
        User
        <input type="text" name="userName" >
        Contraseña
        <input type="password" name="password">
        <br>
        <button type="submit">Enviar</button>
        <br>
        <button type="reset">Reset</button>
        </form> 
</body>
</html>