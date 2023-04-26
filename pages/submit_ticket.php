<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../templates/common.tpl.php');

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/department.class.php');

  if (!($session->isLoggedIn())) {
    header('Location: ../index.php');
  }

  $db = getDatabaseConnection();

  drawHeader();
?>

<form action="../actions/action_submit_ticket.php" method="post" class="submit_ticket">
  <label for="title">Title</label>
  <input type="text" name="title" id="title" placeholder="A title for your ticket">
  <label for="department">Department</label>
  <select name="department" id="department">
      <?php
      foreach (Department::getAllDepartments($db) as $department) {
          ?>
          <option value="<?=$department->name?>"><?=$department->name?></option>
          <?php
      }
      ?>
  </select>
  <label for="message">Message</label>
  <textarea name="message" id="message"></textarea>
  <button type="submit">Submit</button>
</form>

<?php
    drawFooter();
?>
