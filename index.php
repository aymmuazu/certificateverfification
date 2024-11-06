<?php include ('header.php'); ?>
    <title>Certificate Verification System</title>
    <header class="bg-dark py-5">
        <div class="container px-5">
            <div class="row gx-5 align-items-center justify-content-center">
                <div class="col-lg-8 col-xl-7 col-xxl-6">
                    <div class="my-5 text-center text-xl-start">
                        
                        <h1 class="display-5 fw-bolder text-white mb-2">Certificate Verification System</h1>
                        <p class="lead fw-normal text-white-50 mb-4 fw-bold">(A Case Study of FUD)</p>
                        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                            <?php
                                if (loggedin()) {
                            ?>
                                <a class="btn btn-primary w-100 btn-lg px-4 me-sm-3" href="home.php">Go to Dashboard</a> 
                            <?php
                                }else{
                            ?>
                                <a class="btn btn-primary w-100 btn-lg px-4 me-sm-3" href="login.php">User</a> 
                                <a class="btn btn-primary w-100 btn-lg px-4 me-sm-3" href="login.php">Admin</a> 
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center"><img class="img-fluid rounded-3 my-5" src="img/certification.jpeg" alt="..." /></div>
            </div>
        </div>
    </header>
  
    
    <!-- Blog preview section-->
    <section class="py-5">
        <div class="container px-5 my-5"> 
            <!-- Call to action-->
            <aside class="bg-primary bg-gradient rounded-3 p-4 p-sm-5 mt-5">
                <div class="d-flex align-items-center justify-content-between flex-column flex-xl-row text-center text-xl-start">
                    <div class="mb-4 mb-xl-0">
                        <div class="fs-3 fw-bold text-white">Subscribed to our Channels for more updates.</div>
                        <div class="text-white-50">Sign up for our newsletter for the latest updates.</div>
                    </div>
                    <div class="ms-xl-4">
                        <div class="input-group mb-2">
                            <input class="form-control" type="text" placeholder="Email address..." aria-label="Email address..." aria-describedby="button-newsletter" />
                            <button class="btn btn-outline-light" id="button-newsletter" type="button">Sign up</button>
                        </div>
                        <div class="small text-white-50">We care about privacy, and will never share your data.</div>
                    </div>
                </div>
            </aside>
        </div>
    </section

<?php include ('footer.php'); ?>