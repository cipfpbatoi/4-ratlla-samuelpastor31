<?php

namespace Joc4enRatlla\Models;

class Board
{
    const FILES = 6;
    const COLUMNS = 7;
    const DIRECTIONS = [
        [0, 1],   // Horizontal derecha
        [1, 0],   // Vertical abajo
        [1, 1],   // Diagonal abajo-derecha
        [1, -1]   // Diagonal abajo-izquierda
    ];

    private array $slots;

    public function __construct()
    {
        $this->slots = self::initializeBoard();
    }

    //methods

    private static function initializeBoard(): array
    {
        $graella =[];
        for ($i = 1; $i <= self::FILES; $i++) {
            for ($j = 1; $j <= self::COLUMNS; $j++) {
                $graella[$i][$j] = 0;  // 0 indica que la celda está vacía
            }
        }
        return $graella;
    }

    public function setMovementOnBoard(int $column, int $player): array
    {
        // Verificamos si el movimiento es válido
        if ($this->isValidMove($column)) {
            // Coloca la ficha en la primera fila vacía de la columna seleccionada
            for ($i = self::FILES; $i >= 1; $i--) {
                if ($this->slots[$i][$column] == 0) {
                    $this->slots[$i][$column] = $player;
                    return $this->slots; // Retorna el tablero actualizado
                }
            }
        }
    
        // Si el movimiento no es válido, retorna el tablero sin cambios
        return $this->slots;
    }
    


    public function checkWin(int $col): bool
    {
        // Encuentra la fila más baja en la que se colocó la ficha en la columna dada
        $row = -1;
        for ($i = 1; $i <= self::FILES; $i++) {
            if ($this->slots[$i][$col] != 0) {
                $row = $i;
                break;
            }
        }

        if ($row == -1) {
            return false; // La columna estaba vacía
        }

        $player = $this->slots[$row][$col];

        foreach (self::DIRECTIONS as $direction) {
            $count = 1;

            // Verifica en ambas direcciones opuestas (positivo y negativo)
            for ($sign = -1; $sign <= 1; $sign += 2) {
                for ($k = 1; $k < 4; $k++) {
                    $newRow = $row + $sign * $direction[0] * $k;
                    $newCol = $col + $sign * $direction[1] * $k;

                    if (
                        $newRow >= 1 && $newRow <= self::FILES &&
                        $newCol >= 1 && $newCol <= self::COLUMNS &&
                        $this->slots[$newRow][$newCol] == $player
                    ) {
                        $count++;
                    } else {
                        break;
                    }
                }
            }

            if ($count >= 4) {
                return true;
            }
        }

        return false;
    }




    public function isValidMove(int $column)
    {
        // Recorremos la columna desde la última fila hacia la primera
        for ($fila = 6; $fila > 0; $fila--) {
            if ($this->slots[$fila][$column] == 0) {
                return true; // Movimiento válido
            }
        }
        return false;  // Si la columna está llena, no se puede hacer el movimiento
    } //bool //Comprova si el moviment és vàlid



    public function isFull(): bool
    { //El tablero esta lleno?
        foreach ($this->slots as $fila) {
            foreach ($fila as $celda) {
                if ($celda == 0) {
                    return false;
                }
            }
        }
        return true;
    }

    // Getters i Setters 

    /**
     * @return array
     */
    public function getSlots(): array
    {
        return $this->slots;
    }

    /**
     * @param array $slots
     */
    public function setSlots(array $slots): void
    {
        $this->slots = $slots;
    }
}
