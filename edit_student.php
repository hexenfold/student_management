<?php
include 'database.php';
$error = "";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id             = (int) $_POST['id'];
    $student_id     = trim($_POST['student_id']);
    $full_name      = trim($_POST['full_name']);
    $course         = trim($_POST['course']);
    $year_level     = (int) $_POST['year_level'];
    $email          = trim($_POST['email']);
    $contact_number = trim($_POST['contact_number']);

    $stmt = $conn->prepare(
        "UPDATE students
         SET student_id = ?, full_name = ?, course = ?, year_level = ?, email = ?, contact_number = ?
         WHERE id = ?"
    );
    $stmt->bind_param("sssissi", $student_id, $full_name, $course, $year_level, $email, $contact_number, $id);

    try {
        $stmt->execute();
        header("Location: index.php?msg=updated");
        exit;
    } catch (mysqli_sql_exception $e) {
        $error = "Could not update. That Student ID may already exist.";
    }
}

$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

if (!$student) {
    die("Student not found.");
}

$page_title = "Edit Student";
include 'header.php';
?>

<div class="card">
  <h1>Edit Student</h1>
  <p class="subtitle">Update the student's information.</p>

  <?php if ($error): ?>
    <div class="error"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST">
    <input type="hidden" name="id" value="<?= $student['id'] ?>">

    <div class="form-grid">
      <div>
        <label>Student ID</label>
        <input type="text" name="student_id" value="<?= htmlspecialchars($student['student_id']) ?>" required>
      </div>
      <div>
        <label>Full Name</label>
        <input type="text" name="full_name" value="<?= htmlspecialchars($student['full_name']) ?>" required>
      </div>
      <div>
        <label>Course</label>
        <input type="text" name="course" value="<?= htmlspecialchars($student['course']) ?>">
      </div>
      <div>
        <label>Year Level</label>
        <input type="number" name="year_level" min="1" max="6" value="<?= htmlspecialchars($student['year_level']) ?>">
      </div>
      <div>
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>">
      </div>
      <div>
        <label>Contact Number</label>
        <input type="text" name="contact_number" value="<?= htmlspecialchars($student['contact_number']) ?>">
      </div>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn">Update</button>
      <a href="index.php" class="btn btn-gray">Cancel</a>
    </div>
  </form>
</div>

<?php include 'footer.php'; ?>