<?php

namespace App\Models;

use PDO;

abstract class BaseModel
{
    protected static ?PDO $pdo = null;
    protected string $table = '';

    public function __construct()
    {
        if (self::$pdo === null) {
            require_once __DIR__ . '/../../config/config.php';
            self::$pdo = new PDO($dsn, $DB_USER, $DB_PASS, $pdo_options);
        }
    }

    public function all(): array
    {
        $stmt = self::$pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = self::$pdo->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function insert(array $data): bool
    {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        $stmt = self::$pdo->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");
        return $stmt->execute(array_values($data));
    }

    public function update(int $id, array $data): bool
    {
        $set = implode(', ', array_map(fn($k) => "$k = ?", array_keys($data)));
        $values = array_values($data);
        $values[] = $id;
        $stmt = self::$pdo->prepare("UPDATE {$this->table} SET $set WHERE id = ?");
        return $stmt->execute($values);
    }

    public function delete(int $id): bool
    {
        $stmt = self::$pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function lastInsertId(): string
    {
        return self::$pdo->lastInsertId();
    }
}