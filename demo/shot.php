<?php

// Use the first autoload instead if you don't want to install composer
//require_once '../autoload.php';
require_once '../vendor/autoload.php';

if (!isset($_GET['url']) || !isset($_GET['accessCode']) || $_GET['accessCode'] != 'SS007') {
    exit;
}

//Set a random user agent to use in the request (Using the top 10 most common user agents from March 1st 2018
$rand2 = rand(1,10);
if($rand2 == '1'){
$useragent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36';
}ELSE if($rand2 == '2'){
$useragent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.167 Safari/537.36';
}ELSE if($rand2 == '3'){
$useragent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:58.0) Gecko/20100101 Firefox/58.0';
}ELSE if($rand2 == '4'){
$useragent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36';
}ELSE if($rand2 == '5'){
$useragent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_3) AppleWebKit/604.5.6 (KHTML, like Gecko) Version/11.0.3 Safari/604.5.6';
}ELSE if($rand2 == '6'){
$useragent = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36';
}ELSE if($rand2 == '7'){
$useragent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36';
}ELSE if($rand2 == '8'){
$useragent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.167 Safari/537.36';
}ELSE if($rand2 == '9'){
$useragent = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36';
}ELSE if($rand2 == '10'){
$useragent = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:58.0) Gecko/20100101 Firefox/58.0';
}  

//Load the screencapture system
$screen = new Screen\Capture($_GET['url']);

$screen->setOptions([
    'ignore-ssl-errors' => 'true',
    'disk-cache' => 'false',
    
]);

//Set the useragent to be used
$screen->setUserAgentString($useragent);

if (isset($_GET['w'])) { // Width
    $screen->setWidth(intval($_GET['w']));
}

if (isset($_GET['h'])) { // Height
    $screen->setHeight(intval($_GET['h']));
}

if (isset($_GET['clipw'])) { // Clip Width
    $screen->setClipWidth(intval($_GET['clipw']));
}

if (isset($_GET['cliph'])) { // Clip Height
    $screen->setClipHeight(intval($_GET['cliph']));
}

if (isset($_GET['user-agent'])) { // User Agent String
    $screen->setUserAgentString($_GET['user-agent']);
}

if (isset($_GET['bg-color'])) { // Background Color
    $screen->setBackgroundColor($_GET['bg-color']);
}

if (isset($_GET['format'])) { // Format
    $screen->setImageType($_GET['format']);
}

if (isset($_GET['delay'])) { // Delay
    $screen->setDelay($_GET['delay']);
}

if (isset($_GET['timeout'])) { // Delay
    $screen->setTimeout($_GET['timeout']);
} 

$fileLocation = 'test';
$screen->save($fileLocation);

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
header('Content-Type:' . $screen->getImageType()->getMimeType());
header('Content-Length: ' . filesize($screen->getImageLocation()));
readfile($screen->getImageLocation());

//Remove the file after responding
unlink($screen->getImageLocation());
