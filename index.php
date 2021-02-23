<?php
 
/** @var \PDO $pdo */
require_once './pdo_ini.php';

session_start();

if (!empty($_SESSION['user_id'])) {
   $entered_user = $_SESSION['user_id'];
   $entered_username =  $_SESSION['user_name'];
} else {
   header('Location: login.php');
}

/* Fetch user's lists */

$sqlStrLists = <<<SQL
SELECT l.id AS `id`, l.title AS `title`
FROM lists l
JOIN users u ON u.id = l.user_id
WHERE u.id = :user_id
SQL;
$sth = $pdo->prepare($sqlStrLists);
$sth->setFetchMode(\PDO::FETCH_ASSOC);
$sth->execute(['user_id' => $entered_user]);
$lists = $sth->fetchAll();

include ("header.php");

?>

<main role="main" class="container">
	
	<section id="todo_list_content">
	
		<h1 class="mt-2 mb-3">TODO Lists</h1>
		<?= $lists ? '' : 'No TODO lists here yet' ?>
		
		<ul id="todo_list_ul">
		
		<?php foreach ($lists as $list):  ?>
		
			<li>
				<p>
					<a class="btn btn-primary" data-toggle="collapse" href="#<?= 'collapse' . $list['id'] ?>" role="button" aria-expanded="<?= ($_SESSION['list_id'] == $list['id']) ? 'true' : 'false'?>" aria-controls="<?= 'collapse' . $list['id'] ?>">
						<?= $list['title'] ?>
					</a>
				</p>
<?php

/* Fetch tasks of a certain list */
	
$sqlStr = <<<SQL
SELECT t.id AS `task_id`, t.title AS `title`, t.created_at AS `created_at`, t.is_done AS `done`, u.id AS `user_id`, u.name AS `user_name`, l.id AS `list_id`, l.title AS `list_title`
FROM tasks t
JOIN lists l ON l.id = t.list_id
JOIN users u ON u.id = l.user_id
WHERE u.id = :user_id AND l.id = :list_id
SQL;
$sth = $pdo->prepare($sqlStr);
$sth->setFetchMode(\PDO::FETCH_ASSOC);
$sth->execute(['user_id' => $entered_user, 'list_id' => $list['id']]);
$tasks = $sth->fetchAll();

?>		

				<div class="tasks_div bg-light collapse <?= ($_SESSION['list_id'] == $list['id']) ? 'show' : ''?>" id="<?= 'collapse' . $list['id'] ?>">
					<?= $tasks ? '' : 'No tasks here yet' ?>
					
					<!-- Form to add new task in TODOlist -->					
					<form method="POST" action="forms.php">
						<input class="task_title" name="task_title" placeholder = "New Task" type="text">
						<input type="hidden" name="list_id" value="<?= $list['id'] ?>">
						<input class="submit_new_task" name="submit_new_task" type="submit" value="Add new task">
					</form>		
					
					<table class="tasks_table mt-3">
					
						<?php foreach ($tasks as $task): ?>
						
							<tr>
							   <td><?= $task['title'] ?></td>
							   <!--<td>/**/</td>-->		
							   <td>
									<!-- Form to mark if task is done -->
									<form method="POST" action="forms.php">
										<input type="checkbox" value="" name="check_is_done" onChange="this.form.submit()" <?= $task['done'] ? 'checked' : '' ?> title="Mark if task is done">
										<input type="hidden" name="task_id_for_check" value="<?= $task['task_id'] ?>">
										<input type="hidden" name="list_id" value="<?= $list['id'] ?>">
									</form>	
								</td>	
							   <td>
									<!-- Form to delete task in TODOlist -->
									<form method="POST" action="forms.php">
										<button type="submit" class="close" name="delete" title="Delete task">&times;</button>
										<input type="hidden" name="list_id" value="<?= $list['id'] ?>">
										<input type="hidden" name="task_id" value="<?= $task['task_id'] ?>">
									</form>	
								</td>	   
							</tr>
							
						<?php endforeach; ?>
					
					</table>
				</div>
				
			</li>
			
		<?php endforeach; ?>
		
		</ul>
		
		<hr>
		
		<!-- Form to add new TODOlist -->
		<form method="POST" action="forms.php">
            <input id="list_title" name="list_title" placeholder = "Enter New List Title" type="text">
			<input type="hidden" name="user_id" value="<?= $entered_user ?>">
            <input id="submit_new_list" name="submit_new_list" type="submit" value="Add new TODO list">
        </form>		
		
	</section>

</main>
</html>
