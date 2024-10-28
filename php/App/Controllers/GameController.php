<?php
namespace Joc4enRatlla\Controllers;

use Joc4enRatlla\Models\Player;
use Joc4enRatlla\Models\Game;

class GameController
{
    private Game $game;

    public function __construct($request = null)
    {
        // Inicialización del juego
        if (isset($request['nombre']) && isset($request['color'])) {
            $player1 = new Player($request['nombre'], $request['color'], false);
            $player2 = new Player("maquina", "Pink", true);
            $this->game = new Game($player1, $player2);
            $this->game->save();
        } else {
            $this->game = Game::restore();
        }

        // Gestionar acciones como reset y exit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($request['reset'])) {
                $this->game->reset();
                $this->game->save();
            } elseif (isset($request['exit'])) {
                $this->endGame();
                return;
            } elseif (isset($request['columna']) && $this->game && $this->game->getWinner() === null) {
                $this->game->play((int)$request['columna']);
                if ($this->game->getWinner() === null) {
                    $this->game->save();
                }
            }
        }

        // Cargar la vista con el estado del juego
        $board = $this->game->getBoard();
        $players = $this->game->getPlayers();
        $winner = $this->game->getWinner();
        $scores = $this->game->getScores();

        loadView('index', compact('board', 'players', 'winner', 'scores'));
    }

    private function endGame(): void
    {
        // Eliminar el juego de la sesión
        unset($_SESSION['game']);
        // Redirigir a la página principal o mostrar un mensaje de fin del juego
        header("Location: /");
        exit();
    }
}
