import { config } from 'dotenv'
import mysql2 from 'mysql2' // Plugin moderno para MySQL 8

// Cargar variables de entorno desde el archivo .env
config({ override: true })



export default {
	host: process.env.DB_HOST,
	portdb: process.env.DB_PORT,
	database: process.env.DB_NAME,
	dialect: process.env.DIALECT,
	user: process.env.DB_USER,
	password: process.env.DB_PASS,

	port: process.env.PORT,
	secret_key: process.env.JWT_SECRET_KEY,

	jwtcookie: process.env.COOKIE,

	// Sequelize use el plugin moderno
	dialectModule: mysql2,
}
