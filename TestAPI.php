<?php

$host = "localhost";
$dbname = "testapi";
$username = "root";
$password = "";
$connexion;
try {
    $connexion = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}



$url = 'http://universities.hipolabs.com/search?country=India';


$curl = curl_init($url); // Get cURL resource

// return the transfer as a string, also with setopt()
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($curl); // Send the request, save the response
$data = json_decode($response, true);

// print_r($data); // print json decoded response

foreach ($data as $test):

    echo 'Name: ' . $test['name'] . '<br>';
    echo 'Country: ' . $test['country'] . '<br>';
    echo 'Alpha two code: ' . $test['alpha_two_code'] . '<br>';
    echo '<br>';

    $sql = "INSERT INTO testapi (name, country, alpha_two_code) VALUES (:name, :country, :alpha_two_code)";
    $stmt = $connexion->prepare($sql);
     $stmt->bindParam(':name', $test['name']);
     $stmt->bindParam(':country', $test['country']);
     $stmt->bindParam(':alpha_two_code', $test['alpha_two_code']);

     $stmt->execute();

endforeach;
$connexion = null;
curl_close($curl); // Close request
