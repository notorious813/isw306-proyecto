<?php
const DATA_FILE = __DIR__ . '/data/participants.json';

function ensureDataPath(): void
{
    if (!is_dir(__DIR__ . '/data')) {
        mkdir(__DIR__ . '/data', 0755, true);
    }

    if (!file_exists(DATA_FILE)) {
        file_put_contents(DATA_FILE, json_encode([]));
    }
}

function loadParticipants(): array
{
    ensureDataPath();
    $content = file_get_contents(DATA_FILE);
    $participants = json_decode($content ?: '[]', true);

    return is_array($participants) ? $participants : [];
}

function saveParticipants(array $participants): bool
{
    ensureDataPath();
    $data = json_encode(array_values($participants), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    return false !== file_put_contents(DATA_FILE, $data, LOCK_EX);
}

function getParticipantById(string $id): ?array
{
    $participants = loadParticipants();

    foreach ($participants as $participant) {
        if (isset($participant['id']) && $participant['id'] === $id) {
            return $participant;
        }
    }

    return null;
}

function addParticipant(array $participant): bool
{
    $participants = loadParticipants();
    $participants[] = $participant;

    return saveParticipants($participants);
}

function updateParticipant(string $id, array $data): bool
{
    $participants = loadParticipants();
    $updated = false;

    foreach ($participants as $index => $participant) {
        if (isset($participant['id']) && $participant['id'] === $id) {
            $participants[$index] = array_merge($participant, $data);
            $updated = true;
            break;
        }
    }

    return $updated ? saveParticipants($participants) : false;
}

function deleteParticipant(string $id): bool
{
    $participants = loadParticipants();
    $filtered = array_filter($participants, static function ($participant) use ($id) {
        return !isset($participant['id']) || $participant['id'] !== $id;
    });

    if (count($filtered) === count($participants)) {
        return false;
    }

    return saveParticipants(array_values($filtered));
}
