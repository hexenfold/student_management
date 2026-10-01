<?php
include 'database.php';

$search = isset($_GET['q']) ? trim($_GET['q']) : "";
$like = "%" . $search . "%";

$stmt = $conn->prepare(
    "SELECT * FROM students
     WHERE student_id LIKE ? OR full_name LIKE ? OR course LIKE ?
     ORDER BY id DESC"
);
$stmt->bind_param("sss", $like, $like, $like);
$stmt->execute();
$result = $stmt->get_result();
$total = $result->num_rows;

$messages = [
    'added'   => 'Student added successfully.',
    'updated' => 'Student updated successfully.',
    'deleted' => 'Student deleted successfully.'
];
$msg = $messages[$_GET['msg'] ?? ''] ?? '';

$page_title = "Students";
include 'header.php';
?>

<div class="card">
  <h1>Student List</h1>
  <p class="subtitle">Total students: <strong><?= $total ?></strong></p>

  <?php if ($msg): ?>
    <div class="alert"><?= $msg ?></div>
  <?php endif; ?>

  <div class="toolbar">
    <form method="GET">
      <input type="text" name="q" placeholder="Search by ID, name, or course..."
             value="<?= htmlspecialchars($search) ?>">
      <button type="submit" class="btn">Search</button>
      <?php if ($search): ?>
        <a href="index.php" class="btn btn-gray">Clear</a>
      <?php endif; ?>
    </form>
  </div>

  <table>
    <tr>
      <th>Student ID</th>
      <th>Full Name</th>
      <th>Course</th>
      <th>Year</th>
      <th>Email</th>
      <th>Contact</th>
      <th>Actions</th>
    </tr>

    <?php if ($total == 0): ?>
      <tr><td colspan="7" class="empty">No students found.</td></tr>
    <?php endif; ?>

    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($row['student_id']) ?></td>
      <td><?= htmlspecialchars($row['full_name']) ?></td>
      <td><span class="badge"><?= htmlspecialchars($row['course']) ?></span></td>
      <td>Year <?= htmlspecialchars($row['year_level']) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= htmlspecialchars($row['contact_number']) ?></td>
      <td>
        <a href="edit_student.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
        <a href="delete_student.php?id=<?= $row['id'] ?>" class="btn btn-delete"
           onclick="return confirm('Delete this student?')">Delete</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>

<?php include 'footer.php'; ?>