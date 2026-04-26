<?php require_once '../app/Views/layouts/header.php'; ?>

<div class="glass-card" style="margin-bottom: 0.5rem; padding: 0.3rem;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="text-gradient" style="font-size: 1.1rem;">Control de Asistencia</h1>
            <p style="color: var(--text-muted); font-size: 0.8rem;">Gestiona tu asistencia diaria.</p>
        </div>
        <div style="text-align: right;">
            <p id="live-date" style="font-weight: 600; color: var(--accent);"></p>
            <h2 id="live-clock" style="font-size: 1.4rem; font-weight: 800;">00:00:00</h2>
        </div>
    </div>
</div>

<div class="dashboard-grid">
    <!-- Marcación de Asistencia -->
    <div class="glass-card" style="padding: 0.3rem;">
        <h3 style="margin-bottom: 0.3rem; font-size: 0.9rem;"><i class="fas fa-fingerprint"></i> Registrar hoy</h3>
        
        <div style="text-align: center; padding: 0.2rem 0;">
            <?php if (!$data['asistencia']): ?>
                <div style="margin-bottom: 0.8rem;">
                    <i class="fas fa-sign-in-alt" style="font-size: 4rem; color: var(--secondary); opacity: 0.5;"></i>
                    <p style="margin-top: 0.5rem; color: var(--text-muted); font-size: 0.85rem;">Aún no has registrado tu entrada hoy.</p>
                </div>
                <form action="<?php echo URL_BASE; ?>/worker/registrar" method="POST">
                    <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1.2rem; padding: 1.5rem;">
                        <i class="fas fa-check-circle"></i> MARCAR ENTRADA
                    </button>
                </form>
            <?php elseif ($data['asistencia'] && $data['asistencia']['hora_salida'] == null): ?>
                <div style="margin-bottom: 0.8rem;">
                    <i class="fas fa-clock" style="font-size: 4rem; color: var(--warning); opacity: 0.5;"></i>
                    <p style="margin-top: 0.5rem; font-size: 0.85rem;">Entrada registrada a las: <strong><?php echo $data['asistencia']['hora_entrada']; ?></strong></p>
                    <p style="margin-top: 0.5rem; color: var(--text-muted); font-size: 0.8rem;">Estado: <span class="badge <?php echo $data['asistencia']['estado'] == 'Tarde' ? 'badge-danger' : 'badge-success'; ?>"><?php echo $data['asistencia']['estado']; ?></span></p>
                </div>
                <form action="<?php echo URL_BASE; ?>/worker/registrar" method="POST">
                    <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1.2rem; padding: 1.5rem; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <i class="fas fa-sign-out-alt"></i> MARCAR SALIDA
                    </button>
                </form>
            <?php else: ?>
                <div style="margin-bottom: 0.8rem;">
                    <i class="fas fa-calendar-check" style="font-size: 4rem; color: var(--success); opacity: 0.5;"></i>
                    <h3 style="margin-top: 0.5rem; color: var(--success); font-size: 1rem;">¡Jornada completada!</h3>
                    <p style="margin-top: 0.2rem; color: var(--text-muted); font-size: 0.85rem;">Has registrado entrada y salida correctamente.</p>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="glass-card" style="padding: 1rem; background: rgba(255,255,255,0.05);">
                        <small style="color: var(--text-muted);">Entrada</small>
                        <p><strong><?php echo $data['asistencia']['hora_entrada']; ?></strong></p>
                    </div>
                    <div class="glass-card" style="padding: 1rem; background: rgba(255,255,255,0.05);">
                        <small style="color: var(--text-muted);">Salida</small>
                        <p><strong><?php echo $data['asistencia']['hora_salida']; ?></strong></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Perfil/Info -->
    <div class="glass-card" style="padding: 0.3rem;">
        <h3 style="margin-bottom: 0.3rem; font-size: 0.9rem;"><i class="fas fa-user-circle"></i> Mis Datos</h3>
        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
            <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; font-weight: 800;">
                <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
            </div>
            <div>
                <h2 style="font-size: 1.2rem;"><?php echo $_SESSION['user_name']; ?></h2>
                <p style="color: var(--text-muted); font-size: 0.9rem;"><?php echo ucfirst($_SESSION['user_rol']); ?></p>
            </div>
        </div>
        <div class="glass-card" style="padding: 1rem; background: rgba(56, 189, 248, 0.1); border-color: rgba(56, 189, 248, 0.2);">
            <p style="font-size: 0.9rem;"><i class="fas fa-info-circle"></i> Recuerda marcar tu entrada antes de las <strong>08:15 AM</strong> para evitar el estado "Tarde".</p>
        </div>
    </div>
