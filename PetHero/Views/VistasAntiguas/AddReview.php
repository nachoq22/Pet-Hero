<body>
<form action="<?php echo FRONT_ROOT."/Booking/EnterPaycode" ?>" method="post" name="sendPayC">
                                <div class="form-floating mb-3">
                                    <input type="hidden" name="idPublic" value=<?php echo $public->getId() ?>>                                                                         <div class="form-floating mb-3">
                        <textarea class="form-control" id="review" placeholder="Come mucho" name="review" onkeypress="if (event.keyCode == 13) Send()" required>></textarea>
                        <label for="review">review</label>
                            <div class="invalid-feedback">
                                Enter any observation, special care or details.
                            </div>
                    </div>
                </div>
</form>
<script>function Send(){document.sendPayC.submit()}</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>