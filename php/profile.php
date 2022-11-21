<?php
include "mongodb.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        $firstname = $_POST['firstName'];
        $lastname = $_POST['lastName'];
        $dob = $_POST['dob'];
        $phoneno = $_POST['phoneNo'];
        $place = $_POST['place'];
        $profile_data = (
            [
                'email' => $email,
                'firstName' => $firstname,
                'lastName' => $lastname,
                'dob' => $dob,
                'phoneNo' => $phoneno,
                'place' => $place
            ]
        );
        try {
            $profileCollection->insertOne($profile_data);
            echo 'success';
        } catch (\Throwable $th) {
            echo 'failed';
        }
    } else {
        echo 'oops error! try again';

    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include 'rediscache.php';
    $cache = $redis->get('sessionCache');
    if ($cache) {
        echo $cache;
    } else {
        if (isset($_GET['email'])) {
            $email = $_GET['email'];
            $find_email = (['email' => $email]);
            $reponse = $profileCollection->findone($find_email);
            $jsonData = json_encode($reponse);
            echo $jsonData;
            $redis->set('sessionCache', $jsonData);
        } else {
            echo 'login again';
        }
    }

} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    include 'rediscache.php';
    parse_str(file_get_contents('php://input'), $_PUT);
    if (isset($_PUT['email'])) {
        $putemail = $_PUT['email'];
        $putfirstname = $_PUT['firstName'];
        $putlastname = $_PUT['lastName'];
        $putdob = $_PUT['dob'];
        $putphoneno = $_PUT['phoneNo'];
        $putplace = $_PUT['place'];
        $find_email = (['email' => $putemail]);


        try {
            $reponsse = $profileCollection->findOneAndUpdate(
                $find_email,
                [
                    '$set' => [
                        'firstName' => $putfirstname,
                        'lastName' => $putlastname,
                        'dob' => $putdob,
                        'phoneNo' => $putphoneno,
                        'place' => $putplace,
                    ],
                ]
            );
            $redis->flushall();
            echo 'success';
        } catch (\Throwable $throw) {
            echo 'failed';
        }

    }
}
?>