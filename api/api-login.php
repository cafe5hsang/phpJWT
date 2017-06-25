<?php
//require_once('vendor/autoload.php');
require_once('../library/jwt/BeforeValidException.php');
require_once('../library/jwt/ExpiredException.php');
require_once('../library/jwt/SignatureInvalidException.php');
require_once('../library/jwt/JWT.php');
// Ho tro php 5.4 tro xuong cac function password
require_once('../library/function.php');

use \Firebase\JWT\JWT; 

define('SECRET_KEY','123abc');  /// secret key: Co the dat gi cung duoc
define('ALGORITHM','HS512');   // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
//// Suppose you have submitted your form data here with username and password
// Server name
define('SERVER_NAME', 'http://localhost/jwt/');

if (isset($_REQUEST['action']) && isset($_REQUEST['username']) && isset($_REQUEST['password']) && isset($_REQUEST['timeLife']) && isset($_REQUEST['timeStart'])) {
  $action = $_REQUEST['action'];
  $username = $_REQUEST['username'];
  $password = $_REQUEST['password'];
  $timeLife = $_REQUEST['timeLife'];
  $timeStart = $_REQUEST['timeStart'];
} else {
  $action = NULL;
  $password = NULL;
  $username = NULL;
  $timeLife = 0;
  $timeStart = 0;
}

// user info
$user = array(
      'id' => '12321312',
      'name' => 'Phong Tran',
      'username' => 'admin',
      'password' => '@beautifu1d4y'
    );

// result
$result = array(
  'status' => false,
  'msg' => '',
  'data' => []
);

if ($username == $user['username'] && $password == $user['password'] && $action == 'login' ) {

  // if there is no error below code run

  $hashAndSalt = password_hash($password, PASSWORD_BCRYPT);
  if(password_verify($user['password'], $hashAndSalt))
  {
                  
    $tokenId    = base64_encode(mcrypt_create_iv(32));
    $issuedAt   = time();
    $notBefore  = $issuedAt + $timeStart;  //Adding 10 seconds
    $expire     = $notBefore + $timeLife; // Adding 60 seconds
    $serverName = SERVER_NAME; /// set your domain name 


    /*
     * Create the token as an array
     */
    $data = [
        'iat'  => $issuedAt,         // Issued at: time when the token was generated
        'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
        'iss'  => $serverName,       // Issuer
        'nbf'  => $notBefore,        // Not before
        'exp'  => $expire,           // Expire
        'data' => [                  // Data related to the logged user you can set your required data
            'id'   => $user['id'], // id from the users table
            'name' => $user['name'], //  name
        ]
    ];
    $secretKey = base64_decode(SECRET_KEY);
    /// Here we will transform this array into JWT:
    $jwt = JWT::encode(
      $data, //Data to be encoded in the JWT
      $secretKey, // The signing key
      ALGORITHM
    ); 
    $unencodedArray = ['jwt' => $jwt];
    $result['data'] = $unencodedArray;
    $result['status'] = true;
    $result['msg'] = 'success';
  } else {
    $result['status'] = false;
    $result['msg'] = 'Invalid email or passowrd';
  }
}

echo json_encode($result);
?>