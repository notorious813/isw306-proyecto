import config from './config/config.js';
import { sequelize } from './db/db.js';
import app from './app.js';


try {
    app.listen(config.port, async () => {
        console.log(`Servidor corriendo en http://localhost:${config.port}`);
        try {
            await sequelize.authenticate();
            console.log('Conexión a la base de datos establecida correctamente.');
        } catch (error) {
            console.log('Error al conectar a la base de datos.', error);
        }

       

    });
} catch (error) {
    console.error('Error al iniciar el servidor:', error);
}

