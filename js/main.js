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
