<?php

require 'core.inc.php';

if (loggedin()) {

    $userId = getuserfield('id');

    $cert_no = filter_input(INPUT_POST, 'cert_no');
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if (isset($cert_no) && !empty($cert_no)) {
        $query  = "SELECT cert_no, id FROM certificates WHERE cert_no=:cert_no";
        $statement = $con->prepare($query);
        $statement->bindValue(':cert_no', $cert_no);
        $statement->execute();
        $cert_no_count = $statement->rowCount();
        $cert = $statement->fetch(PDO::FETCH_OBJ);

        $url = "https://api.paystack.co/transaction/initialize";

        $callback_url = 'http://localhost/certificateverification/callback.php';


        function random18() {
            $number = "";
            for($i=0; $i<10; $i++) {
                $min = ($i == 0) ? 1:0;
                $number .= mt_rand($min,8);
            }
            return $number;
        }

        $reference = date('y').random18().'IH';

        $metadata = [
            'email' => $email,
            'user_id' => $userId,
            'amount' => 500,
            'cert_id' => $cert->id ?? 0
        ];

        $fields = [
            'email' => $email,
            'amount' => '50000',
            'metadata' => $metadata,
            'callback_url' => $callback_url,
            'reference' => $reference
        ];

        $fields_string = http_build_query($fields);

        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer ".$secretKey."",
        "Cache-Control: no-cache",
        ));

        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
        $response = curl_exec($ch);
        $data = json_decode($response);

        if ($data->status == 1) {
            $redirectURL = $data->data->authorization_url;
            echo '<script>window.location.href="'.$redirectURL.'"; </script>';
        }else{
            echo '<script>alert("Invalid Payment, Try again"); window.location.href="home.php"; </script>';
        }

        
    }else{
        header('Location: home.php');
    }


}