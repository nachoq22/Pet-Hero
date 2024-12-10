<style>
    a.nav-link {
        color: gray;
        font-size: 18px;
        padding: 0;
    }

    .avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 2px solid #e84118;
        padding: 2px;
        flex: none;
    }

    input:focus {
        outline: 0px !important;
        box-shadow: none !important;
    }

    .card-text {
        border: 2px solid #ddd;
        border-radius: 8px;
    }
</style>

<body>
<?php if (isset($_COOKIE['message'])) { 
            if(strpos($_COOKIE['message'],"Error") !== false) { ?>
                <div class="alert alert-danger alert-dismissible fade show " role="alert">
    <?php    }else{ ?>
                <div class="alert alert-success alert-dismissible fade show " role="alert">    
                    <?php } echo $_COOKIE['message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>    
                </div>
<?php } setcookie('message', '', time() - 3600,'/'); ?>



    <div class="container mt-4">
        <div class="card mx-auto" style="max-width:400px">

            <div class="card-header bg-transparent">
                <div class="navbar navbar-expand p-0">

                    <ul class="navbar-nav me-auto align-items-center">
                        <li class="nav-item">
                            <a href="#!" class="nav-link">
                                <div class="position-relative"
                                    style="width:50px; height: 50px; border-radius: 50%; border: 2px solid #e84118; padding: 2px">
                                    <img src="https://images.squarespace-cdn.com/content/v1/5723b737c2ea51b309ec0ca1/1522426406915-UYRKL6LRW48TCO2H1MPY/Cat_Mouse_2.gif"
                                        class="img-fluid rounded-circle" alt="">
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#!" class="nav-link"><?php echo $chat->getKeeper()->getUsername(); ?></a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a href="#!" class="nav-link">
                                <i class="bi bi-box-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="card-body p-4" style="height: 500px; overflow: auto;">


            <!-- POR CADA MENSAJE EN LA LISTA DARA UNA VUELTA AL FOREACH -->
                <?php if(! empty($messageList)){
                foreach($messageList as $message){ 
                    if($chat->getKeeper()->getId()==$message->getSender()->getId()){ ?> <!-- ESTE IF CORROBORA SI EL QUE ENVIA EL MENSAJE ES EL OWNER O EL KEEPER -->
                    <div class="d-flex align-items-baseline mb-4">
                    <div class="position-relative avatar">
                        <img src="https://images.squarespace-cdn.com/content/v1/5723b737c2ea51b309ec0ca1/1522426406915-UYRKL6LRW48TCO2H1MPY/Cat_Mouse_2.gif"
                            class="img-fluid rounded-circle" alt="">
                    </div>
                    <div class="pe-2">
                        <div>
                            <div class="card card-text d-inline-block p-2 px-3 m-1">
                                <?php echo $message->getMessage() ?>
                            </div>
                        </div>
                        <div>
                            <div class="small"><?php echo $message->getDateTime() ?></div>
                        </div>
                    </div>
                </div>
                <?php }else{?>    <!-- DEPENDIENDO SI ENTRA EN EL IF O EL ELSE, EL MENSAJE SE MOSTRARÁ DEL LADO IZQUIERDO O DERECHO -->
                <div class="d-flex align-items-baseline text-end justify-content-end mb-4">
                <div class="pe-2">
                    <div>
                        <div class="card card-text d-inline-block p-2 px-3 m-1"><?php echo $message->getMessage() ?></div>
                    </div>
                    <div>
                        <div class="small"><?php echo $message->getDateTime() ?></div>
                    </div>
                </div>
                <div class="position-relative avatar">
                    <img src="https://images.squarespace-cdn.com/content/v1/5723b737c2ea51b309ec0ca1/1522426438102-68EK89NNSIVWSHHSFT73/Pug_walking.gif?format=500w"
                        class="img-fluid rounded-circle" alt="">
                    <span
                        class="position-absolute bottom-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
                    </span>
                </div>
            </div>
            <?php } ?>
            <?php }} ?>
            </div>

            <!-- FORMULARIO PARA MANDAR UN NUEVO MENSAJE -->
            <div class="card-footer bg-white position-absolute w-100 bottom-0 m-0 p-1">
                <div class="input-group">
                    <form action="<?php echo FRONT_ROOT."/Chat/AddMessage"?>">
                <input type="text" class="form-control border-0" name="message" placeholder="Write a message..." required>
                <input type="hidden" name="idChat" value="<?php echo $chat->getIdChat()?>">
                <input type="hidden" name="previewValue" value="chatV">
                <div class="input-group-text bg-transparent border-0">
                        <button type="submit" class="btn btn-light text-secondary">
                        <i class="bi bi-send-fill"></i>
                        </button>
                    </div>
            </form>        
            </div>
            </div>
            <!-- FORMULARIO PARA MANDAR UN NUEVO MENSAJE -->

        </div>
    </div>
</body>