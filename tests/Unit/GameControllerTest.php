<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\GameController;

class GameControllerTest extends TestCase
{
    public function testMove()
    {
        $controller = new GameController();
        $controller->start();

        $request = [
            'row' => 1,
            'col' => 1,
        ];

        $response = $this->call('POST', '/move', $request);

        $response->assertStatus(302);

        $game = session('game');
        $this->assertSame([
                ['-', '-', '-', '-'],
                ['-', 'X', '-', '-'],
                ['-', '-', '-', '-'],
                ['-', '-', '-', '-']
            ], $game['board']
        );
    }

    public function testWin()
    {
        $controller = new GameController();
        $controller->start();

        // Player X makes a winning move
        $controller->move(($this->makeMoveRequest(0, 0))->getRequest());
        $controller->move(($this->makeMoveRequest(1, 0))->getRequest());
        $controller->move(($this->makeMoveRequest(0, 1))->getRequest());
        $controller->move(($this->makeMoveRequest(1, 1))->getRequest());
        $controller->move(($this->makeMoveRequest(0, 2))->getRequest());
        $controller->move(($this->makeMoveRequest(1, 2))->getRequest());
        $controller->move(($this->makeMoveRequest(0, 3))->getRequest());

        // Check if player X has won
        $response = $controller->move(($this->makeMoveRequest(1, 3))->getRequest());
        $this->assertStringContainsString('Player X wins!', session('game')['result']);
    }

    public function testTie()
    {
        $controller = new GameController();
        $controller->start();

        // Play a tie game
        $controller->move(($this->makeMoveRequest(0, 0))->getRequest());
        $controller->move(($this->makeMoveRequest(0, 1))->getRequest());
        $controller->move(($this->makeMoveRequest(0, 2))->getRequest());
        $controller->move(($this->makeMoveRequest(1, 0))->getRequest());
        $controller->move(($this->makeMoveRequest(1, 1))->getRequest());
        $controller->move(($this->makeMoveRequest(1, 2))->getRequest());
        $controller->move(($this->makeMoveRequest(2, 0))->getRequest());
        $controller->move(($this->makeMoveRequest(2, 1))->getRequest());
        $controller->move(($this->makeMoveRequest(2, 2))->getRequest());
        $controller->move(($this->makeMoveRequest(3, 0))->getRequest());
        $controller->move(($this->makeMoveRequest(3, 1))->getRequest());
        $controller->move(($this->makeMoveRequest(3, 2))->getRequest());
        $controller->move(($this->makeMoveRequest(0, 3))->getRequest());
        $controller->move(($this->makeMoveRequest(1, 3))->getRequest());
        $controller->move(($this->makeMoveRequest(2, 3))->getRequest());
        $controller->move(($this->makeMoveRequest(3, 3))->getRequest());

        // Check if the game has ended in a tie
        $this->assertStringContainsString('Tie game.', session('game')['result']);
    }

    public function testSurrender()
    {
        $controller = new GameController();
        $controller->start();

        $controller->move(($this->makeMoveRequest(0, 0))->getRequest());
        $controller->move(($this->makeMoveRequest(0, 1))->getRequest());

        // Player X surrenders
        $this->call('POST', '/surrender');

        // Check if player O has won
        $this->assertStringContainsString('Player O wins!', session('game')['result']);
    }

    private function makeMoveRequest($row, $col)
    {
        $request = [
            'row' => $row,
            'col' => $col,
        ];
    
        return $this->call('POST', '/move', $request);    
    }
}
