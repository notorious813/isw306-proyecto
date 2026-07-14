import express from 'express';
import morgan from 'morgan';
import path from 'path';
import { fileURLToPath } from 'url';
import crypto from 'crypto';

import routerIndex from './routes/indexRouter.js';  // ← cambio aquí
import userRouter from './routes/userRoutes.js';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const app = express();

app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(morgan('dev'));
app.use(express.static(path.join(__dirname, 'public')));

const sessions = new Map();
const loginUser = {
  email: process.env.LOGIN_EMAIL || 'admin@isw306.test',
  password: process.env.LOGIN_PASSWORD || 'Cambiar123!',
  name: 'Administrador'
};

function getCookie(req, name) {
  const cookies = String(req.headers.cookie || '').split(';');
  const cookie = cookies.find((item) => item.trim().startsWith(`${name}=`));
  return cookie ? decodeURIComponent(cookie.trim().slice(name.length + 1)) : null;
}

app.post('/api/login', (req, res) => {
  const email = String(req.body.email || '').trim().toLowerCase();
  const password = String(req.body.password || '');

  if (email !== loginUser.email.toLowerCase() || password !== loginUser.password) {
    return res.status(401).json({ message: 'Correo o contraseña incorrectos.' });
  }

  const sessionId = crypto.randomBytes(32).toString('hex');
  sessions.set(sessionId, {
    user: { email: loginUser.email, name: loginUser.name },
    expiresAt: Date.now() + 8 * 60 * 60 * 1000
  });

  res.cookie('isw_session', sessionId, {
    httpOnly: true,
    sameSite: 'lax',
    secure: process.env.NODE_ENV === 'production',
    maxAge: 8 * 60 * 60 * 1000
  });

  return res.json({ user: sessions.get(sessionId).user });
});

app.get('/api/session', (req, res) => {
  const sessionId = getCookie(req, 'isw_session');
  const session = sessionId ? sessions.get(sessionId) : null;

  if (!session || session.expiresAt <= Date.now()) {
    if (sessionId) sessions.delete(sessionId);
    return res.status(401).json({ message: 'No hay una sesión activa.' });
  }

  return res.json({ user: session.user });
});

app.post('/api/logout', (req, res) => {
  const sessionId = getCookie(req, 'isw_session');
  if (sessionId) sessions.delete(sessionId);
  res.clearCookie('isw_session');
  return res.status(204).end();
});

app.use('/', routerIndex);
app.use('/api', userRouter);

export default app;
