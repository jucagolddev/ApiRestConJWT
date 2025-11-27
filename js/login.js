// js/login.js

document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.getElementById("loginForm");
  const msgDiv = document.getElementById("mensajeError");

  loginForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const user = document.getElementById("username").value;
    const pass = document.getElementById("password").value;

    // Feedback visual inmediato
    msgDiv.textContent = "Verificando credenciales...";
    msgDiv.style.color = "#3498db"; // Azul mientras carga

    try {
      // La ruta es relativa al HTML que carga este script
      const respuesta = await fetch("api/login.php", {
        method: "POST",
        body: JSON.stringify({ username: user, password: pass }),
        headers: { "Content-Type": "application/json" },
      });

      const data = await respuesta.json();

      if (respuesta.ok && data.token) {
        // Guardamos el token
        localStorage.setItem("miTokenSeguro", data.token);
        // Redirigimos
        window.location.href = "bienvenido.html";
      } else {
        // Error de credenciales
        msgDiv.style.color = "#e74c3c"; // Rojo para error
        msgDiv.textContent = data.error || "Credenciales incorrectas";
      }
    } catch (error) {
      console.error(error);
      msgDiv.style.color = "#e74c3c";
      msgDiv.textContent = "Error de conexión con el servidor.";
    }
  });
});
