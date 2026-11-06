<?php

class UserController {

    public function __construct(
        private User $user
    ) {}

    public function index(): void {
        echo json_encode(
            $this->user->getAll()
        );
    }

    public function store(): void {
        $data = $this->getJsonData();

        if ($data === false) {
            http_response_code(400);
            echo json_encode([
                'error' => 'JSON inválido'
            ]);
            return;
        }

        $errors = $this->validate($data);

        if ($errors !== []) {
            http_response_code(400);
            echo json_encode([
                'error' => 'Datos inválidos',
                'detalle' => $errors
            ]);
            return;
        }

        $id = $this->user->create($data);

        http_response_code(201);
        echo json_encode([
            'mensaje' => 'Usuario creado',
            'id' => $id
        ]);
    }

    public function show(int $id): void {
        $user = $this->user->getById($id);

        if (!$user) {
            http_response_code(404);
            echo json_encode([
                'error' => 'Usuario no encontrado'
            ]);
            return;
        }

        echo json_encode($user);
    }

    public function update(int $id): void {
        $data = $this->getJsonData();

        if ($data === false) {
            http_response_code(400);
            echo json_encode([
                'error' => 'JSON inválido'
            ]);
            return;
        }

        $errors = $this->validate($data);

        if ($errors !== []) {
            http_response_code(400);
            echo json_encode([
                'error' => 'Datos inválidos',
                'detalle' => $errors
            ]);
            return;
        }

        $result = $this->user->update($id, $data);

        if ($result === 0) {
            http_response_code(404);
            echo json_encode([
                'error' => 'Usuario no encontrado o sin cambios'
            ]);
            return;
        }

        echo json_encode([
            'mensaje' => 'Usuario actualizado',
            'id' => $id
        ]);
    }

    public function destroy(int $id): void {
        $result = $this->user->delete($id);

        if ($result === 0) {
            http_response_code(404);
            echo json_encode([
                'error' => 'Usuario no encontrado'
            ]);
            return;
        }

        http_response_code(204);
    }

    private function getJsonData(): array|false {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        if (!is_array($data)) {
            return false;
        }

        return $data;
    }

    private function validate(array $data): array {
        $errors = [];

        foreach (['name', 'email', 'password'] as $field) {
            if (!isset($data[$field]) || !is_string($data[$field]) || trim($data[$field]) === '') {
                $errors[] = "El campo $field es obligatorio";
            }
        }

        if (
            isset($data['email'])
            && is_string($data['email'])
            && trim($data['email']) !== ''
            && filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL) === false
        ) {
            $errors[] = 'El campo email debe tener un formato válido';
        }

        return $errors;
    }
}