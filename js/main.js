/**
 * ISW-306 · Proyecto Integrador — Etapa 1: Maquetación
 * main.js — Interacciones base del sitio
 *
 * Responsabilidades:
 *  1. Menú hamburguesa (mobile nav)
 *  2. Validación del formulario de registro
 *  3. Resaltar enlace activo en la navegación
 */

'use strict';

/* ============================================================
   1. MENÚ HAMBURGUESA
   ============================================================ */
(function initHamburger() {
  const hamburger = document.querySelector('.hamburger');
  const mobileNav = document.getElementById('mobile-nav');

  if (!hamburger || !mobileNav) return;

  hamburger.addEventListener('click', function () {
    const isOpen = mobileNav.classList.toggle('open');
    hamburger.setAttribute('aria-expanded', String(isOpen));
  });

  /* Cierra el menú si se hace clic fuera de él */
  document.addEventListener('click', function (e) {
    if (!hamburger.contains(e.target) && !mobileNav.contains(e.target)) {
      mobileNav.classList.remove('open');
      hamburger.setAttribute('aria-expanded', 'false');
    }
  });

  /* Cierra el menú al seleccionar un enlace */
  mobileNav.querySelectorAll('.nav-link').forEach(function (link) {
    link.addEventListener('click', function () {
      mobileNav.classList.remove('open');
      hamburger.setAttribute('aria-expanded', 'false');
    });
  });
})();

/* ============================================================
   2. VALIDACIÓN DEL FORMULARIO DE REGISTRO
   ============================================================ */
(function initFormValidation() {
  const form = document.getElementById('registro-form');
  if (!form) return;

  /* Muestra un mensaje de error debajo del campo */
  function mostrarError(fieldId, mensaje) {
    const errorEl = document.getElementById(fieldId + '-error');
    const input   = document.getElementById(fieldId);
    if (errorEl) errorEl.textContent = mensaje;
    if (input)   input.classList.toggle('invalid', mensaje !== '');
  }

  /* Limpia el error de un campo */
  function limpiarError(fieldId) {
    mostrarError(fieldId, '');
  }

  /* Reglas de validación por campo */
  const reglas = {
    nombre: function (val) {
      if (!val.trim()) return 'El nombre es obligatorio.';
      if (val.trim().length < 2) return 'Debe tener al menos 2 caracteres.';
      return '';
    },
    apellido: function (val) {
      if (!val.trim()) return 'El apellido es obligatorio.';
      if (val.trim().length < 2) return 'Debe tener al menos 2 caracteres.';
      return '';
    },
    matricula: function (val) {
      if (!val.trim()) return 'La matrícula es obligatoria.';
      if (!/^\d{4}-\d{4}$/.test(val.trim())) return 'Formato requerido: AAAA-NNNN (ej. 2023-0001).';
      return '';
    },
    correo: function (val) {
      if (!val.trim()) return 'El correo es obligatorio.';
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val.trim())) return 'Ingresa un correo electrónico válido.';
      return '';
    },
    seccion: function (val) {
      if (!val) return 'Selecciona una sección.';
      return '';
    },
    'repo-nombre': function (val) {
      if (!val.trim()) return 'El nombre del repositorio es obligatorio.';
      if (!/^[a-z0-9-]+$/.test(val.trim())) return 'Solo letras minúsculas, números y guiones.';
      return '';
    },
    'repo-url': function (val) {
      if (!val.trim()) return 'La URL del repositorio es obligatoria.';
      try { new URL(val.trim()); } catch (_) { return 'Ingresa una URL válida (ej. https://github.com/...).'; }
      return '';
    },
    'acepta-terminos': function (_, checked) {
      if (!checked) return 'Debes confirmar antes de enviar.';
      return '';
    },
  };

  /* Validación en tiempo real al salir de cada campo */
  Object.keys(reglas).forEach(function (id) {
    const el = document.getElementById(id);
    if (!el) return;

    el.addEventListener('blur', function () {
      const error = reglas[id](el.value, el.checked);
      mostrarError(id, error);
    });

    el.addEventListener('input', function () {
      /* Limpia el error en cuanto el usuario empieza a corregir */
      if (el.classList.contains('invalid')) {
        const error = reglas[id](el.value, el.checked);
        mostrarError(id, error);
      }
    });
  });

  /* Validación completa al enviar */
  form.addEventListener('submit', function (e) {
    e.preventDefault();

    let hayErrores = false;

    Object.keys(reglas).forEach(function (id) {
      const el = document.getElementById(id);
      if (!el) return;
      const error = reglas[id](el.value, el.checked);
      mostrarError(id, error);
      if (error) {
        hayErrores = true;
        /* Enfoca el primer campo con error */
        if (!document.querySelector('.invalid')) el.focus();
      }
    });

    if (!hayErrores) {
      /* Simula envío exitoso */
      const successEl = document.getElementById('form-success');
      if (successEl) {
        successEl.hidden = false;
        successEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      }
      form.reset();
    }
  });

  /* Limpia errores al resetear el formulario */
  form.addEventListener('reset', function () {
    Object.keys(reglas).forEach(function (id) { limpiarError(id); });
    const successEl = document.getElementById('form-success');
    if (successEl) successEl.hidden = true;
  });
})();

