<?php

namespace Joc4enRatlla\Models;

use Joc4enRatlla\Models\Board;
use Joc4enRatlla\Models\Player;

class Game
{
    private Board $board;
    private int $nextPlayer;
    private array $players;
    private ?Player $winner;
    private array $scores = [1 => 0, 2 => 0];

    public function __construct(Player $jugador1, Player $jugador2)
    {
        $this->board = new Board();
        $this->players = [1 => $jugador1, 2 => $jugador2];
        $this->nextPlayer = random_int(1, 2);  // Jugador aleatorio inicia
        $this->winner = null;
    }

    public function reset(): void
    {
        $this->board = new Board();
        $this->winner = null;
        $this->nextPlayer = random_int(1, 2); 
        $this->save();
         // Jugador aleatorio inicia tras reiniciar
    }

    public function play(int $columna): void
    {
        $jugadorActual = $this->players[$this->nextPlayer];

        $oldBoard = $this->board->getSlots();

        $newBoard = $this->board->setMovementOnBoard($columna, $this->nextPlayer);

        // Comprobamos si el tablero ha cambiado (se realizó un movimiento)
        if ($newBoard !== $oldBoard) {
            $this->board->setSlots($newBoard);

            if ($this->board->checkWin($columna)) {
                $this->winner = $jugadorActual;
                $this->scores[$this->nextPlayer]++;
            } else {
                // Cambiar turno si no hay ganador
                $this->nextPlayer = $this->nextPlayer === 1 ? 2 : 1;
            }
        }

        if ($this->players[$this->nextPlayer]->getIsAutomatic() && !$this->winner) {
            $this->playAutomatic();
        }
        $this->save();
    }


    public function playAutomatic(): void
    {
        $opponent = $this->nextPlayer === 1 ? 2 : 1;

        // Prioridad 1: Ganar si es posible
        for ($col = 1; $col <= Board::COLUMNS; $col++) {
            if ($this->board->isValidMove($col)) {
                $tempBoard = clone $this->board;
                $tempBoard->setMovementOnBoard($col, $this->nextPlayer);

                if ($tempBoard->checkWin($col)) {
                    $this->play($col);
                    return;
                }
            }
        }

        // Prioridad 2: Bloquear al oponente si está cerca de ganar
        for ($col = 1; $col <= Board::COLUMNS; $col++) {
            if ($this->board->isValidMove($col)) {
                $tempBoard = clone $this->board;
                $tempBoard->setMovementOnBoard($col, $opponent);
                if ($tempBoard->checkWin($col)) {
                    $this->play($col);
                    return;
                }
            }
        }

        // Movimiento aleatorio pero priorizando el centro
        $possibleMoves = array_filter(range(1, Board::COLUMNS), fn($col) => $this->board->isValidMove($col));

        // Selecciona el movimiento más cercano al centro
        $center = (int) (Board::COLUMNS / 2);
        $bestMove = null;
        foreach ($possibleMoves as $move) {
            if ($move === $center) {
                $bestMove = $move;
                break;
            }
        }

        // Si no encontró centro, selecciona uno aleatorio
        $bestMove = $bestMove ?? $possibleMoves[array_rand($possibleMoves)];
        $this->play($bestMove);
    }

    public function save(): void
    {
        $_SESSION['game'] = serialize($this);
    }

    public static function restore(): ?self
    {
        if (isset($_SESSION['game'])) {
            return unserialize($_SESSION['game'], [self::class]);
        }
        return null;
    }

    // Getters y Setters (igual que antes)



    /**
     * @return Board
     */
    public function getBoard(): Board
    {
        return $this->board;
    }

    /**
     * @param Board $board
     */
    public function setBoard(Board $board): void
    {
        $this->board = $board;
    }

    /**
     * @return int
     */
    public function getNextPlayer(): int
    {
        return $this->nextPlayer;
    }

    /**
     * @param int $nextPlayer
     */
    public function setNextPlayer(int $nextPlayer): void
    {
        $this->nextPlayer = $nextPlayer;
    }

    /**
     * @return array
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * @param array $players
     */
    public function setPlayers(array $players): void
    {
        $this->players = $players;
    }

    /**
     * @return ?Player
     */
    public function getWinner(): ?Player
    {
        return $this->winner;
    }

    /**
     * @param Player $winner
     */
    public function setWinner(Player $winner): void
    {
        $this->winner = $winner;
    }

    /**
     * @return array
     */
    public function getScores(): array
    {
        return $this->scores;
    }

    /**
     * @param array $scores
     */
    public function setScores(array $scores): void
    {
        $this->scores = $scores;
    }
}
