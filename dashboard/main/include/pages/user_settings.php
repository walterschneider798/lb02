<!DOCTYPE html>
<html>

<head>
    <?php include_once('../../style/head.html'); ?>
</head>

<body>
    <?php include_once('../navbar.php'); ?>
    <p class="my-4"> amigo </p>
    <div class="d-flex row" id="wrapper">
        

        <!-- Page Content -->

        <div class="col-sm-12 col-lg-9 col-md-12">
            <div class="container-fluid mt-5 pt-2 w-75">
              

                <div class="container">
                <a onclick="openindex()" class="btn btn-success"><i class="fas fa-home"></i> home</a>

                    <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-4 mt-5">
                            <h5 class="mb-3">change credentials</h5>

                            <form>
                                <div class="form-group">
                                    <label class="my-1 col-form-label">firstname:</label>
                                    <input type="text" placeholder="new firstname" class="form-control" id="changefirstname">
                                </div>
                                <div class="form-group">
                                    <label class=" my-1 col-form-label">lastname:</label>
                                    <input type="text" placeholder="new lastname" class="form-control" id="changelastname">
                                </div>
                            </form>


                            <div id="changeusermessage">

                            </div>

                            <button type="button" class="mt-3 btn btn-outline-warning" onclick="changenamecheck(
                        document.getElementById('changefirstname').value.trim(),
                        document.getElementById('changelastname').value.trim()
                        )">change</button>

                        </div>
                        <div class=" col-sm-0 col-md-0 col-lg-4">
                            <!-- placeholder -->
                        </div>
                       
                        <div class="col-sm-12 col-md-6 col-lg-4 my-5">
                            <h5 class="mb-3">Delete your account</h5>

                            <form>
                                <div class="form-group">
                                    <label class="my-1 col-form-label">E-Mail:</label>
                                    <input type="text" placeholder="E-Mail address" class="form-control" id="email">
                                </div>
                                <div class="form-group">
                                    <label class="my-1 col-form-label">Password:</label>
                                    <input type="password" placeholder="password" class="form-control" id="password">
                                </div>
                            </form>

                            <div id="deletemessage">

                            </div>

                            <button type="button" class="mt-3 btn btn-outline-danger" onclick="deleteuser(
                                    document.getElementById('email').value.trim(),
                                    document.getElementById('password').value.trim()
                                    )">Delete Account</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /#page-content-wrapper -->
    </div>
    <script src="/lb_02/resources/js/user.js"></script>
</body>

</html>