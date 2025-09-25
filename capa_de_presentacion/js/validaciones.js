document.addEventListener('DOMContentLoaded', function() {
    const formulario = document.querySelector('form');
    
    if (formulario) {
        formulario.addEventListener('submit', function(e) {
            const contrasenia = document.getElementById('contrasenia').value;
            const ciUsuario = document.getElementById('ci_usuario').value;
            const aliasUsuario = document.getElementById('alias_usuario').value;
            const idUsuario = document.getElementById('id_usuario').value;
            
            // Validar contraseña
            if (contrasenia.length < 6) {
                e.preventDefault();
                alert('La contraseña debe tener al menos 6 caracteres');
                return false;
            }
            
            // Validar CI (debe ser numérico)
            if (isNaN(ciUsuario)) {
                e.preventDefault();
                alert('El CI debe ser numérico');
                return false;
            }
            
            // Validar alias (mínimo 3 caracteres)
            if (aliasUsuario.length < 3) {
                e.preventDefault();
                alert('El alias debe tener al menos 3 caracteres');
                return false;
            }
            
            // Validar ID de usuario (no vacío)
            if (idUsuario.trim() === '') {
                e.preventDefault();
                alert('El ID de usuario es obligatorio');
                return false;
            }
        });
    }
    
});