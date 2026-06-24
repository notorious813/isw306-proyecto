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

  function mostrarError(fieldId, mensaje) {
  let errorId = fieldId + '-error';

  if (fieldId === 'acepta-terminos') {
    errorId = 'terminos-error';
  }

  const errorEl = document.getElementById(errorId);
  const input = document.getElementById(fieldId);

  if (errorEl) errorEl.textContent = mensaje;
  if (input) input.classList.toggle('invalid', mensaje !== '');
}

  function limpiarError(fieldId) {
    mostrarError(fieldId, '');
  }

  const reglas = {
    nombre(val) {
      if (!val.trim()) return 'El nombre es obligatorio.';
      if (val.trim().length < 2) return 'Debe tener al menos 2 caracteres.';
      return '';
    },

    apellido(val) {
      if (!val.trim()) return 'El apellido es obligatorio.';
      if (val.trim().length < 2) return 'Debe tener al menos 2 caracteres.';
      return '';
    },

    matricula(val) {
      if (!val.trim()) return 'La matrícula es obligatoria.';
      if (!/^\d{4}-\d{4}$/.test(val.trim())) {
        return 'Formato requerido: AAAA-NNNN (ej. 2023-0001).';
      }
      return '';
    },

    correo(val) {
      if (!val.trim()) return 'El correo es obligatorio.';
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val.trim())) {
        return 'Ingresa un correo electrónico válido.';
      }
      return '';
    },

    seccion(val) {
      if (!val) return 'Selecciona una sección.';
      return '';
    },

    'repo-url'(val) {
  if (!val.trim()) {
    return 'La URL del repositorio es obligatoria.';
  }

  const url = val.trim();

  if (!/^(https?:\/\/)?(www\.)?[a-z0-9-]+\.[a-z]{2,}/i.test(url)) {
    return 'Ingresa una URL válida.';
  }

  return '';
},

    

    'acepta-terminos'(_, checked) {
      if (!checked) return 'Debes confirmar antes de enviar.';
      return '';
    }
  };

  Object.keys(reglas).forEach((id) => {
    const el = document.getElementById(id);

    if (!el) return;

    el.addEventListener('blur', () => {
      const error = reglas[id](el.value, el.checked);
      mostrarError(id, error);
    });

    el.addEventListener('input', () => {
      const error = reglas[id](el.value, el.checked);
      mostrarError(id, error);
    });
  });

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    let hayErrores = false;

    Object.keys(reglas).forEach((id) => {
      const el = document.getElementById(id);

      if (!el) return;

      const error = reglas[id](el.value, el.checked);

      mostrarError(id, error);

      if (error) {
        hayErrores = true;
      }
    });

    if (hayErrores) {
      return;
    }

    const plataformaSeleccionada = document.querySelector(
      'input[name="plataforma"]:checked'
    );

    const data = {
      nombre: document.getElementById('nombre').value.trim(),
      apellido: document.getElementById('apellido').value.trim(),
      matricula: document.getElementById('matricula').value.trim(),
      correo: document.getElementById('correo').value.trim(),
      seccion: document.getElementById('seccion').value,
      periodo: document.getElementById('periodo').value,
      repoNombre: document.getElementById('repo-nombre').value.trim(),
      repoUrl: document.getElementById('repo-url').value.trim(),
      plataforma: plataformaSeleccionada
        ? plataformaSeleccionada.value
        : 'github',
      privacidad: document.getElementById('privacidad').checked,
      aceptaTerminos: document.getElementById('acepta-terminos').checked
    };

    console.log('DATOS ENVIADOS:', data);

    try {
      const response = await fetch('/api/usuarios', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify(data)
});

const result = await response.json();

if (!response.ok) {
  throw new Error(
    result.error ||
    result.message ||
    'Error al registrar'
  );
}

const successEl = document.getElementById('form-success');

if (successEl) {
  successEl.hidden = false;
}

await Swal.fire({
  icon: 'success',
  title: '¡Registro completado!',
  text: 'Tus datos han sido registrados correctamente.',
  timer: 2500,
  showConfirmButton: false
});

