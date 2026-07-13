import { config } from 'dotenv'
import mysql2 from 'mysql2' // Plugin moderno para MySQL 8

// Cargar variables de entorno desde el archivo .env
config({ override: true })



export default {
	host: process.env.DB_HOST || 'localhost',
	portdb: Number(process.env.DB_PORT) || 3306,
	database: process.env.DB_NAME || process.env.DB_DATABASE || 'devweb',
	dialect: process.env.DB_DIALECT || process.env.DIALECT || 'mysql',
	user: process.env.DB_USER || process.env.DB_USERNAME || 'root',
	password: process.env.DB_PASS || process.env.DB_PASSWORD || '',

	port: process.env.PORT || 3000,
	secret_key: process.env.JWT_SECRET_KEY,

	jwtcookie: process.env.COOKIE,

	// Sequelize use el plugin moderno
	dialectModule: mysql2,
}
