        </div> <!-- /.container -->
    </main>

    <!-- Footer -->
    <footer class="footer-custom mt-auto">
        <div class="container">
            <div class="row align-items-center gy-3">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-muted small">
                        &copy; <?= date('Y') ?> <strong><?= APP_NAME ?></strong>. All rights reserved. 
                        Built with <span class="text-danger">&hearts;</span> using PHP 8 & MySQL.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <ul class="list-inline mb-0 small">
                        <li class="list-inline-item"><a href="<?= BASE_URL ?>index.php" class="text-decoration-none text-muted">Home</a></li>
                        <li class="list-inline-item">&bull;</li>
                        <li class="list-inline-item"><a href="<?= BASE_URL ?>users.php" class="text-decoration-none text-muted">Users Directory</a></li>
                        <li class="list-inline-item">&bull;</li>
                        <?php if (is_logged_in()): ?>
                            <li class="list-inline-item"><a href="<?= BASE_URL ?>profile.php" class="text-decoration-none text-muted">My Profile</a></li>
                        <?php else: ?>
                            <li class="list-inline-item"><a href="<?= BASE_URL ?>login.php" class="text-decoration-none text-muted">Sign In</a></li>
                            <li class="list-inline-item">&bull;</li>
                            <li class="list-inline-item"><a href="<?= BASE_URL ?>register.php" class="text-decoration-none text-muted">Register</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 Bundle JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Custom Main JS -->
    <script src="<?= BASE_URL ?>assets/js/main.js"></script>
</body>
</html>
