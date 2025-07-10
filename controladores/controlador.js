document.addEventListener("DOMContentLoaded", function () {
  const formulario = document.getElementById("formulario");

  formulario.addEventListener("submit", function (event) {
    const nombre = document.getElementById("nombre").value.trim();
    const apellido = document.getElementById("apellido").value.trim();
    const email = document.getElementById("email").value.trim();
    const dni = document.getElementById("dni").value.trim().toUpperCase();

    let errores = [];
    const soloTexto = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const dniRegex = /^\d{8}[A-Z]$/;

    if (!soloTexto.test(nombre)) errores.push("Nombre inválido.");
    if (!soloTexto.test(apellido)) errores.push("Apellido inválido.");
    if (!emailRegex.test(email)) errores.push("Correo electrónico inválido.");

    if (dniRegex.test(dni)) {
      const numero = parseInt(dni.slice(0, 8), 10);
      const letra = dni.slice(8);
      const letrasDNI = "TRWAGMYFPDXBNJZSQVHLCKE";
      const letraCorrecta = letrasDNI[numero % 23];

      if (letra !== letraCorrecta) {
        errores.push(`Letra del DNI incorrecta. Debería ser: ${letraCorrecta}`);
      }
    } else {
      errores.push("Formato de DNI inválido. Usa 8 números seguidos de una letra.");
    }

    if (errores.length > 0) {
      event.preventDefault();
      alert("Errores detectados:\n" + errores.join("\n"));
    }
  });
});
