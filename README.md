# 🔐 API RESTful con Autenticación JWT (PHP Nativo)

![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

Este proyecto implementa un sistema completo de autenticación **stateless** (sin estado) utilizando **PHP nativo** y **JSON Web Tokens (JWT)**.

El objetivo es demostrar cómo proteger rutas de una API RESTful, gestionar sesiones en el cliente mediante `localStorage` y estructurar una aplicación web separando lógica (JS), diseño (CSS) y estructura (HTML).

## 🚀 Características

* **Autenticación JWT Manual:** Generación y validación de tokens JWT (HS256) sin librerías externas para fines educativos.
* **Arquitectura RESTful:** Endpoints separados para Login y recursos protegidos.
* **Seguridad:**
    * Protección contra acceso no autorizado (Redirección automática 403).
    * Validación de firma y expiración del token.
    * Cabeceras HTTP seguras.
* **Interfaz Moderna (Dark UI):** Diseño profesional en modo oscuro (Rojo/Negro) responsivo.
* **Separación de Intereses:** Código modular (`/api`, `/js`, `/css`).

## 📂 Estructura del Proyecto

```text
ApiRestConJWT/
├── 📁 api/
│   ├── 🐘 bienvenido.php  # Endpoint protegido (Valida Token)
│   └── 🐘 login.php       # Endpoint público (Genera Token)
├── 📁 js/
│   ├── 📄 bienvenido.js   # Lógica cliente: verifica sesión y carga datos
│   └── 📄 login.js        # Lógica cliente: fetch al login
├── 🌐 403.html            # Página de error (Acceso Denegado)
├── 🌐 bienvenido.html     # Página protegida (Requiere Auth)
├── 🎨 estilos.css         # Hoja de estilos global (Dark Theme)
└── 🌐 index.html          # Pantalla de Login
