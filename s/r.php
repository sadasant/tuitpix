<?
require 'tmhOAuth.php';
require 'tmhUtilities.php';
$tmhOAuth = new tmhOAuth(array(
  'consumer_key' => 'Cq7JSjwGt6ie9IJQABKA',
  'consumer_secret' => '09cXbRM3TlXhvE6Vlsmm70guG3Vmc4XkCRmSGl2Bi6s',
));

$here = tmhUtilities::php_self();
session_start();
?>
