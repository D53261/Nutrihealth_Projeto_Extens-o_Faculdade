<?php
namespace App\Controllers;

use App\Config\Database;
use App\Models\Anotation;
use App\Repositories\AnotationRepository;

class AnotationController {
    private AnotationRepository $repo;

    public function __construct() {
        $db = new Database();
        $this->repo = new AnotationRepository($db->getConnection());
    }

    public function index(): void {
        $anotacoes = $this->repo->all();
        $this->view('anotacoes/list', ['anotacoes' => $anotacoes]);
    }

    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $texto = trim($_POST['texto'] ?? '');
            $user_id = (int)($_POST['user_id'] ?? 0);

            if ($texto === '' || $user_id <= 0) {
                $this->view('anotacoes/create', ['error' => 'Texto e ID do usuário são obrigatórios.', 'old' => compact('texto','user_id')]);
                return;
            }

            if (!$this->userExists($user_id)) {
                $this->view('anotacoes/create', ['error' => 'O usuário informado não existe.', 'old' => compact('texto','user_id')]);
                return;
            }

            $a = new Anotation(null, $texto, $user_id);
            $this->repo->create($a);

            header('Location: /nutrihealth/public/?action=anotacoes_index&msg=success');
            exit;
        }

        $this->view('anotacoes/create');
    }

    public function edit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $anotacao = $this->repo->find($id);

        if (!$anotacao) {
            http_response_code(404);
            echo "Anotação não encontrada.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $texto = trim($_POST['texto'] ?? '');
            if ($texto === '') {
                $this->view('anotacoes/edit', [
                    'error' => 'Texto obrigatório.',
                    'anotacao' => $anotacao
                ]);
                return;
            }

            if (isset($_POST['user_id'])) {
                $new_user_id = (int)$_POST['user_id'];
                if (!$this->userExists($new_user_id)) {
                    $this->view('anotacoes/edit', [
                        'error' => 'O usuário informado não existe.',
                        'anotacao' => $anotacao
                    ]);
                    return;
                }
                $anotacao->user_id = $new_user_id;
            }

            $anotacao->texto = $texto;
            $this->repo->update($anotacao);

            header('Location: /nutrihealth/public/?action=anotacoes_index&msg=success');
            exit;
        }

        $this->view('anotacoes/edit', ['anotacao' => $anotacao]);
    }

    public function delete(): void {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->repo->delete($id);
        }
        header('Location: /nutrihealth/public/?action=anotacoes_index&msg=deleted');
        exit;
    }

    private function view(string $path, array $data = []): void {
        extract($data);
        $base = dirname(__DIR__, 2);
        include $base . "/views/{$path}.php";
    }

    private function userExists(int $user_id): bool {
        $db = new Database();
        $pdo = $db->getConnection();
        $st = $pdo->prepare("SELECT 1 FROM `user` WHERE id = ?");
        $st->execute([$user_id]);
        return (bool)$st->fetchColumn();
    }

}
