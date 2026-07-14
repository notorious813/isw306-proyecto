# 🚀 ISW-306 · Proyecto Integrador
## Desarrollo de Aplicación Web Profesional

> Proyecto incremental de 4 etapas desarrollado durante el trimestre para la asignatura **ISW-306**.

---

## 📋 Descripción

A lo largo del trimestre se construye de forma incremental una aplicación web funcional. Cada etapa se apoya en la anterior y se entrega en su propia rama Git con un Pull Request abierto hacia `main`.

---

## 🗂️ Estructura del proyecto

```
isw306-proyecto/
├── index.html        # Home / Dashboard principal
├── registro.html     # Formulario de registro de participante
├── css/
│   └── styles.css    # Hoja de estilos externa (colores institucionales)
├── js/
│   └── main.js       # Interacciones: menú, validación de formulario
└── README.md
```

---

## 🎨 Colores institucionales

| Nombre  | Hex       | Uso principal              |
|---------|-----------|----------------------------|
| Navy    | `#0b1838` | Fondo oscuro, header, footer |
| Naranja | `#F68121` | Acentos, botones primarios  |

---

## 🌿 Estructura de ramas

```
main                        ← Código estable y aprobado
└── etapa-1/maquetacion     ← ACTUAL: HTML5 + CSS + Responsive
    etapa-2/interactividad  ← (próxima entrega)
    etapa-3/backend         ← (próxima entrega)
    etapa-4/despliegue      ← (próxima entrega)
```

---

## ✅ Etapa 1 — Maquetación (Actual)

**Propósito:** Establecer la base visual y semántica de la aplicación.

### Requisitos completados

- [x] Página `Home / Dashboard` con etiquetas semánticas HTML5
- [x] Página `Formulario de registro` de datos
- [x] Etiquetas semánticas: `<header>`, `<nav>`, `<main>`, `<aside>`, `<footer>`, `<section>`, `<article>`, `<fieldset>`, `<legend>`
- [x] Archivo CSS externo (`css/styles.css`) con colores institucionales `#0b1838` y `#F68121`
- [x] Diseño responsive mediante **Media Queries**, **Flexbox** y **CSS Grid**
- [x] Sin errores en consola del navegador
- [x] Mínimo 3 commits en rama `etapa-1/maquetacion`

### Criterios de evaluación

| Criterio | Descripción |
|---|---|
| Semántica HTML5 | Uso correcto de etiquetas. Sin abuso de `<div>` |
| Diseño Visual y Responsive | Coherente y adaptable a móvil |
| Sin errores en consola | Cero errores al momento de la entrega |
| Repositorio Git y rama correcta | Rama `etapa-1/maquetacion`, 3+ commits, PR abierto hacia `main` |

---

## ⚙️ Configuración inicial del repositorio

```bash
# 1. Clonar el repositorio
git clone https://github.com/TU_USUARIO/isw306-proyecto.git
cd isw306-proyecto

# 2. Asegurarse de estar en main
git checkout main

# 3. Crear y cambiar a la rama de esta etapa
git checkout -b etapa-1/maquetacion
```

## 🛠️ Backend y autenticación

La entrega final integra un backend PHP con sesiones y un CRUD completo.

- Punto de entrada: `index.php`
- Login: `login.php`
- Panel protegido: `dashboard.php`
- Registro y edición: `registro.php`
- Eliminación: `delete.php`
- Cerrar sesión: `logout.php`

Credenciales de prueba:

- Usuario: `admin`
- Contraseña: `Proyecto2026!`

---

## 📤 Flujo de entrega por etapa

```bash
# Hacer commits frecuentes con mensajes descriptivos
git add .
git commit -m "feat: estructura HTML5 semántica del dashboard"
git commit -m "style: archivo CSS externo con colores institucionales"
git commit -m "style: diseño responsive con media queries y flexbox"

# Publicar la rama
git push origin etapa-1/maquetacion
```

Luego abrir un **Pull Request** desde `etapa-1/maquetacion` → `main` y entregar el enlace del PR en Moodle.

---

## 📝 Formato de commits

```
tipo: descripción breve en presente
```

| Tipo | Cuándo usarlo |
|------|---------------|
| `feat` | Nueva característica o página |
| `style` | Cambios de CSS, colores, tipografía |
| `fix` | Corrección de errores |
| `docs` | Cambios en README u otra documentación |
| `refactor` | Reorganización de código sin cambiar funcionalidad |

---

## 👤 Autor

- **Nombre:** *(completar)*
- **Matrícula:** *(completar)*
- **Sección:** *(completar)*
- **Repositorio:** *(completar URL)*
