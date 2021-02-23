<?php 

/** @var \PDO $pdo */
require_once './pdo_ini.php';

if(isset($_POST['submit_new_task'])) {
/* Add a new task */
    $taskTitle = $_POST['task_title'];
    $listId = $_POST['list_id'];
	$sth = $pdo->prepare("INSERT INTO tasks (title, list_id) VALUES (:task_title, :list_id)");
    $sth->bindValue(':task_title', $taskTitle);
    $sth->bindValue(':list_id', $listId);
	$sth->execute();
} elseif(isset($_POST['delete'])) {
/* Delete a task */
    $taskId = $_POST['task_id'];
    $sth = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
    $sth->bindValue(':id', $taskId, PDO::PARAM_INT);
    $sth->execute();
} elseif(isset($_POST['task_id_for_check'])) {
/* Modify "is_done" of a task */
    $taskId = $_POST['task_id_for_check'];
	$isDone = isset($_POST['check_is_done']) ? 1 : 0;
    $sth = $pdo->prepare("UPDATE tasks SET is_done = :is_done WHERE id = :id");
    $sth->bindValue(':id', $taskId);
    $sth->bindValue(':is_done', $isDone);
    $sth->execute();
} elseif(isset($_POST['submit_new_list'])) {
/* Add a new TODOlist */
    $listTitle = $_POST['list_title'];
    $userId = $_POST['user_id'];
	$sth = $pdo->prepare("INSERT INTO lists (title, user_id) VALUES (:list_title, :user_id)");
    $sth->bindValue(':list_title', $listTitle);
    $sth->bindValue(':user_id', $userId);
	$sth->execute();
	$listId = $pdo->lastInsertId();
}

/* Remember in SESSION the id of TODOlist which was modified  */
if (isset($_POST['list_id']) || $listId) {
	session_start();
	$_SESSION['list_id'] = isset($_POST['list_id']) ? $_POST['list_id'] : $listId;	
}

/* Return to index.php page*/
	header('Location: /');

?>
