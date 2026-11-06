<?php

class User {

    public function __construct(private PDO $db) {}

    public function getAll(): array {
        $stmt = $this->db->query(
            "SELECT id, name, email, created_at FROM users"
        );

        return $stmt->fetchAll();
    }

    public function create(array $data): int {
        $stmt = $this->db->prepare(
            "INSERT INTO users (name, email, password)
             VALUES (?, ?, ?)"
        );

        $stmt->execute([
            $data['name'],
            $data['email'],
            $data['password']
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function getById(int $id): array|false {
        $stmt = $this->db->prepare(
            "SELECT id, name, email, created_at FROM users WHERE id = ?"
        );

        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function update(int $id, array $data): int {
        $stmt = $this->db->prepare(
            "UPDATE users
             SET name = ?, email = ?, password = ?
             WHERE id = ?"
        );

        $stmt->execute([
            $data['name'],
            $data['email'],
            $data['password'],
            $id
        ]);

        return $stmt->rowCount();
    }

    public function delete(int $id): int {
        $stmt = $this->db->prepare(
            "DELETE FROM users WHERE id = ?"
        );

        $stmt->execute([$id]);

        return $stmt->rowCount();
    }
}