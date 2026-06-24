import { DataTypes } from 'sequelize';
import { sequelize } from '../db/db.js';

const User = sequelize.define(
  'User',
  {
    id: {
      type: DataTypes.INTEGER,
      autoIncrement: true,
      primaryKey: true,
    },

    firstName: {
      type: DataTypes.STRING(100),
      allowNull: false,
    },

    lastName: {
      type: DataTypes.STRING(100),
      allowNull: false,
    },

    studentId: {
      type: DataTypes.STRING(20),
      allowNull: false,
      unique: true,
    },

    institutionalEmail: {
      type: DataTypes.STRING(150),
      allowNull: false,
      unique: true,
      validate: {
        isEmail: true,
      },
    },

    section: {
      type: DataTypes.STRING(20),
      allowNull: false,
    },

    academicPeriod: {
      type: DataTypes.STRING(20),
      allowNull: false,
    },

    repositoryName: {
      type: DataTypes.STRING(150),
      allowNull: false,
    },

    repositoryUrl: {
      type: DataTypes.STRING(255),
      allowNull: false,
      validate: {
        isUrl: true,
      },
    },

    platform: {
      type: DataTypes.ENUM('github', 'gitlab', 'other'),
      allowNull: false,
    },

    isPrivateRepository: {
      type: DataTypes.BOOLEAN,
      defaultValue: false,
    },

    isConfirmed: {
      type: DataTypes.BOOLEAN,
      defaultValue: false,
    },
  },
  {
    tableName: 'users',
    timestamps: true,
  }
);

export default User;