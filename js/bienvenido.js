// js/bienvenido.js

document.addEventListener("DOMContentLoaded", async () => {
  const token = localStorage.getItem("miTokenSeguro");

  // 1. Verificación preliminar en cliente
  if (!token) {
    window.location.href = "403.html";
    return;
  }

  try {
    // 2. Solicitud a la API protegida
    const respuesta = await fetch("api/bienvenido.php", {
      method: "GET",
      headers: {
        Authorization: "Bearer " + token,
      },
    });

    // 3. Manejo de respuesta
    if (respuesta.status === 403 || respuesta.status === 401) {
      // Token inválido o expirado según el servidor
      window.location.href = "403.html";
    } else {
      const data = await respuesta.json();

      // 4. Renderizado de datos en el DOM
      renderizarDatosUsuario(data);
    }
  } catch (error) {
    console.error("Error al conectar con API:", error);
    window.location.href = "403.html";
  }
});

// Función auxiliar para mantener el código limpio
function renderizarDatosUsuario(data) {
  const nombreUser = document.getElementById("nombreUser");
  const msgSistema = document.getElementById("msgSistema");
  const horaServer = document.getElementById("horaServer");
  const panelUsuario = document.getElementById("panelUsuario");

  if (nombreUser) nombreUser.textContent = data.usuario;
  if (msgSistema) msgSistema.textContent = data.mensaje;
  if (horaServer) horaServer.textContent = data.hora;

  // Mostrar la tarjeta (quitamos el display:none)
  if (panelUsuario) panelUsuario.style.display = "block";
}

// Función global para el botón de cerrar sesión
function logout() {
  localStorage.removeItem("miTokenSeguro");
  window.location.href = "index.html";
}
