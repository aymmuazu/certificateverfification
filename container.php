<div class="col-md-5">
    <i><h3 class="fw-bold">Verify a Certificate</h3></i>

    <form method="POST" action="certverpay.php"> 
        <div class="mb-2">
            <label for="email">Email (Note, reciept will be send to this email)</label>
            <input type="text" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-2">
            <label for="cert_no">Certificate Number</label>
            <input type="text" name="cert_no" id="cert_no" class="form-control" required>
        </div>
        
        <div class="mb-2">
            <button type="submit" class="btn btn-dark w-100">Verify</button>
        </div>
    </form>
</div>

<div class="col-md">
    <div class="card">
        <div class="card-body card-warning">
            <div class="card-heading fw-bold">
                Attention
            </div>
            <div class="">
                <i class="text-danger">This service attracts you a fee of <b>N500</b> for certificate verification, remember this is for the purpose of Employment, Recruitment or Allied Service excercise</i>
            </div>

            <a href="mypayments.php" class="mt-3 btn btn-dark">My Activities/Payments</a>
        </div>
    </div>
</div>