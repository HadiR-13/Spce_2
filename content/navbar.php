<header>
    <div class="logo">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
            <circle cx="24" cy="24" r="24" fill="white" />
            <path d="M24 0C24 0 24 24 0 24C23.5776 24.1714 24 48 24 48C24 48 24 24 48 24C24 24 24 0 24 0Z" fill="#0B0D17" />
        </svg>
        <h1>Space</h1>
    </div>
    <?php
        $current_page = basename($_SERVER['SCRIPT_NAME']);
        $role = $_SESSION['role'] ?? null;
    ?>
    <nav>
        <ul class="main-nav">
            <li class="<?= ($current_page == 'index.php') ? 'active' : ''; ?>">
                <a href="./index.php"> HOME </a>
            </li>
            <li class="<?= ($current_page == 'destination.php') ? 'active' : ''; ?>">
                <a href="./destination.php"> DESTINATION </a>
            </li>
            <?php if ($role === 'user'): ?>
                <li class="<?= ($current_page == 'profile.php') ? 'active' : ''; ?>">
                    <a href="./profile.php"> PROFILE </a>
                </li>
            <?php elseif ($role === 'admin'): ?>
                <li class="<?= ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
                    <a href="./dashboard"> DASHBOARD </a>
                </li>
            <?php else: ?>
                <li class="<?= ($current_page == 'login.php') ? 'active' : ''; ?>">
                    <a href="./login.php"> LOGIN </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>