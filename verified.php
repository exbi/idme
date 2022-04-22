You have been verified!

<?php 

// we parse the authorization code received via the GET response to our authentication.

$code = $_GET['code']; 

// we now send a POST request to our API in order to exchange our authorization code for our access token.

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.id.me/oauth/token');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type' => 'application/x-www-form-urlencoded',
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'code={$code}&client_id=c89b390d2f44b8eaaf9b16b3d4539ff6&client_secret=10ba377c854da09b0363b270be51f0b2&redirect_uri=https://idmetest.herokuapp.com/verified.php&grant_type=authorization_code');

$response = curl_exec($ch);

$json = json_decode($response, true);

$token = $json['access_token'];

echo $token;

curl_close($ch);

// we receive our access token, which we can now send back to our API to finally obtain our information payload about our authenticated user via JSON.


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.id.me/api/public/v3/attributes.json?access_token=${token}');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

$response = curl_exec($ch);

echo json_decode($response); 

curl_close($ch);



?>