<?php
require('base/header.php');

// Видаляємо інформацію про сесію.
session_destroy();

// Направляємо користувача на головну сторінку.
header('Location: /');

require('base/footer.php');