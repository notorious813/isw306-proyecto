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
git clone https://github.com/notorious813/isw306-proyecto
cd isw306-proyecto

# 2. Asegurarse de estar en main
git checkout main

# 3. Crear y cambiar a la rama de esta etapa
git checkout -b etapa-1/maquetacion
```

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

- **Nombre:** *Cristopher Diaz Tejada*
- **Matrícula:** *100073686*
- **Sección:** *ISW-306*
- **Repositorio:** *https://github.com/notorious813/isw306-proyecto*

-------------------------------------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------------------------------

# Etapa 3 · Backend y Persistencia de Datos — ISW-306

Sistema de registro y gestión de participantes con **Node.js + Express** y persistencia en **MySQL**.

## 📋 Requisitos Cumplidos

### 1. Entorno de Servidor ✅
- **Lenguaje:** Node.js
- **Framework:** Express.js
- **Procesamiento:** Peticiones HTTP (GET, POST, PUT, DELETE)
- **Validación:** Backend valida campos únicos y requeridos

### 2. Base de Datos ✅
- **Motor:** MySQL / MariaDB (libre)
- **ORM:** Sequelize
- **Operaciones CRUD:** Completas
  - **C**reate: POST `/api/usuarios`
  - **R**ead: GET `/api/usuarios` y GET `/api/usuarios/:id`
  - **U**pdate: PUT `/api/usuarios/:id`
  - **D**elete: DELETE `/api/usuarios/:id`
- **Migraciones:** Sequelize CLI (opcional, incluidas)

### 3. Integración API ✅
- API REST conectada con frontend (Etapa 2)
- Endpoints documentados
- Manejo de errores y validaciones

---

## 🚀 Instalación

### Requisitos Previos
- Node.js 18+
- MySQL 5.7+ o MariaDB
- npm

### Pasos

**1. Clonar y entrar al directorio**
```bash
git clone <url>
cd isw306-proyecto
npm install
```

**2. Configurar variables de entorno**

Fijarse en el archivo .example para ver la estructura del archivo .env
Crea `.env` en la raíz:

Usar migraciones Sequelize:
```bash
npx sequelize-cli db:migrate

usar el script en el archivo package.json

---

## 🔄 Validaciones

**Backend:**
- ✅ Email único (UNIQUE constraint)
- ✅ Matrícula única (UNIQUE constraint)
- ✅ Campos requeridos no nulos
- ✅ Manejo de errores SequelizeUniqueConstraintError

**Frontend:**
- ✅ Validación en tiempo real
- ✅ Validación al enviar
- ✅ Mensajes de error descriptivos

---

## 📊 Scripts Disponibles

```bash
npm start              # Inicia servidor
npm run dev            # Inicia con nodemon
npm run db:migrate     # Ejecuta migraciones
npm run db:seed        # Carga datos iniciales (si existen)
```

## ✅ Checklist de Entrega

- ✅ Código en rama `etapa-3/backend`
- ✅ Script SQL en `/sql/schema.sql`
- ✅ README con instrucciones
- ✅ API REST funcional (CRUD completo)
- ✅ Base de datos persistente
- ✅ Validaciones backend
- ✅ Errores capturados y manejados
- ✅ Mínimo 3 commits en la rama
- ✅ Pull Request hacia `main`

---

## 📚 Tecnologías

- **Runtime:** Node.js 25.9.0
- **Framework:** Express 4.x
- **ORM:** Sequelize 6.x
- **BD:** MySQL 8.x / MariaDB 10.x
- **Validación:** Sequelize validators

## 🎯 Flujo de Datos

**Estado:** ✅ Etapa 3 Completada


## 👤 Autor

- **Nombre:** *JOSE ECHAVARRIA*
- **Matrícula:** *100047768*
- **Sección:** *ISW-306*
- **Repositorio:** *https://github.com/notorious813/isw306-proyecto*