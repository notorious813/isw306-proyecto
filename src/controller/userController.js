import path from 'path';
import { fileURLToPath } from 'url';
import User from '../models/userModel.js';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

// Página principal
export const indexPage = (req, res) => {
  res.sendFile(path.join(__dirname, '../public/index.html'));
};

// Página de registro
export const registerUser = (req, res) => {
  res.sendFile(path.join(__dirname, '../public/registro.html'));
};

// CREATE
export const createUser = async (req, res) => {
  try {
    const user = await User.create({
      firstName: req.body.nombre,
      lastName: req.body.apellido,
      studentId: req.body.matricula,
      institutionalEmail: req.body.correo,
      section: req.body.seccion,
      academicPeriod: req.body.periodo,
      repositoryName: req.body.repoNombre,
      repositoryUrl: req.body.repoUrl,
      platform: req.body.plataforma,
      isPrivateRepository: req.body.privacidad,
      isConfirmed: req.body.aceptaTerminos
    });

    return res.status(201).json({ success: true, user });

  } catch (error) {
    if (error.name === 'SequelizeUniqueConstraintError') {
      const campo = error.errors[0]?.path;
      if (campo === 'institutionalEmail') {
        return res.status(400).json({ error: 'El correo ya está registrado.' });
      }
      if (campo === 'studentId') {
        return res.status(400).json({ error: 'La matrícula ya está registrada.' });
      }
    }
    res.status(500).json({ error: 'Error interno del servidor.' });
  }
};

// READ - Listar todos
export const getUsers = async (req, res) => {
  try {
    const users = await User.findAll();
    res.json(users);
  } catch (error) {
    res.status(500).json({ error: 'Error al cargar usuarios' });
  }
};

// READ - Obtener uno
export const getUserById = async (req, res) => {
  try {
    const user = await User.findByPk(req.params.id);
    if (!user) return res.status(404).json({ error: 'Usuario no encontrado' });
    res.json(user);
  } catch (error) {
    res.status(500).json({ error: 'Error al cargar' });
  }
};

// UPDATE
export const updateUser = async (req, res) => {
  try {
    const user = await User.findByPk(req.params.id);
    if (!user) return res.status(404).json({ error: 'No encontrado' });
    
    await user.update(req.body);
    res.json({ success: true, user });
  } catch (error) {
    res.status(500).json({ error: 'Error al actualizar' });
  }
};

// DELETE
export const deleteUser = async (req, res) => {
  try {
    const user = await User.findByPk(req.params.id);
    if (!user) return res.status(404).json({ error: 'No encontrado' });
    
    await user.destroy();
    res.json({ success: true, message: 'Eliminado' });
  } catch (error) {
    res.status(500).json({ error: 'Error al eliminar' });
  }
};