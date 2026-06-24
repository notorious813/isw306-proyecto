import { Sequelize } from 'sequelize';
import config from '../config/config.js';
import mysql2 from 'mysql2'; // plugin moderno

// Creamos la conexion a la base de datos
export const sequelize = new Sequelize(config.database, config.user, config.password, {
  host: config.host,
  dialect: config.dialect, /* one of 'mysql' | 'postgres' | 'sqlite' | 'mariadb' | 'mssql' | 'db2' | 'snowflake' | 'oracle' */
  port: config.portdb,
  dialectModule: mysql2, // fuerza el uso de mysql2 para caching_sha2_password
});
