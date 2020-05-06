<?php

require_once('./environments/dbCredentials.php');
require_once('vendor/autoload.php');

$firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
