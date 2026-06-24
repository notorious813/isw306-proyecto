'use strict';
export async function up(queryInterface, Sequelize) {
  await queryInterface.createTable('users', {
    id: {
      type: Sequelize.INTEGER,
      autoIncrement: true,
      primaryKey: true,
      allowNull: false,
    },

    firstName: {
      type: Sequelize.STRING(100),
      allowNull: false,
    },

    lastName: {
      type: Sequelize.STRING(100),
      allowNull: false,
    },

    studentId: {
      type: Sequelize.STRING(20),
      allowNull: false,
      unique: true,
    },

    institutionalEmail: {
      type: Sequelize.STRING(150),
      allowNull: false,
      unique: true,
    },

    section: {
      type: Sequelize.STRING(20),
      allowNull: false,
    },

    academicPeriod: {
      type: Sequelize.STRING(20),
      allowNull: false,
    },

    repositoryName: {
      type: Sequelize.STRING(150),
      allowNull: false,
    },

    repositoryUrl: {
      type: Sequelize.STRING(255),
      allowNull: false,
    },

    platform: {
      type: Sequelize.ENUM(
        'github',
        'gitlab',
        'other'
      ),
      allowNull: false,
    },

    isPrivateRepository: {
      type: Sequelize.BOOLEAN,
      defaultValue: false,
    },

    isConfirmed: {
      type: Sequelize.BOOLEAN,
      defaultValue: false,
    },

    createdAt: {
      type: Sequelize.DATE,
      allowNull: false,
    },

    updatedAt: {
      type: Sequelize.DATE,
      allowNull: false,
    },
  });
}

export async function down(queryInterface) {
  await queryInterface.dropTable('users');
}