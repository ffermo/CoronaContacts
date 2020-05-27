


<!DOCTYPE html>
<html lang="en">
<head>
     <?php include 'APICode/login.php';?>
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
          <a class="btn btn-primary btn-lg"  href="#" role="button">Search</a>
          <a class="btn btn-info btn-lg"  href="#" role="button">Add</a>
        </p>
      </div>
</head>
<body>
  <p>

    <?php
$array = array(1, 2, 3, 4);
?>

<table>
<thead><tr><th>Number</th></tr></thead>
<tbody>
<?php foreach ($array as $num) : ?>
<tr><td><?= htmlspecialchars($num) ?></td></tr>
<?php endforeach ?>
</tbody>
</table>
  </p>
</body>
</html>