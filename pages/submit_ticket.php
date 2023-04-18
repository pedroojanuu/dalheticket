<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../templates/common.tpl.php');

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/department.class.php');

  $db = getDatabaseConnection();

  drawHeader();

  if (!($session->isLoggedIn())) {
    header('Location: ../index.php');
  }
?>

<form action="../actions/action_submit_ticket.php" method="post" class="submit_ticket">
    <select name="department">
        <?php
        foreach (Department::getAllDepartments($db) as $department) {
            ?>
            <option value="<?=$department->name?>"><?=$department->name?></option>
            <?php
        }
        ?>
    </select>
    <textarea name="message"></textarea>
    <button type="submit">Submit</button>
</form>

<?php
    drawFooter();
?>
