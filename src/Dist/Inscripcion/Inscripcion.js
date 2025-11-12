document.addEventListener("DOMContentLoaded", async () => {
  const form = document.getElementById("inscriptionForm");
  const careerSelect = document.getElementById("career");

  // ===============================
  // Cargar carreras dinámicamente
  // ===============================
  try {
    const response = await fetch("/carreras"); // 👈 Ajustá si tu endpoint es distinto
    if (!response.ok) throw new Error("Error al cargar carreras");
    const result = await response.json();
    const carreras = Array.isArray(result) ? result : result.data;    
    careerSelect.innerHTML = '<option value="">Selecciona una carrera</option>';
    carreras.forEach((carrera) => {
      const option = document.createElement("option");
      option.value = carrera.id;
      option.textContent = carrera.titulo;
      careerSelect.appendChild(option);
    });
  } catch (error) {
    console.error("Error cargando carreras:", error);
    careerSelect.innerHTML =
      '<option value="">Error al cargar carreras</option>';
  }

  // ===============================
  // Validaciones del formulario
  // ===============================
  function validarFormulario() {
    const email = form.email.value.trim();
    const id_carrera = form.career.value;
    const nombre = form.name.value.trim();
    const apellido = form.lastName.value.trim();
    const dni = form.dni.value.trim();
    const telefono = form.phone.value.trim();
    const fecha = form.birthdate.value;

    // Validación básica de campos vacíos
    if (!email || !id_carrera || !nombre || !apellido || !dni || !telefono || !fecha) {
      alert("Todos los campos son obligatorios.");
      return false;
    }

    // Email válido
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      alert("Ingresá un correo electrónico válido.");
      return false;
    }

    // DNI solo números y entre 7 y 9 dígitos
    if (!/^\d{7,9}$/.test(dni)) {
      alert("El DNI debe contener solo números (7 a 9 dígitos).");
      return false;
    }

    // Teléfono: 8 a 15 dígitos
    if (!/^\d{8,15}$/.test(telefono)) {
      alert("Ingresá un número de teléfono válido (solo dígitos, sin espacios ni símbolos).");
      return false;
    }

    // Fecha de nacimiento: no puede ser futura ni menor a 1900
    const fechaNacimiento = new Date(fecha);
    const hoy = new Date();
    if (fechaNacimiento > hoy || fechaNacimiento.getFullYear() < 1900) {
      alert("Ingresá una fecha de nacimiento válida.");
      return false;
    }

    return true;
  }

  // =====================================
  // Envío del formulario de inscripción
  // =====================================
  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    if (!validarFormulario()) return;

    const submitBtn = form.querySelector("button[type='submit']");
    submitBtn.disabled = true;
    submitBtn.textContent = "Enviando...";

    const payload = {
      email: form.email.value.trim(),
      id_carrera: form.career.value,
      nombre: form.name.value.trim(),
      apellido: form.lastName.value.trim(),
      dni: form.dni.value.trim(),
      telefono: form.phone.value.trim(),
      fecha: form.birthdate.value,
      activo: 1,
    };

    try {
      const res = await fetch("/inscripciones", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload),
      });

      if (!res.ok) throw new Error("Error al enviar el formulario");

      alert("Inscripción enviada con éxito.");
      form.reset();
      // Redirigir después de 2.5 segundos
      setTimeout(() => {
          window.location.href = '/';
      }, 2500);
    } catch (err) {
      console.error(err);
      alert("Ocurrió un error al enviar la inscripción.");
    } finally {
      submitBtn.disabled = false;
      submitBtn.textContent = "ENVIAR FORMULARIO";
    }
  });
});
