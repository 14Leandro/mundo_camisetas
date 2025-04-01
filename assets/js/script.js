// Register/Login con cuenta de google

function onSignIn(response) {
    // La respuesta contiene un token de ID de Google
    console.log("Token ID: " + response.credential);
    
    // Enviar este token a tu servidor para verificar la autenticidad y obtener datos del usuario
    fetch('../php/procesar_google_login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ token: response.credential })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Redirecciona según el rol o la condición (usuario/administrador)
            window.location.href = data.url;
        } else {
            alert('Error en la autenticación con Google');
        }
    })
    .catch(error => console.error(error));
}

