<?php
// Задаємо заголовок сторінки.
$page_title = 'Edit article';

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
if (isset($_POST['submit'])) {

  try {
    $stmt = $conn->prepare('UPDATE content SET title = ?,  short_desc = ?, full_desc = ?');

    // Обрізаємо усі теги у загловку.

    $title = strip_tags($_POST['title']);
   	// Екрануємо теги у полях короткого та повного опису.
    $short_desc = htmlspecialchars($_POST['short_desc']);
    $full_desc = htmlspecialchars($_POST['full_desc']);
   
    // Виконуємо запит, результат запиту знаходиться у змінні $status.
    // Якщо $status рівне TRUE, тоді запит відбувся успішно.
    $status = $stmt->execute(array($title, $short_desc, $full_desc));

  } catch(PDOException $e) {
    // Виводимо на екран помилку.o
    print "ERROR6: {$e->getMessage()}";
    // Закриваємо футер.
    require('base/footer.php');
    // Зупиняємо роботу скрипта.
    exit;
  }

  // При успішному запиту перенаправляємо користувача на сторінку перегляду статті.
  if ($status) {
    // За допомогою методу lastInsertId() ми маємо змогу отрмати ІД статті, що була вставлена.
    header("Location: index.php");
    exit;
  }
  else {
    // Вивід повідомлення про невдале додавання матеріалу.
    print "Запис не був змінений.";
  }
}

try {
  // Вибираємо усі з необхідними полями статті та поміщаємо їх у змінну $articles.
  $stmt = $conn->prepare('SELECT * FROM content WHERE id = ?');

  $stmt->execute(array($_GET['id']));

} catch(PDOException $e) {
  // Виводимо на екран помилку.
  print "ERROR: {$e->getMessage()}";
  // Закриваємо футер.
  require('base/footer.php');
  // Зупиняємо роботу скрипта.
  exit;
}
?>
<!-- Пишемо форму, метод ПОСТ, форма відправляє данні на цей же скрипт. -->
<?php
foreach ($stmt as $key): 
?>
<form action="<?php print $_SERVER["PHP_SELF"]; ?>" method="POST">

  <div class="field-item">
    <label for="title">Заголовок</label>
    <input type="text" name="title" id="title" value="<? echo $key['title']; ?>" required maxlength="255">
  </div>

  <div class="field-item">
    <label for="short_desc">Короткий зміст</label>
    <textarea name="short_desc" id="short_desc" required maxlength="600"> <? echo $key['short_desc']; ?></textarea>
  </div>

  <div class="field-item">
    <label for="full_desc">Повний зміст</label>
    <textarea name="full_desc" id="full_desc" required><? echo $key['full_desc']; ?></textarea>
  </div>
  <input type="submit" name="submit" value="Зберегти">

</form>
<?php
endforeach;
// Підключаємо футер сайту.
require('base/footer.php');
?>
