<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
    <a href="admin_dashboard.php">Admin</a>
<?php endif; ?>

<header class="main-header">
    <div class="logo">
        <a href="index.php">3D Printing Services Brint</a>
    </div>
    <nav>
        <ul class="nav-links">
            <li><a href="index.php#about">O nás</a></li>
            <li><a href="index.php#contact">Kontakt</a></li>
            <li><a href="form.php">Objednávka</a></li>
            <li><a href="calculator.php">Kalkulačka</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if (!empty($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                    <li><a href="admin_dashboard.php">Spravovat</a></li>
                <?php else: ?>
                    <li><a href="account.php">Můj účet</a></li>
                <?php endif; ?>
                <li><a href="logout.php">Odhlásit se</a></li>
            <?php else: ?>
                <li><a href="login.php">Přihlásit se</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<?php if (isset($_SESSION['user_id'])): ?>
    <?php if (!empty($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
        <a href="admin_dashboard.php">Spravovat</a>
    <?php else: ?>
        <a href="account.php">Můj účet</a>
    <?php endif; ?>
<?php else: ?>
    <a href="login.php">Přihlásit se</a>
<?php endif; ?>
