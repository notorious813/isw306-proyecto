import config from './config/config.js';
import { sequelize } from './db/db.js';
import app from './app.js';

const port = Number(config.port) || 3000;

async function startServer() {
    try {
        await sequelize.authenticate();
        console.log('Conexión a la base de datos establecida correctamente.');
    } catch (error) {
        console.log('Error al conectar a la base de datos.', error);
    }

    return app.listen(port, () => {
        console.log(`Servidor corriendo en http://localhost:${port}`);
    });
}

if (process.argv[1] && process.argv[1].endsWith('server.js')) {
    startServer().catch((error) => {
        console.error('Error al iniciar el servidor:', error);
    });
}

export { startServer };
export default app;

