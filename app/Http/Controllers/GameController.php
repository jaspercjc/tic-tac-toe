<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class GameController extends Controller
{
    public function index()
    {
        // Render the game view with the current state of the game
        return Inertia::render('Game');
    }

    public function start()
    {
        $game['board'] = array(
            array('X', '-', '-', '-'),
            array('-', 'X', '-', '-'),
            array('-', '-', 'X', '-'),
            array('-', '-', '-', 'X')
        );

        $game['player'] = 'x';
        $game['over'] = false;
        $game['winner'] = null;

        session(['game' => $game]);

        return Redirect::route('game');
    }

    public function move(Request $request)
    {
        $row = $request->input('row');
        $col = $request->input('col');
        $player = $request->input('player');

        // Check if the move is valid
        if ($this->board[$row][$col] == '-') {
            // Update the board with the player's move
            $this->board[$row][$col] = $player;

            // Check if the game has ended
            if ($this->checkWin($player)) {
                // Player has won
                return view('result', ['result' => $player . ' wins!']);
            } else if ($this->checkTie()) {
                // Game has ended in a tie
                return view('result', ['result' => 'Tie game.']);
            } else {
                // Game continues, render the game view with the updated board
                return view('game', ['board' => $this->board]);
            }
        } else {
            // Invalid move, render the game view with an error message
            return view('game', ['board' => $this->board, 'error' => 'Invalid move.']);
        }
    }

    private function checkWin($player)
    {
        // Check rows
        for ($i = 0; $i < 4; $i++) {
            if ($this->board[$i][0] == $player && $this->board[$i][1] == $player &&
                $this->board[$i][2] == $player && $this->board[$i][3] == $player) {
                return true;
            }
        }

        // Check columns
        for ($j = 0; $j < 4; $j++) {
            if ($this->board[0][$j] == $player && $this->board[1][$j] == $player &&
                $this->board[2][$j] == $player && $this->board[3][$j] == $player) {
                return true;
            }
        }

        // Check diagonals
        if ($this->board[0][0] == $player && $this->board[1][1] == $player &&
            $this->board[2][2] == $player && $this->board[3][3] == $player) {
            return true;
        }

        if ($this->board[0][3] == $player && $this->board[1][2] == $player &&
            $this->board[2][1] == $player && $this->board[3][0] == $player) {
            return true;
        }

        return false;
    }

    private function checkTie()
    {
        // Check if there are any empty cells left
        for ($i = 0; $i < 4; $i++) {
        for ($j = 0; $j < 4; $j++) {
            if ($this->board[$i][$j] == '-') {
                return false;
            }
        }
        }

        return true;
    }
}