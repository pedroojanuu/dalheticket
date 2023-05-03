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

  if (!($session->isLoggedIn()) || User::getUserTypeByUsername($db, $session->getName()) != 'admin') {
    header('Location: ../index.php');
  }

  $ticket = Ticket::getTicketById($db, intval($_GET['id']));

  $department = Department::getDepartmentByName($db, $ticket->department);
  $agents = $department->getMemberAgents($db);

  drawHeader();
?>

  <h3>Assigning <?= $ticket->title ?></h3>

  <form action="../actions/action_assign_ticket.php" method="get">
    <input type=hidden name="id" value="<?= $ticket->id ?>">
    <select class="select_list" name="agent">
<?php
foreach ($agents as $agent) {
?>
        <option value="<?= $agent->username ?>"><?= $agent->name ?></option>
<?php
}
?>
    </select>
    <button type="submit">Assign</button>
  </form>

<?php
  drawFooter();
?>
