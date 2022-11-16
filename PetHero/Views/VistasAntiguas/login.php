<head>
    <title>Logear</title>
</head>
<body>
        <form action="<?php echo FRONT_ROOT."/Home/Login" ?>" method="post">
        User
        <input type="text" name="userName" >
        <br>
        Contraseña
        <input type="password" name="password">
        <br>
        <input type="submit" class="btn" value="Ingresar" style="background-color:#DC8E47;color:white;"/>
        <br>
        <button type="reset">Reset</button>
        
        </form> 
</body>
