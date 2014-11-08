<? 

$incl_path = "/home3/apowers/php/";
//include ($incl_path . "HTTP/Request.php");
require_once ($incl_path . "HTTP/Request2.php");
//PEAR::setErrorHandling(PEAR_ERROR_DIE);

$base_url = "https://keepa.com";
$login_url = "https://keepa.com/ajax/user.php?action=login";
$add_url = "http://requestb.in/19numoc1";
$add_url = "https://keepa.com/ajax/track.php?action=track&asin=%s&domain=1";
$username = "myusername";
$password = "abc123";
$email = "johndoe@email.com";
$asin = "B00CCPIJGS"; // pudding book
$asin = "B000SEI6L8"; // baby book
$price = "10.00";

/*print "************************** GET / *****************************\n";
$req = new Http_Request2 ($base_url, HTTP_Request2::METHOD_GET);
$req->setConfig (array (
    'ssl_verify_host' => false,
    'ssl_verify_peer' => false ));
try {
  $resp = $req->send();
  if (200 == $resp->getStatus()) {
    echo $resp->getBody();
  } else {
    echo 'Unexpected HTTP status: ' . $resp->getStatus() . ' ' .
	$resp->getReasonPhrase();
  }
} catch (HTTP_Request2_Exception $e) {
  echo 'Error: ' . $e->getMessage();
}
$session_cookie = $resp->getCookies()[0];
print "done!\n";*/

print "************************** POST Login *****************************\n";
$req = new Http_Request2 ($login_url, HTTP_Request2::METHOD_POST);
/*$req->setUrl ($login_url); 
$req->setMethod (HTTP_Request2::METHOD_POST);*/
$req->addCookie ($session_cookie['name'], $session_cookie['value']);
$req->addPostParameter ("username", $username);
$req->addPostParameter ("password", $password);
$req->addPostParameter ("rememberMe", "1");
//$req->addPostParameter ("action","login");
//$req->setHeader ("Host: keepa.com");
//$req->setHeader ("Accept: application/json, text/javascript, */*; q=0.01");
/*$req->setHeader ("Origin: https://keepa.com");
$req->setHeader ("X-Requested-With: XMLHttpRequest");
$req->setHeader ("User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36");
$req->setHeader ("Referer: https://keepa.com/ ");
$req->setHeader ("Accept-Encoding: gzip,deflate");
$req->setHeader ("Accept-Language: en-US,en;q=0.8");*/

$req->setConfig (array (
    'ssl_verify_host' => false,
    'ssl_verify_peer' => false ));
try {
  $resp = $req->send();
  if (200 == $resp->getStatus()) {
    echo $resp->getBody();
  } else {
    echo 'Unexpected HTTP status: ' . $resp->getStatus() . ' ' .
	$resp->getReasonPhrase();
  }
} catch (HTTP_Request2_Exception $e) {
  echo 'Error: ' . $e->getMessage();
}
print_r ($resp->getHeader());
print_r ($resp->getBody());
print_r ($resp->getCookies());
$cookies = $resp->getCookies();
print "done!\n";

print "************************** POST Add Tracking *****************************\n";
$add_url =  sprintf ($add_url, $asin);
print "URL is: \"" . $add_url . "\"\n";
$req = new Http_Request2 ($add_url, HTTP_Request2::METHOD_POST);
//$req->setHeader ("Host: keepa.com");
$req->setHeader ("Accept: application/json, text/javascript, */*; q=0.01");
$req->setHeader ("Origin: https://keepa.com");
$req->setHeader ("X-Requested-With: XMLHttpRequest");
$req->setHeader ("User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36");
$req->setHeader ("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");
$req->setHeader ("Referer: https://keepa.com/ ");
$req->setHeader ("Accept-Encoding: gzip,deflate");
$req->setHeader ("Accept-Language: en-US,en;q=0.8");

/*$req->addPostParameter ("action", "track");
$req->addPostParameter ("asin", $asin);
$req->addPostParameter ("domain", "1");*/

// typical procing
$req->addPostParameter ("priceAmazon", $price);
$req->addPostParameter ("priceNew", $price);
$req->addPostParameter ("priceUsed", $price);

// international pricing
/*$req->addPostParameter ("CA", $price);
$req->addPostParameter ("GB", $price);
$req->addPostParameter ("DE", $price);
$req->addPostParameter ("FR", $price);
$req->addPostParameter ("IT", $price);
$req->addPostParameter ("ES", $price);
$req->addPostParameter ("JP", $price);
$req->addPostParameter ("CN", $price);*/
$req->addPostParameter ("multPriceCA", 0);
$req->addPostParameter ("multPriceGB", 0);
$req->addPostParameter ("multPriceDE", 0);
$req->addPostParameter ("multPriceFR", 0);
$req->addPostParameter ("multPriceIT", 0);
$req->addPostParameter ("multPriceES", 0);
$req->addPostParameter ("multPriceJP", 0);
$req->addPostParameter ("multPriceCN", 0);

// notification options
$req->addPostParameter ("email", $email);
$req->addPostParameter ("twitter", "");
$req->addPostParameter ("facebook", "");
$req->addPostParameter ("trackEmail", 1);
$req->addPostParameter ("trackFacebook", 0);
$req->addPostParameter ("trackTwitter", 0);
$req->addPostParameter ("hash", "");
foreach ($cookies as $cookie) {
  $req->addCookie ($cookie['name'], $cookie['value']);
}

$req->setConfig (array (
    'ssl_verify_host' => false,
    'ssl_verify_peer' => false 
    ));

try {
  print "Getting URL: \"" . $req->getUrl()->getUrl() . "\"\n";
  //print_r ($req);
  $resp = $req->send();
  if (200 == $resp->getStatus()) {
    //echo $resp->getBody();
    print $resp->getStatus() . ": " . $resp->getReasonPhrase() . "\n";
  } else {
    echo 'Unexpected HTTP status: ' . $resp->getStatus() . ' ' .
	$resp->getReasonPhrase();
  }
} catch (HTTP_Request2_Exception $e) {
  echo 'Error: ' . $e->getMessage();
}
print_r ($resp->getHeader());
//print_r ($resp->getBody());
print_r ($resp->getCookies());

?>
