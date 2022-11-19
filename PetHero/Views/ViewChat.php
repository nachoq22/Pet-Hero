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
    <div class="container mt-4">
        <div class="card mx-auto" style="max-width:400px">

            <div class="card-header bg-transparent">
                <div class="navbar navbar-expand p-0">

                    <ul class="navbar-nav me-auto align-items-center">
                        <li class="nav-item">
                            <a href="#!" class="nav-link">
                                <div class="position-relative"
                                    style="width:50px; height: 50px; border-radius: 50%; border: 2px solid #e84118; padding: 2px">
                                    <img src="https://nextbootstrap.netlify.app/assets/images/profiles/1.jpg"
                                        class="img-fluid rounded-circle" alt="">
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#!" class="nav-link">Nelh</a>
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

                <div class="d-flex align-items-baseline mb-4">
                    <div class="position-relative avatar">
                        <img src="https://nextbootstrap.netlify.app/assets/images/profiles/1.jpg"
                            class="img-fluid rounded-circle" alt="">
                    </div>
                    <div class="pe-2">
                        <div>
                            <div class="card card-text d-inline-block p-2 px-3 m-1">
                                Hi helh, are you available to chat?
                            </div>
                        </div>
                        <div>
                            <div class="small">01:10PM</div>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-baseline text-end justify-content-end mb-4">
                    <div class="pe-2">
                        <div>
                            <div class="card card-text d-inline-block p-2 px-3 m-1">Sure</div>
                        </div>
                        <div>
                            <div class="small">01:13PM</div>
                        </div>
                    </div>
                    <div class="position-relative avatar">
                        <img src="https://nextbootstrap.netlify.app/assets/images/profiles/2.jpg"
                            class="img-fluid rounded-circle" alt="">
                        <span
                            class="position-absolute bottom-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
                            <span class="visually-hidden">New alerts</span>
                        </span>
                    </div>
                </div>

            </div>
            <div class="card-footer bg-white position-absolute w-100 bottom-0 m-0 p-1">
                <div class="input-group">
                    <input type="text" class="form-control border-0" placeholder="Write a message...">
                    <div class="input-group-text bg-transparent border-0">
                        <button class="btn btn-light text-secondary">
                        <i class="bi bi-send-fill"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>