form.reset();
    } catch (error) {
  console.error(error);

  Swal.fire({
    icon: 'error',
    title: 'Error',
    text: error.message,
    confirmButtonText: 'Aceptar'
  });
}
  });

  form.addEventListener('reset', () => {
    Object.keys(reglas).forEach((id) => limpiarError(id));

    const successEl = document.getElementById('form-success');

    if (successEl) {
      successEl.hidden = true;
    }
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
  /* ============================================================
   4. CARGAR USUARIOS Y ACCIONES (CRUD)
   ============================================================ */
(function cargarUsuarios() {
  const contenedor = document.getElementById('usuarios-tabla');
  if (!contenedor) return;

  async function obtenerUsuarios() {
    try {
      const response = await fetch('/api/usuarios');
      const users = await response.json();
      
      if (!Array.isArray(users) || users.length === 0) {
        contenedor.innerHTML = '<p>No hay usuarios registrados.</p>';
        return;
      }

      let html = `
        <table style="width:100%; border-collapse: collapse;">
          <thead style="background: #f5f6fa;">
            <tr>
              <th style="padding: 10px; text-align: left; border: 1px solid #e2e6f0;">Nombre</th>
              <th style="padding: 10px; text-align: left; border: 1px solid #e2e6f0;">Matrícula</th>
              <th style="padding: 10px; text-align: left; border: 1px solid #e2e6f0;">Email</th>
              <th style="padding: 10px; text-align: center; border: 1px solid #e2e6f0;">Acciones</th>
            </tr>
          </thead>
          <tbody>
      `;

      users.forEach(user => {
        html += `
          <tr>
            <td style="padding: 10px; border: 1px solid #e2e6f0;">${user.firstName} ${user.lastName}</td>
            <td style="padding: 10px; border: 1px solid #e2e6f0;">${user.studentId}</td>
            <td style="padding: 10px; border: 1px solid #e2e6f0;">${user.institutionalEmail}</td>
            <td style="padding: 10px; border: 1px solid #e2e6f0; text-align: center;">
              <button onclick="editarUsuario(${user.id})" style="padding: 5px 10px; margin: 2px; background: #F68121; color: white; border: none; border-radius: 4px; cursor: pointer;">Editar</button>
              <button onclick="eliminarUsuario(${user.id})" style="padding: 5px 10px; margin: 2px; background: #dc2626; color: white; border: none; border-radius: 4px; cursor: pointer;">Eliminar</button>
            </td>
          </tr>
        `;
      });

      html += '</tbody></table>';
      contenedor.innerHTML = html;
    } catch (error) {
      contenedor.innerHTML = `<p style="color: #dc2626;">Error al cargar usuarios: ${error.message}</p>`;
    }
  }

  window.editarUsuario = async function(id) {
  try {
    const response = await fetch(`/api/usuarios/${id}`);
    const user = await response.json();

    const { value: formValues } = await Swal.fire({
      title: 'Editar Participante',
      html: `
        <div style="text-align: left;">
          <div style="margin-bottom: 15px;">
            <label style="font-weight: 600; display: block; margin-bottom: 5px;">Nombre</label>
            <input type="text" id="firstName" value="${user.firstName}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;">
          </div>
          <div style="margin-bottom: 15px;">
            <label style="font-weight: 600; display: block; margin-bottom: 5px;">Apellido</label>
            <input type="text" id="lastName" value="${user.lastName}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;">
          </div>
          <div style="margin-bottom: 15px;">
            <label style="font-weight: 600; display: block; margin-bottom: 5px;">Email Institucional</label>
            <input type="email" id="institutionalEmail" value="${user.institutionalEmail}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;">
          </div>
          <div style="margin-bottom: 15px;">
            <label style="font-weight: 600; display: block; margin-bottom: 5px;">URL Repositorio</label>
            <input type="url" id="repositoryUrl" value="${user.repositoryUrl}" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px;">
          </div>
        </div>
      `,
      focusConfirm: false,
      showCancelButton: true,
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Guardar Cambios',
      confirmButtonColor: '#F68121',
      cancelButtonColor: '#6b7280',
      preConfirm: () => {
        return {
          firstName: document.getElementById('firstName').value,
          lastName: document.getElementById('lastName').value,
          institutionalEmail: document.getElementById('institutionalEmail').value,
          repositoryUrl: document.getElementById('repositoryUrl').value
        };
      }
    });

    if (!formValues) return;

    const respuesta = await fetch(`/api/usuarios/${id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(formValues)
    });

    const result = await respuesta.json();

    if (respuesta.ok) {
      Swal.fire({
        icon: 'success',
        title: '¡Actualizado!',
        text: 'Los datos del participante se han actualizado correctamente.',
        confirmButtonColor: '#F68121',
        timer: 2000,
        showConfirmButton: false
      });
      obtenerUsuarios();
    } else {
      throw new Error(result.error);
    }
  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: error.message,
      confirmButtonColor: '#F68121'
    });
  }
};

  window.eliminarUsuario = async function(id) {
  Swal.fire({
    title: '¿Eliminar participante?',
    text: 'Esta acción no se puede deshacer.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#dc2626',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then(async (result) => {
    if (!result.isConfirmed) return;

    try {
      const response = await fetch(`/api/usuarios/${id}`, { method: 'DELETE' });
      const resultado = await response.json();
      
      if (response.ok) {
        Swal.fire({
          icon: 'success',
          title: '¡Eliminado!',
          text: 'El participante ha sido eliminado correctamente.',
          confirmButtonColor: '#F68121',
          timer: 1500,
          showConfirmButton: false
        });
        obtenerUsuarios();
      } else {
        throw new Error(resultado.error);
      }
    } catch (error) {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: error.message,
        confirmButtonColor: '#F68121'
      });
    }
  });
};
  obtenerUsuarios();
})();
})




();

