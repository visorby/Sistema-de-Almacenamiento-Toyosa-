document.addEventListener('DOMContentLoaded', function() {
    const formulario = document.querySelector('form');
    
    if (formulario) {
        formulario.addEventListener('submit', function(e) {
            const ciUsuario = document.getElementById('ci_usuario').value;
            const aliasUsuario = document.getElementById('alias_usuario').value;
            
            // Validar CI (debe ser numérico)
            if (isNaN(ciUsuario) || ciUsuario === '') {
                e.preventDefault();
                alert('El CI debe ser numérico y no puede estar vacío');
                return false;
            }
            
            // Validar alias (mínimo 3 caracteres)
            if (aliasUsuario.length < 3) {
                e.preventDefault();
                alert('El alias debe tener al menos 3 caracteres');
                return false;
            }
            
            // Confirmar antes de actualizar
            if (!confirm('¿Está seguro de que desea actualizar los datos del usuario?')) {
                e.preventDefault();
                return false;
            }
        });
    }
});