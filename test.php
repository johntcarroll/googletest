<?php
session_start();
error_reporting(E_ALL); ini_set('display_errors', 1);
require_once 'google-api/vendor/autoload.php';

$client = new Google_Client();
$client->setAuthConfig('/etc/pki/tls/certs/google_creds.json');
$client->addScope(Google_Service_Plus::PLUS_ME);

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
  $plus = new Google_Service_Plus($client);
  $person_data = $plus->people;
  print_r($person_data);
  unset($_SESSION['access_token']);
  session_destroy();
} else {
  $redirect_uri = 'https://staging.wgaca-works.com/googletest/callback.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
?>
