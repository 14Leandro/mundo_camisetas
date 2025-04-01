document.addEventListener("DOMContentLoaded", function() {
    // Comprueba si el hash de la URL es '#modalRegistro'
    if (window.location.hash === "#modalRegistro") {
      var modalRegistroEl = document.getElementById("modalRegistro");
      if (modalRegistroEl) {
        var registroModal = new bootstrap.Modal(modalRegistroEl);
        registroModal.show();
      }
    }
  });

  document.addEventListener("DOMContentLoaded", function() {
    // Auto-apertura para el modal de registro (si fuera necesario)
    if (window.location.hash === "#modalRegistro") {
      var modalRegistroEl = document.getElementById("modalRegistro");
      if (modalRegistroEl) {
        var registroModal = new bootstrap.Modal(modalRegistroEl);
        registroModal.show();
      }
    }
    
    // Auto-apertura para el modal de login si estamos en el hash #modalLogin
    if (window.location.hash === "#modalLogin") {
      var modalLoginEl = document.getElementById("modalLogin");
      if (modalLoginEl) {
        var loginModal = new bootstrap.Modal(modalLoginEl);
        loginModal.show();
      }
    }
  });
  
  