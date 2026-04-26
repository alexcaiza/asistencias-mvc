<?php require_once '../app/Views/layouts/header.php'; ?>

<div class="login-container">
    <div class="glass-card login-card">
        <div style="text-align: center; margin-bottom: 2rem;">
            <i class="fas fa-clock text-gradient" style="font-size: 3rem; margin-bottom: 1rem;"></i>
            <h1 class="text-gradient">Bienvenido</h1>
            <p style="color: var(--text-muted);">Ingresa tus credenciales para acceder</p>
        </div>

        <?php if (isset($data['error'])): ?>
            <div style="background: rgba(239, 68, 68, 0.1); color: var(--danger); padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem; text-align: center; border: 1px solid rgba(239, 68, 68, 0.2);">
                <?php echo $data['error']; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo URL_BASE; ?>/auth/login" method="POST">
            <div class="form-group">
                <label class="form-label">Correo Electrónico</label>
                <div style="position: relative;">
                    <i class="fas fa-envelope" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                    <input type="email" name="email" class="form-control" placeholder="ejemplo@mail.com" style="padding-left: 2.5rem;" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Contraseña</label>
                <div style="position: relative;">
                    <i class="fas fa-lock" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                    <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" style="padding-left: 2.5rem; padding-right: 2.5rem;" required>
                    <i class="fas fa-eye" id="togglePassword" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); cursor: pointer; transition: color 0.3s;"></i>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                Entrar <i class="fas fa-arrow-right"></i>
            </button>
        </form>
    </div>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function (e) {
        // Alternar el tipo de input
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        // Alternar el icono
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
        
        // Efecto visual de color
        this.style.color = type === 'text' ? 'var(--primary)' : 'var(--text-muted)';
    });
</script>

<?php require_once '../app/Views/layouts/footer.php'; ?>