/* ============================================================
   3. MARCAR ENLACE ACTIVO SEGÚN URL ACTUAL
   ============================================================ */
(function resaltarEnlaceActivo() {
  const actual = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.nav-link').forEach(function (link) {
    const href = link.getAttribute('href');
    if (!href) return;
    const nombreArchivo = href.split('/').pop().split('#')[0];
    if (nombreArchivo === actual) {
      link.classList.add('active');
      link.setAttribute('aria-current', 'page');
    } else {
      link.classList.remove('active');
      link.removeAttribute('aria-current');
    }
  });
})();

// Obtener elementos
const formulario = document.getElementById("registro-form");
const nombre = document.getElementById("nombre");
const apellido = document.getElementById("apellido");
const matricula = document.getElementById("matricula");
const correo = document.getElementById("correo");
const seccion = document.getElementById("seccion");
const repoNombre = document.getElementById("repo-nombre");
const repoUrl = document.getElementById("repo-url");
const periodo = document.getElementById('periodo');
const privacidad = document.getElementById('privacidad');
const terminos = document.getElementById("acepta-terminos");
const mensajeExito = document.getElementById("form-success");

const botonEnviar = document.querySelector("#registro-form button");

// Validaciones en tiempo real
nombre.addEventListener("input", () => {
    validarLongitud(nombre, "nombre-error", 3);
});

apellido.addEventListener("input", () => {
    validarLongitud(apellido, "apellido-error", 3);
});

correo.addEventListener("input", validarCorreo);

matricula.addEventListener("input", validarMatricula);
repoNombre.addEventListener("input", validarRepositorio);

function validarRepositorio() {
    const error = document.getElementById("repo-nombre-error");

    if (repoNombre.value.trim().length < 3) {
        error.innerHTML = "El repositorio debe tener al menos 3 caracteres";
        return false;
    }

    error.innerHTML = "";
    return true;
}

// Función para longitud mínima
function validarLongitud(campo, errorId, minimo) {
    const error = document.getElementById(errorId);

    if (campo.value.trim().length < minimo) {
        error.innerHTML = `Debe tener al menos ${minimo} caracteres`;
        campo.classList.add("error");
        return false;
    }

    error.innerHTML = "";
    campo.classList.remove("error");
    return true;
}

// Validar correo
function validarCorreo() {
    const error = document.getElementById("correo-error");

    const expresion = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!expresion.test(correo.value)) {
        error.innerHTML = "Correo inválido";
        return false;
    }

    error.innerHTML = "";
    return true;
}

// Validar matrícula
function validarMatricula() {
    const error = document.getElementById("matricula-error");

    const patron = /^\d{4}-\d{4}$/;

    if (!patron.test(matricula.value)) {
        error.innerHTML = "Formato correcto: AAAA-NNNN";
        return false;
    }

    error.innerHTML = "";
    return true;
}

// Enviar formulario
formulario.addEventListener("submit", function (e) {

    e.preventDefault();

    let valido = true;

    if (!validarLongitud(nombre, "nombre-error", 3))
        valido = false;

    if (!validarLongitud(apellido, "apellido-error", 3))
        valido = false;

    if (!validarCorreo())
        valido = false;

    if (!validarMatricula())
        valido = false;

    if (seccion.value === "") {
        document.getElementById("seccion-error").innerHTML =
            "Seleccione una sección";
        valido = false;
    }

    if (!terminos.checked) {
        document.getElementById("terminos-error").innerHTML =
            "Debe aceptar los términos";
        valido = false;
    }

    if (!valido) return;

  const participante = {
  nombre: document.getElementById('nombre').value,
  apellido: document.getElementById('apellido').value,
  matricula: document.getElementById('matricula').value,
  correo: document.getElementById('correo').value,
  seccion: seccion.value,
  periodo: periodo.value,
  repositorio: repoNombre.value,
  url: repoUrl.value,
  plataforma: document.querySelector(
    'input[name="plataforma"]:checked'
  )?.value || '',
  privacidad: privacidad.checked
};

    localStorage.setItem(
        "participante",
        JSON.stringify(participante)
    );

    mensajeExito.hidden = false;

    formulario.reset();
});

window.addEventListener("load", () => {

    const datosGuardados =
        JSON.parse(localStorage.getItem("participante"));

    if (datosGuardados) {

        nombre.value = datosGuardados.nombre || "";
        apellido.value = datosGuardados.apellido || "";
        matricula.value = datosGuardados.matricula || "";
        correo.value = datosGuardados.correo || "";
        repoNombre.value = datosGuardados.repositorio || "";
        repoUrl.value = datosGuardados.url || "";
    }
});

if (periodo)
  periodo.value = datosGuardados.periodo || '';

const plataformaSeleccionada =
  document.querySelector(
    `input[name="plataforma"][value="${datosGuardados.plataforma}"]`
  );

if (plataformaSeleccionada)
  plataformaSeleccionada.checked = true;

if (privacidad)
  privacidad.checked =
    datosGuardados.privacidad || false;
