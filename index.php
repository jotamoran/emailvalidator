<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors', 1);

if ($_REQUEST AND isset($_REQUEST['email']))
{
    require_once 'emailvalidator.php';
    $check = emailvalidator::check($_REQUEST['email']);
    header('Content-Type: application/json');
    die(json_encode(array(  'response'  => ($check===TRUE)?TRUE:FALSE,
                            'comments' => ($check===TRUE)?$_REQUEST['email']:$check)
        ));
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="testing mail validation">
    <meta name="author" content="jmoran">

    <title>Test</title>  

  </head>

  <body>

    <h1>Testing email validator</h1>
   
  </body>
</html>