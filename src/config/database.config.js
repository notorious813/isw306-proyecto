const { config } = require('dotenv');
const mysql2 = require('mysql2');

// Cargar variables de entorno
config({ override: true });


module.exports = {
  development: {
    username: process.env.DB_USER,
    password: process.env.DB_PASS,
    database: process.env.DB_NAME,
    host: process.env.DB_HOST,
    port: process.env.DB_PORT,
    dialect: process.env.DIALECT || 'mysql',
    dialectModule: mysql2,
    logging: false
  },
  test: {
    username: process.env.DB_USER,
    password: process.env.DB_PASS,
    database: process.env.DB_NAME_TEST || process.env.DB_NAME,
    host: process.env.DB_HOST,
    port: process.env.DB_PORT,
    dialect: process.env.DIALECT || 'mysql',
    dialectModule: mysql2,
    logging: false
  },
  production: {
    username: process.env.DB_USER,
    password: process.env.DB_PASS,
    database: process.env.DB_NAME,
    host: process.env.DB_HOST,
    port: process.env.DB_PORT,
    dialect: process.env.DIALECT || 'mysql',
    dialectModule: mysql2,
    logging: false,
    pool: {
      max: 20,
      min: 5,
      acquire: 60000,
      idle: 30000
    }
  }
};

module.exports.connectionPool = {
  development: {
    max: 5,
    min: 1,
    acquire: 30000,
    idle: 10000
  },
  test: {
    max: 5,
    min: 1,
    acquire: 30000,
    idle: 10000
  },
  production: {
    max: 20,
    min: 5,
    acquire: 60000,
    idle: 30000
  }
};

