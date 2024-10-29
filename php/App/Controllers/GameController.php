<?php
namespace Joc4enRatlla\Controllers;

use Joc4enRatlla\Models\Player;
use Joc4enRatlla\Models\Game;
use Joc4enRatlla\Services\Logger; // Use the custom Logger service

class GameController
{
    private Game $game;
    private $logger;

    public function __construct($request = null)
    {
        // Initialize Logger
        $this->logger = Logger::getLogger();

        // Initialize the game
        if (isset($request['nombre']) && isset($request['color'])) {
            $player1 = new Player($request['nombre'], $request['color'], false);
            $player2 = new Player("maquina", "Red", true);
            $this->game = new Game($player1, $player2);
            $this->game->save();

            // Log the new game initialization
            $this->logger->info("New game initialized", [
                'player1' => $player1->getName(),
                'player2' => $player2->getName(),
            ]);
        } else {
            $this->game = Game::restore();

            // Log game restoration
            $this->logger->info("Game restored from session");
        }

        // Manage actions like reset and exit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($request['reset'])) {
                $this->game->reset();
                $this->logger->info("Game reset by the player");

            } elseif (isset($request['exit'])) {
                $this->endGame();
                return;

            } elseif (isset($request['columna']) && $this->game && $this->game->getWinner() === null) {
                try {
                    $column = (int)$request['columna'];
                    $this->game->play($column);

                    // Log player move
                    $currentPlayer = $this->game->getPlayers()[$this->game->getNextPlayer()];
                    $this->logger->info("Player made a move", [
                        'player' => $currentPlayer->getName(),
                        'column' => $column,
                    ]);
                } catch (\Exception $e) {
                    // Log any errors during play
                    $this->logger->error("Error during gameplay", [
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }

        // Load the view with the game state
        $board = $this->game->getBoard();
        $players = $this->game->getPlayers();
        $winner = $this->game->getWinner();
        $scores = $this->game->getScores();

        loadView('index', compact('board', 'players', 'winner', 'scores'));
    }

    private function endGame(): void
    {
        // Log the game end
        $this->logger->info("Game ended");

        // Remove the game from the session
        unset($_SESSION['game']);
        
        // Redirect to the main page or show a game end message
        header("Location: /");
        exit();
    }
}
