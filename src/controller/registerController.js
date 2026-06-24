import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

// Página principal
export const indexPage = (req, res) => {
  res.sendFile(path.join(__dirname, '../public/index.html'));
};

// Página de registro
export const registerUser = (req, res) => {
  res.sendFile(path.join(__dirname, '../public/registro.html'));
};
