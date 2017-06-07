<?php
require_once 'google-api/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfig('/etc/pki/tls/certs/google_creds.json');
$client->setRedirectUri('https://staging.wgaca-works.com/googletest/callback.php');
$client->addScope(Google_Service_Plus::PLUS_ME);

if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect_uri = 'https://staging.wgaca-works.com/googletest/test.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
