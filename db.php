<?php
declare(strict_types=1);

function getDatabase(): PDO
{
    $databaseDirectory = __DIR__ . '/data';
    if (!is_dir($databaseDirectory)) {
        mkdir($databaseDirectory, 0755, true);
    }

    $dbFile = $databaseDirectory . '/app.sqlite';
    $pdo = new PDO('sqlite:' . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    initDatabase($pdo);
    return $pdo;
}

function initDatabase(PDO $pdo): void
{
    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS participants (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre TEXT NOT NULL,
            apellido TEXT NOT NULL,
            matricula TEXT NOT NULL UNIQUE,
            correo TEXT NOT NULL,
            seccion TEXT NOT NULL,
            periodo TEXT NOT NULL,
            repo_nombre TEXT NOT NULL,
            repo_url TEXT NOT NULL,
            plataforma TEXT NOT NULL,
            privado INTEGER NOT NULL DEFAULT 0,
            creado_en TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
        )'
    );
}

function fetchParticipants(PDO $pdo): array
{
    $stmt = $pdo->query('SELECT * FROM participants ORDER BY creado_en DESC');
    return $stmt->fetchAll();
}

function fetchParticipant(PDO $pdo, int $id): ?array
{
    $stmt = $pdo->prepare('SELECT * FROM participants WHERE id = :id LIMIT 1');
    $stmt->execute([':id' => $id]);
    $participant = $stmt->fetch();
    return $participant === false ? null : $participant;
}

function createParticipant(PDO $pdo, array $data): int
{
    $stmt = $pdo->prepare(
        'INSERT INTO participants (
            nombre, apellido, matricula, correo, seccion, periodo,
            repo_nombre, repo_url, plataforma, privado
        ) VALUES (
            :nombre, :apellido, :matricula, :correo, :seccion, :periodo,
            :repo_nombre, :repo_url, :plataforma, :privado
        )'
    );

    $stmt->execute([
        ':nombre' => $data['nombre'],
        ':apellido' => $data['apellido'],
        ':matricula' => $data['matricula'],
        ':correo' => $data['correo'],
        ':seccion' => $data['seccion'],
        ':periodo' => $data['periodo'],
        ':repo_nombre' => $data['repo_nombre'],
        ':repo_url' => $data['repo_url'],
        ':plataforma' => $data['plataforma'],
        ':privado' => $data['privado'],
    ]);

    return (int)$pdo->lastInsertId();
}

function updateParticipant(PDO $pdo, int $id, array $data): bool
{
    $stmt = $pdo->prepare(
        'UPDATE participants SET
            nombre = :nombre,
            apellido = :apellido,
            matricula = :matricula,
            correo = :correo,
            seccion = :seccion,
            periodo = :periodo,
            repo_nombre = :repo_nombre,
            repo_url = :repo_url,
            plataforma = :plataforma,
            privado = :privado
        WHERE id = :id'
    );

    return $stmt->execute([
        ':nombre' => $data['nombre'],
        ':apellido' => $data['apellido'],
        ':matricula' => $data['matricula'],
        ':correo' => $data['correo'],
        ':seccion' => $data['seccion'],
        ':periodo' => $data['periodo'],
        ':repo_nombre' => $data['repo_nombre'],
        ':repo_url' => $data['repo_url'],
        ':plataforma' => $data['plataforma'],
        ':privado' => $data['privado'],
        ':id' => $id,
    ]);
}

function deleteParticipant(PDO $pdo, int $id): bool
{
    $stmt = $pdo->prepare('DELETE FROM participants WHERE id = :id');
    return $stmt->execute([':id' => $id]);
}
