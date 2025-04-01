document.addEventListener('DOMContentLoaded', function () {
  // 1. Verificar el hash para abrir el modal correspondiente
  const hash = window.location.hash;
  if (hash === '#modalRegistro') {
    const modalRegistroEl = document.getElementById('modalRegistro');
    if (modalRegistroEl) {
      const registroModal = new bootstrap.Modal(modalRegistroEl);
      registroModal.show();
    }
  } else if (hash === '#modalLogin') {
    const modalLoginEl = document.getElementById('modalLogin');
    if (modalLoginEl) {
      const loginModal = new bootstrap.Modal(modalLoginEl);
      loginModal.show();
    }
  }

  // 2. Limpiar el hash inmediatamente para evitar que quede en la URL
  if (hash === '#modalRegistro' || hash === '#modalLogin') {
    history.replaceState(null, '', window.location.pathname + window.location.search);
  }

  // 3. Listener global que se activa cuando se cierra cualquier modal
  document.addEventListener('hidden.bs.modal', function () {
    // Esperamos 300 ms para que Bootstrap finalice sus animaciones de cierre
    setTimeout(function () {
      // Eliminar el hash por si acaso queda
      history.replaceState(null, '', window.location.pathname + window.location.search);

      // Quitar la clase que bloquea el scroll y cualquier estilo inline que impida la interacción
      document.body.classList.remove('modal-open');
      document.body.style.overflow = 'auto';
      if (document.body.hasAttribute('style')) {
        document.body.removeAttribute('style');
      }

      // Forzar la eliminación de cualquier backdrop residual
      while (document.getElementsByClassName('modal-backdrop').length > 0) {
        document.getElementsByClassName('modal-backdrop')[0].parentNode.removeChild(
          document.getElementsByClassName('modal-backdrop')[0]
        );
      }

      // Forzar al navegador a recalcular el layout
      window.dispatchEvent(new Event('resize'));
    }, 300);
  });
});
