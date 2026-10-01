</div>
<footer class="footer">
  © <?= date('Y') ?> Student Management System
</footer>
<script>
  // Hide success message after 3 seconds
  setTimeout(function () {
    var a = document.querySelector('.alert');
    if (a) a.style.display = 'none';
  }, 3000);
</script>
</body>
</html>