</div>

<!-- Panel de Historial de Asistencias -->
<div class="glass-card" style="padding: 0.3rem; margin-top: 0.5rem;">
    <h3 style="margin-bottom: 0.5rem; font-size: 0.9rem;"><i class="fas fa-history"></i> Mi Historial de Asistencias</h3>
    
    <div style="display: flex; gap: 0.5rem; align-items: center; margin-bottom: 0.5rem; flex-wrap: wrap;">
        <form action="<?php echo URL_BASE; ?>/worker/historial" method="GET" style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 0.3rem;">
                <label style="font-size: 0.75rem; color: var(--text-muted);">Desde:</label>
                <input type="date" name="fecha_inicio" class="form-control" style="padding: 0.25rem 0.4rem; font-size: 0.75rem; width: 130px;" value="<?php echo $data['fecha_inicio'] ?? ''; ?>">
            </div>
            <div style="display: flex; align-items: center; gap: 0.3rem;">
                <label style="font-size: 0.75rem; color: var(--text-muted);">Hasta:</label>
                <input type="date" name="fecha_fin" class="form-control" style="padding: 0.25rem 0.4rem; font-size: 0.75rem; width: 130px;" value="<?php echo $data['fecha_fin'] ?? ''; ?>">
            </div>
            <button type="submit" class="btn btn-primary" style="padding: 0.25rem 0.6rem; font-size: 0.7rem;">
                <i class="fas fa-search"></i>
            </button>
        </form>
        <a href="<?php echo URL_BASE; ?>/worker" class="btn btn-secondary" style="padding: 0.25rem 0.6rem; font-size: 0.7rem;">
            <i class="fas fa-sync-alt"></i>
        </a>
    </div>

    <div style="overflow-x: auto;">
        <table class="worker-history-table" style="table-layout: fixed;">
            <thead>
                <tr style="height: 35px;">
                    <th style="width: 30%; padding: 0.5rem;">Fecha</th>
                    <th style="width: 22%; padding: 0.5rem;">Entrada</th>
                    <th style="width: 22%; padding: 0.5rem;">Salida</th>
                    <th style="width: 26%; padding: 0.5rem;">Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['recentAttendance'] as $asistencia): ?>
                    <tr style="height: 35px;">
                        <td style="padding: 0.5rem;"><?php echo date('Y/m/d', strtotime($asistencia['fecha'])); ?></td>
                        <td style="padding: 0.5rem;"><strong><?php echo $asistencia['hora_entrada']; ?></strong></td>
                        <td style="padding: 0.5rem;"><?php echo $asistencia['hora_salida'] ?? '<span style="color: var(--text-muted); font-style: italic;">Pendiente</span>'; ?></td>
                        <td style="padding: 0.5rem;">
                            <span class="badge <?php 
                                echo $asistencia['estado'] == 'A tiempo' ? 'badge-success' : ($asistencia['estado'] == 'Tarde' ? 'badge-danger' : 'badge-warning'); 
                            ?>">
                                <?php echo $asistencia['estado']; ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($data['recentAttendance'])): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 1.5rem; color: var(--text-muted);">No hay registros de asistencia.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function updateClock() {
    const now = new Date();
    document.getElementById('live-clock').textContent = now.toLocaleTimeString();
    
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('live-date').textContent = now.toLocaleDateString('es-ES', options);
}
setInterval(updateClock, 1000);
updateClock();

flatpickr(".flatpickr-date", {
    dateFormat: "Y/m/d",
    altInput: true,
    altFormat: "Y/m/d",
    locale: "es",
    allowInput: true
});

function convertDates() {
    var inicio = document.getElementById('fecha_inicio');
    var fin = document.getElementById('fecha_fin');
    if (inicio && inicio.value) {
        inicio.value = inicio.value.replace(/\//g, '-');
    }
    if (fin && fin.value) {
        fin.value = fin.value.replace(/\//g, '-');
    }
}
</script>

<?php require_once '../app/Views/layouts/footer.php'; ?>