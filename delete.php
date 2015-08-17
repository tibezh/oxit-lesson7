<?php
// Задаємо заголовок сторінки.
$page_title = 'Delete article';

require('base/header.php');

// Якщо на сторінку зайшов НЕ редактор, тоді даємо у відповідь статус 403 та пишемо повідомлення.
if (!$editor) {
  header('HTTP/1.1 403 Unauthorized');
  print 'Доступ заборонено.';
  // Підключаємо футер та припиняємо роботу скрипта.
  require('base/footer.php');
  exit;
}

// Підключення БД, адже нам необхідне підключення для створення статті.
require('base/db.example.php');

// Якщо ми отримали дані з ПОСТа, тоді обробляємо їх та вставляємо.

$id = $_GET['id'];

try {
    $status = $conn->prepare('DELETE FROM content WHERE id = ?');

	$status->execute(array($id));
 
  } catch(PDOException $e) {
    // Виводимо на екран помилку.
    print "ERROR: {$e->getMessage()}";
    // Закриваємо футер.
    require('base/footer.php');
    // Зупиняємо роботу скрипта.
    exit;
  }
  if($status){
	?>
	<script> alert("Статю успішно видалено"); </script>
	<?
	}
	else{
	?>
 	<script> alert("Сталася помилка під час видалення статі повторіть будь-ласка!"); </script> 
	<?
	}

?>