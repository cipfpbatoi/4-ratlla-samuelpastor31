<?php
use PHPUnit\Framework\TestCase;
use Joc4enRatlla\Models\Board;

class BoardTest extends TestCase {
    private $board;

    protected function setUp(): void {
        $this->board = new Board();
    }

    public function testInitializeBoard(): void {
        $this->assertIsArray($this->board->getSlots());
        $this->assertEquals(count($this->board->getSlots()), Board::FILES);
    }

    public function testSetMovementOnBoard(): void {
        $this->board->setMovementOnBoard(3, 1);
        $this->assertEquals(1, $this->board->getSlots()[6][3]);
    }

    public function testCheckWin(): void {
        $this->board->setMovementOnBoard(1, 1);
        $this->board->setMovementOnBoard(2, 1);
        $this->board->setMovementOnBoard(3, 1);
        $this->board->setMovementOnBoard(4, 1);
        $this->assertTrue($this->board->checkWin(1));
    }

    public function testIsValidMove(): void {
        $this->assertTrue($this->board->isValidMove(3));
        for ($i = 0; $i < Board::FILES; $i++) {
            $this->board->setMovementOnBoard(3, 1);
        }
        $this->assertFalse($this->board->isValidMove(3));
    }

    public function testIsFull(): void {
        $this->assertFalse($this->board->isFull());
        for ($col = 1; $col <= Board::COLUMNS; $col++) {
            for ($row = 1; $row <= Board::FILES; $row++) {
                $this->board->setMovementOnBoard($col, 1);
            }
        }
        $this->assertTrue($this->board->isFull());
    }
}