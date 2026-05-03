<?php require_once '../app/Views/layouts/header.php'; ?>

<style>
* { box-sizing: border-box; }
body, html { margin: 0; padding: 0; overflow-x: hidden; }
.main-table { width: 100%; }
.glass-card { margin-bottom: 0.5rem; }
.pagination { display: flex; justify-content: center; gap: 0.3rem; margin-top: 1rem; flex-wrap: wrap; }
.pagination .btn { padding: 0.3rem 0.6rem; }
#sliderPanel { display: none; }
#sliderPanel.open { display: block; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: white; z-index: 1000; overflow-y: auto; }
.close-slider { position: fixed; top: 10px; right: 10px; font-size: 1.5rem; cursor: pointer; z-index: 1001; }
@media (min-width: 768px) {
    #sliderPanel.open { position: static; width: 200px; height: auto; background: var(--surface); border: 1px solid var(--border); }
    .close-slider { display: none; }
}
</style>

<!-- Mobile toggle button -->
<button onclick="toggleSlider()" style="position:fixed;bottom:20px;left:20px;width:50px;height:50px;background:#0b4274;color:white;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.2rem;z-index:999;border:none;box-shadow:0 2px 10px rgba(0,0,0,0.3);">
    <i class="fas fa-bars"></i>
</button>

<div style="display: flex; gap: 0.3rem; padding: 0.5rem;">
    <!-- Slider toggle -->
    <button onclick="toggleSlider()" style="width: 30px; height: 150px; background: #e0e0e0; border: none; border-right: 2px solid #0b4274; cursor: pointer; display: flex; align-items: center; justify-content: center;">
        <i class="fas fa-chevron-right" style="color: #0b4274; font-size: 0.8rem;"></i>
    </button>
    
    <!-- Slider panel -->
    <div id="sliderPanel">
        <span class="close-slider" onclick="toggleSlider()">✕</span>
        <div style="padding: 0.5rem;" class="slider-content">
            <h3 style="margin: 0 0 0.5rem 0; font-size: 0.9rem;"><i class="fas fa-filter"></i> Filtros</h3>
            <form method="GET" action="<?php echo URL_BASE; ?>/admin/usuarios">
                <div style="margin-bottom: 0.5rem;">
                    <label style="font-size: 0.75rem;">Nombre</label><br>
                    <input type="text" name="search" value="<?php echo $data['filters']['search'] ?? ''; ?>" style="width: 100%; padding: 0.3rem;">
                </div>
                <div style="margin-bottom: 0.5rem;">
                    <label style="font-size: 0.75rem;">DNI</label><br>
                    <input type="text" name="dni" value="<?php echo $data['filters']['dni'] ?? ''; ?>" style="width: 100%; padding: 0.3rem;">
                </div>
                <div style="margin-bottom: 0.5rem;">
                    <label style="font-size: 0.75rem;">Email</label><br>
                    <input type="text" name="email" value="<?php echo $data['filters']['email'] ?? ''; ?>" style="width: 100%; padding: 0.3rem;">
                </div>
                <div style="margin-bottom: 0.5rem;">
                    <label style="font-size: 0.75rem;">Rol</label><br>
                    <select name="rol" style="width: 100%; padding: 0.3rem;">
                        <option value="">Todos</option>
                        <?php foreach ($data['roles'] as $rol): ?>
                            <option value="<?php echo $rol['id']; ?>" <?php echo ($data['filters']['rol'] ?? '') == $rol['id'] ? 'selected' : ''; ?>><?php echo $rol['nombre']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Buscar</button>
                <a href="<?php echo URL_BASE; ?>/admin/usuarios" class="btn btn-secondary" style="width: 100%; display: block; text-align: center; margin-top: 0.3rem;">Limpiar</a>
            </form>
        </div>
    </div>
    
    <!-- Main content -->
    <div style="flex: 1;">
        <div class="glass-card" style="padding: 0.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <a href="<?php echo URL_BASE; ?>/admin" class="btn btn-secondary">←</a>
                    <div>
                        <h1 style="font-size: 1.2rem; margin: 0;">Gestión de Usuarios</h1>
                        <p style="font-size: 0.8rem; color: #888; margin: 0;">Administra los usuarios</p>
                    </div>
                </div>
                <a href="<?php echo URL_BASE; ?>/admin/crear" class="btn btn-primary">+ Nuevo</a>
            </div>
        </div>

        <div class="glass-card" style="padding: 0; overflow-x: auto;">
            <table class="usuarios-table" style="width: 100%;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>DNI</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php $n = 1; ?>
                <?php foreach ($data['usuarios'] as $u): ?>
                    <tr>
                        <td><?php echo $n++; ?></td>
                        <td><strong><?php echo $u['nombre'] . ' ' . $u['apellido']; ?></strong></td>
                        <td><?php echo $u['dni'] ?? '-'; ?></td>
                        <td><?php echo $u['email']; ?></td>
                        <td><?php echo $u['rol_nombre']; ?></td>
                        <td><span class="badge <?php echo $u['status'] == 1 ? 'badge-success' : 'badge-danger'; ?>"><?php echo $u['status'] == 1 ? 'Activo' : 'Inactivo'; ?></span></td>
                        <td>
                            <a href="<?php echo URL_BASE; ?>/admin/editar/<?php echo $u['id']; ?>" class="btn btn-secondary" style="padding: 0.2rem 0.5rem;">✏</a>
                            <?php if($u['status'] == 1): ?>
                            <a href="<?php echo URL_BASE; ?>/admin/eliminar/<?php echo $u['id']; ?>" class="btn btn-secondary" style="padding: 0.2rem 0.5rem; color: red;" onclick="return confirm('Desactivar?')">🚫</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php 
        function buildUrl($page, $f) {
            $q = [];
            if(!empty($f['search'])) $q[] = 'search='.urlencode($f['search']);
            if(!empty($f['dni'])) $q[] = 'dni='.urlencode($f['dni']);
            if(!empty($f['email'])) $q[] = 'email='.urlencode($f['email']);
            if(!empty($f['rol'])) $q[] = 'rol='.urlencode($f['rol']);
            $q[] = 'page='.$page;
            return URL_BASE.'/admin/usuarios?'.implode('&',$q);
        }
        ?>

        <div class="pagination">
            <?php if($data['currentPage'] > 1): ?>
                <a href="<?php echo buildUrl($data['currentPage']-1, $data['filters']); ?>" class="btn btn-secondary">←</a>
            <?php endif; ?>
            <?php for($i=1; $i<=$data['totalPages']; $i++): ?>
                <a href="<?php echo buildUrl($i, $data['filters']); ?>" class="btn <?php echo $i==$data['currentPage']?'btn-primary':'btn-secondary'; ?>" style="padding: 0.3rem 0.6rem"><?php echo $i; ?></a>
            <?php endfor; ?>
            <?php if($data['currentPage'] < $data['totalPages']): ?>
                <a href="<?php echo buildUrl($data['currentPage']+1, $data['filters']); ?>" class="btn btn-secondary">→</a>
            <?php endif; ?>
            <span style="margin-left: 0.5rem; font-size: 0.75rem; color: #888;">(<?php echo $data['total']; ?>)</span>
        </div>
    </div>
</div>

<script>
function toggleSlider() {
    var panel = document.getElementById('sliderPanel');
    if (panel.classList.contains('open')) {
        panel.classList.remove('open');
    } else {
        panel.classList.add('open');
    }
}
</script>

<?php require_once '../app/Views/layouts/footer.php'; ?>