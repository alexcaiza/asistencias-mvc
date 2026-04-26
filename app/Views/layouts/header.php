<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title'] ?? APP_NAME; ?></title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo URL_BASE; ?>/css/style.css">
</head>
<body>
    <?php if (isset($_SESSION['user_id'])): ?>
    <header>
        <div class="container nav">
            <a href="<?php echo URL_BASE; ?>" class="logo">
                <i class="fas fa-clock"></i> <span><?php echo APP_NAME; ?></span>
            </a>
            <div class="user-menu">
                <span style="margin-right: 0.5rem;"><i class="fas fa-user-circle"></i> <?php echo $_SESSION['user_name']; ?></span>
                <a href="<?php echo URL_BASE; ?>/auth/logout" style="color: var(--text-muted); font-size: 1.2rem; text-decoration: none;" title="Cerrar sesión">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
    </header>
    <?php endif; ?>
    <main class="container">
