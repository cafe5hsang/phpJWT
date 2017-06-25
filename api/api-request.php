<?php 
//require_once('vendor/autoload.php');
require_once('../library/jwt/BeforeValidException.php');
require_once('../library/jwt/ExpiredException.php');
require_once('../library/jwt/SignatureInvalidException.php');
require_once('../library/jwt/JWT.php');
// Ho tro php 5.4 tro xuong cac function password
require_once('../library/function.php');

use \Firebase\JWT\JWT; 

define('SECRET_KEY','123abc');  /// secret key can be a random string and keep in secret from anyone
define('ALGORITHM','HS512');   // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
//// Suppose you have submitted your form data here with username and password

// result
$result = array(
	'status' => false,
	'msg' => '',
	'data' => []
);

if (!empty($_REQUEST['access_token'])) {
  try {
    $secretKey = base64_decode(SECRET_KEY); 
    $DecodedDataArray = JWT::decode($_REQUEST['access_token'], $secretKey, array(ALGORITHM));
    $result['status'] = true;
    $result['msg'] = 'request success';
    $result['data'] = $DecodedDataArray;
  } catch (Exception $e) {
    $result['msg'] = 'request Unauthorized';
    $result['data'] = $e->getMessage();
  }
  echo json_encode($result);
}
?>