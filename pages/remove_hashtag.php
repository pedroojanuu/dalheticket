<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../templates/common.tpl.php');

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');

  $db = getDatabaseConnection();

  require_once(__DIR__ . '/../database/ticket.class.php');
  require_once(__DIR__ . '/../database/user.class.php');
  require_once(__DIR__ . '/../database/department.class.php');

  if (!($session->isLoggedIn())) {
    header('Location: ../index.php');
  }

  $ticket = Ticket::getTicketById($db, intval($_GET['id']));
  $hashtags = $ticket->getHashtags($db);

  $department = Department::getDepartmentByName($db, $ticket->department);

  $me = User::getUserByUsername($db, $session->getName());

  if ($me->type != 'admin' && $ticket->agent != $me->username) {
    header('Location: ../index.php');
  }

  drawHeader();
?>

  <h3>Removing an hashtag from "<?= $ticket->title ?>"</h3>
  <form action="../actions/action_remove_hashtag.php" method="post">
    <input type="hidden" name="id" value="<?= $ticket->id ?>">
    <select class="select_list" name="tag">
<?php
foreach ($hashtags as $hashtag) {
?>
        <option value="<?= $hashtag->tag ?>"><?= $hashtag->tag ?></option>
<?php
}
?>
    </select>
    <button type="submit">Remove</button>
  </form>

<?php
  drawFooter();
?>
