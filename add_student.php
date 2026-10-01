<?php
include 'database.php';
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id     = trim($_POST['student_id']);
    $full_name      = trim($_POST['full_name']);
    $course         = trim($_POST['course']);
    $year_level     = (int) $_POST['year_level'];
    $email          = trim($_POST['email']);
    $contact_number = trim($_POST['contact_number']);

    $stmt = $conn->prepare(
        "INSERT INTO students (student_id, full_name, course, year_level, email, contact_number)
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("sssiss", $student_id, $full_name, $course, $year_level, $email, $contact_number);

    try {
        $stmt->execute();
        header("Location: index.php?msg=added");
        exit;
    } catch (mysqli_sql_exception $e) {
        $error = "Could not save. That Student ID may already exist.";
    }
}
?>
<?php $page_title = "Add Student"; include 'header.php'; ?>

<div class="card">
  <h1>Add Student</h1>
  <p class="subtitle">Fill out the form to register a new student.</p>

  <?php if ($error): ?>
    <div class="error"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="form-grid">
      <div>
        <label>Student ID</label>
        <input type="text" name="student_id" required>
      </div>
      <div>
        <label>Full Name</label>
        <input type="text" name="full_name" required>
      </div>
      <div>
        <label>Course</label>
        <input type="text" name="course">
      </div>
      <div>
        <label>Year Level</label>
        <input type="number" name="year_level" min="1" max="6">
      </div>
      <div>
        <label>Email</label>
        <input type="email" name="email">
      </div>
      <div>
        <label>Contact Number</label>
        <input type="text" name="contact_number">
      </div>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn">Save</button>
      <a href="index.php" class="btn btn-gray">Cancel</a>
    </div>
  </form>
</div>

<?php include 'footer.php'; ?>