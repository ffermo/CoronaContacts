<!DOCTYPE html>
<html lang="en">
<head>
     
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://bootswatch.com/4/journal/bootstrap.min.css" />
    <title>Dashboard</title>
    <div class="jumbotron">
        <h1 class="display-4">Hello, UserName!</h1>
        <p class="lead">Here at CoronaContact Club, we want you to keep safe by recording a log of your interaction with infected citizens.</p>
        <hr class="my-4">
        <p>Choose any of the options below to manipulate your data... (Pending Update)</p>
        <p class="lead">
          <a class="btn btn-primary btn-lg" id="search" href="#" role="button">Search Contact</a>
          <a class="btn btn-info btn-lg" id="create" href="#" role="button">Create Contact</a>
        </p>
      </div>
</head>
<body>

<?php require_once 'SearchContact.php'; ?>

<?php 
  $mysqli = new mysqli("localhost", "faizar", "", "coronacontacts");
  $result = $mysqli->query("SELECT * FROM Contacts");
  pre_r($result);

  function pre_r( $array ) {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
  }

?>


</body>

</html>
