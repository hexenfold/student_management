<?php $current = basename($_SERVER['PHP_SELF']); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $page_title ?? 'Student Management' ?></title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar">
  <div class="brand">🎓 Student Management</div>
  <div class="nav-links">
    <a href="index.php" class="<?= $current == 'index.php' ? 'active' : '' ?>">Students</a>
    <a href="add_student.php" class="<?= $current == 'add_student.php' ? 'active' : '' ?>">Add Student</a>
  </div>
</nav>
<div class="container">