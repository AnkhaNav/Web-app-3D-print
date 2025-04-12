<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
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
                <li><a href="account.php">Můj účet</a></li>
                <li><a href="logout.php">Odhlásit se</a></li>
            <?php else: ?>
                <li><a href="login.php">Přihlásit se</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>