<?php 
  declare(strict_types = 1); 
  $name = 'Dá-lhe Ticket'; 
?>

<?php function drawHeader() { ?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title><?php global $name; echo $name; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>

    <header>
      <h1><a href="/"><?php global $name; echo $name; ?></a></h1>
    </header>

    <main>
<?php } ?>

<?php function drawFooter() { ?>
    </main>

    <footer>
      <?php global $name; echo $name; ?> &copy; 2023
    </footer>
  </body>
</html>
<?php } ?>

