<style>
    @import url('https://fonts.cdnfonts.com/css/road-rage');

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
    <div class="row">
        <div class="col-md-4 border-right gy-3">
            <div class="d-flex align-items-start">
                <div class="nav flex-column nav-pills me-3 gap-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <!-- Usuario logeado -->
                    <div class="nav-link" style=" background-image: url('https://steamuserimages-a.akamaihd.net/ugc/861731921529769216/A7D4E1E09402ACB8FC318C0437DEF6558D3AA879/?imw=5000&imh=5000&ima=fit&impolicy=Letterbox&imcolor=%23000000&letterbox=false');">
                        <img src="https://images.squarespace-cdn.com/content/v1/5723b737c2ea51b309ec0ca1/1522426438102-68EK89NNSIVWSHHSFT73/Pug_walking.gif?format=500w" alt="Bootstrap" width="32" height="32" class="rounded-circle border border-white me-3">
                        <span class="settings-tray--right">
                            <strong style="color: #CB06BF; font-family: 'Road Rage'; "><?php echo $user->getUsername() ?></strong>
                        </span>
                    </div>
                    <!-- Usuario logeado -->

                    <!-- Lista de contacto -->
                    <?php foreach ($chatList as $chat) { ?>

                        <?php if (strcmp($user->getUsername(), $chat->getOwner()->getUsername()) == 0) { ?>
                            <button class="nav-link" style="
                            
                    background-image: url('https://i.pinimg.com/originals/14/c3/0a/14c30a7dfd597095952ce00ce5ceb328.gif');
                    background-size: 100% 50px; " id="v-pills-<?php echo $chat->getKeeper()->getUsername(); ?>-tab" data-bs-toggle="pill" data-bs-target="#v-pills-<?php echo $chat->getKeeper()->getUsername(); ?>" type="button" role="tab" aria-controls="v-pills-<?php echo $chat->getKeeper()->getUsername(); ?>" aria-selected="false"><img src="https://images.squarespace-cdn.com/content/v1/5723b737c2ea51b309ec0ca1/1522426406915-UYRKL6LRW48TCO2H1MPY/Cat_Mouse_2.gif" alt="Bootstrap" width="32" height="32" class="rounded-circle border border-white me-3">
                                <strong style="color: #2400FF; font-family: 'Road Rage'; "> <?php echo $chat->getKeeper()->getUsername(); ?></strong>
                            </button>
                        <?php
                        } else {
                        ?>
                            <button class="nav-link" style="
                    background-image: url('https://i.pinimg.com/originals/14/c3/0a/14c30a7dfd597095952ce00ce5ceb328.gif');
                    background-size: 100% 50px; " id="v-pills-<?php echo $chat->getOwner()->getUsername(); ?>-tab" data-bs-toggle="pill" data-bs-target="#v-pills-<?php echo $chat->getOwner()->getUsername(); ?>" type="button" role="tab" aria-controls="v-pills-<?php echo $chat->getOwner()->getUsername(); ?>" aria-selected="false"><img src="https://images.squarespace-cdn.com/content/v1/5723b737c2ea51b309ec0ca1/1522426406915-UYRKL6LRW48TCO2H1MPY/Cat_Mouse_2.gif" alt="Bootstrap" width="32" height="32" class="rounded-circle border border-white me-3">
                                <strong style="color: #2400FF; font-family: 'Road Rage'; "> <?php echo $chat->getOwner()->getUsername(); ?></strong>
                            </button>
                        <?php } ?>

                    <?php } ?>
                    <!-- Lista de contacto -->

                </div>
            </div>
        </div>


        <div class="col-md-8">
            <div class="tab-content" id="v-pills-tabContent">



                <!-- A CONTINUACION SE MOSTRARAN TODOS LOS MENSAJES DEL CHAT CORRESPONDIENTE -->

                <?php foreach ($chatList as $chat) {



                    if (strcmp($user->getUsername(), $chat->getOwner()->getUsername()) == 0) { ?> <!-- DEPENDIENDO SI EL USUARIO LOGEADO COINCIDE CON EL OWNER O KEEPER DEL CHAT
                                                                                                    SE UBICARA DE UN LADO O DEL OTRO -->


                    <!-- SI EL USUARIO ES EL OWNER DEL CHAT -->    
                        <div class="tab-pane fade" id="v-pills-<?php echo $chat->getKeeper()->getUsername(); ?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $chat->getKeeper()->getUsername(); ?>-tab" tabindex="0">
                            <div class="card mx-auto">
                                <div class="card-header bg-transparent">
                                    <div class="navbar navbar-expand p-0">
                                        <ul class="navbar-nav me-auto align-items-center">
                                            <li class="nav-item">
                                                <a href="#!" class="nav-link">
                                                    <div class="position-relative" style="width:50px; height: 50px; border-radius: 50%; border: 2px solid #e84118; padding: 2px">
                                                        <img src="https://images.squarespace-cdn.com/content/v1/5723b737c2ea51b309ec0ca1/1522426406915-UYRKL6LRW48TCO2H1MPY/Cat_Mouse_2.gif" class="img-fluid rounded-circle" alt="">
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#!" class="nav-link">
                                                    <span style="font-family: 'Road Rage'" ;>
                                                        <?php echo $chat->getKeeper()->getUsername() ?>
                                                    </span>
                                                </a>
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

                                <div class="card-body p-4" style="height: 500px; overflow: auto; background-image: url('https://cdn.dribbble.com/users/6620596/screenshots/14792345/media/af61fa935b055891cb800a9e41ebb747.gif'); background-position: center;">


                                    <?php foreach ($messageAllList as $msgList) {
                                        foreach ($msgList as $message) {
                                            if (!empty($msgList)) {    ?>
                                                <?php if ($chat->getIdChat() == $message->getChat()->getIdChat()) {  ?>
                                                    <?php if (strcmp($user->getUsername(), $message->getSender()->getUsername()) != 0) { ?>
                                                        <div class="d-flex align-items-baseline mb-4">
                                                            <div class="position-relative avatar">
                                                                <img src="https://images.squarespace-cdn.com/content/v1/5723b737c2ea51b309ec0ca1/1522426406915-UYRKL6LRW48TCO2H1MPY/Cat_Mouse_2.gif" class="img-fluid rounded-circle" alt="">
                                                            </div>
                                                            <div class="pe-2">
                                                                <div>
                                                                    <div class="card card-text d-inline-block p-2 px-3 m-1">
                                                                        <?php echo $message->getMessage(); ?>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="small">
                                                                        <strong style="color: #D6DBDF; ">
                                                                            <?php echo $message->getDateTime(); ?>
                                                                        </strong>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>

                                                        <div class="d-flex align-items-baseline text-end justify-content-end mb-4">
                                                            <div class="pe-2">
                                                                <div>
                                                                    <div class="card card-text d-inline-block p-2 px-3 m-1">
                                                                        <?php echo $message->getMessage(); ?>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="small">
                                                                        <strong style="color: #D6DBDF; ">
                                                                            <?php echo $message->getDateTime(); ?>
                                                                        </strong>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="position-relative avatar">
                                                                <img src="https://images.squarespace-cdn.com/content/v1/5723b737c2ea51b309ec0ca1/1522426438102-68EK89NNSIVWSHHSFT73/Pug_walking.gif?format=500w" class="img-fluid rounded-circle" alt="">
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </div>

                                <div class="card-footer bg-white position-absolute w-100 bottom-0 m-0 p-1">
                                    <div class="input-group">
                                        <form action="<?php echo FRONT_ROOT . "/Chat/AddMessage" ?>">
                                            <input type="text" class="form-control border-0" name="message" placeholder="Write a message..." required>
                                            <input type="hidden" name="idChat" value="<?php echo $chat->getIdChat() ?>">
                                            <input type="hidden" name="previewValue" value="chatP">
                                            <div class="input-group-text bg-transparent border-0">
                                                <button type="submit" class="btn btn-light text-secondary">
                                                    <i class="bi bi-send-fill"></i>
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>

                            </div>


                        </div>

                    <?php } else { ?>

                        <!-- SI EL USUARIO ES EL KEEPER DEL CHAT -->  
                        <div class="tab-pane fade" id="v-pills-<?php echo $chat->getOwner()->getUsername() ?>" role="tabpanel" aria-labelledby="v-pills-<?php echo $chat->getOwner()->getUsername(); ?>-tab" tabindex="0">


                            <div class="card mx-auto">

                                <div class="card-header bg-transparent">
                                    <div class="navbar navbar-expand p-0">
                                        <ul class="navbar-nav me-auto align-items-center">
                                            <li class="nav-item">
                                                <a href="#!" class="nav-link">
                                                    <div class="position-relative" style="width:50px; height: 50px; border-radius: 50%; border: 2px solid #e84118; padding: 2px">
                                                        <img src="https://images.squarespace-cdn.com/content/v1/5723b737c2ea51b309ec0ca1/1522426406915-UYRKL6LRW48TCO2H1MPY/Cat_Mouse_2.gif" class="img-fluid rounded-circle" alt="">
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#!" class="nav-link">
                                                    <span style="font-family: 'Road Rage'" ;>
                                                        <?php echo $chat->getOwner()->getUsername() ?>
                                                    </span>
                                                </a>
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

                                <div class="card-body p-4" style="height: 500px; overflow: auto; background-image: url('https://cdn.dribbble.com/users/6620596/screenshots/14792345/media/af61fa935b055891cb800a9e41ebb747.gif'); background-position: center;">
                                    <?php
                                    foreach ($messageAllList as $msgList) {
                                        foreach ($msgList as $message) {
                                            if (!empty($msgList)) { ?>
                                                <?php if ($chat->getIdChat() == $message->getChat()->getIdChat()) {  ?>
                                                    <?php if (strcmp($user->getUsername(), $message->getSender()->getUsername()) != 0) { ?>
                                                        <div class="d-flex align-items-baseline mb-4">
                                                            <div class="position-relative avatar">
                                                                <img src="https://images.squarespace-cdn.com/content/v1/5723b737c2ea51b309ec0ca1/1522426406915-UYRKL6LRW48TCO2H1MPY/Cat_Mouse_2.gif" class="img-fluid rounded-circle" alt="">
                                                            </div>
                                                            <div class="pe-2">
                                                                <div>
                                                                    <div class="card card-text d-inline-block p-2 px-3 m-1">
                                                                        <?php echo $message->getMessage(); ?>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="small"><strong style="color: #D6DBDF; "><?php echo $message->getDateTime(); ?></strong></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="d-flex align-items-baseline text-end justify-content-end mb-4">
                                                            <div class="pe-2">
                                                                <div>
                                                                    <div class="card card-text d-inline-block p-2 px-3 m-1"><?php echo $message->getMessage(); ?></div>
                                                                </div>
                                                                <div>
                                                                    <div class="small"><strong style="color: #D6DBDF; "><?php echo $message->getDateTime(); ?></strong></div>
                                                                </div>
                                                            </div>
                                                            <div class="position-relative avatar">
                                                                <img src="https://images.squarespace-cdn.com/content/v1/5723b737c2ea51b309ec0ca1/1522426438102-68EK89NNSIVWSHHSFT73/Pug_walking.gif?format=500w" class="img-fluid rounded-circle" alt="">
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </div>

                                <!-- FORMULARIO PARA ENVIAR UN MENSAJE -->
                                <div class="card-footer bg-white position-absolute w-100 bottom-0 m-0 p-1">
                                    <div class="input-group">
                                        <form action="<?php echo FRONT_ROOT . "/Chat/AddMessage" ?>">
                                            <input type="text" class="form-control border-0" name="message" placeholder="Write a message..." required>
                                            <input type="hidden" name="idChat" value="<?php echo $chat->getIdChat() ?>">
                                            <input type="hidden" name="previewValue" value="chatP">
                                            <div class="input-group-text bg-transparent border-0">
                                                <button type="submit" class="btn btn-light text-secondary">
                                                    <i class="bi bi-send-fill"></i>
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php } ?>
                <?php } ?>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
</body>