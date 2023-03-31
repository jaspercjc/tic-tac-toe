<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class GameController extends Controller
{
    public function index()
    {
        // Render the game view
        return Inertia::render('Game');
    }

    public function start()
    {
        $game['board'] = array(
            array('-', '-', '-', '-'),
            array('-', '-', '-', '-'),
            array('-', '-', '-', '-'),
            array('-', '-', '-', '-')
        );

        $game['player'] = 'X';
        $game['result'] = '';
        $game['error'] = null;

        session(['game' => $game]);

        return Redirect::route('game');
    }

    public function move(Request $request)
    {
        $game = session('game');

        $row = $request->input('row');
        $col = $request->input('col');
        $player = $game['player'];

        // Reset error message
        $game['error'] = null;

        // Check if the move is valid
        if ($game['board'][$row][$col] == '-') {
            // Update the board with the player's move
            $game['board'][$row][$col] = $player;

            // Check if the game has ended
            if ($this->checkWin($player, $game['board'])) {
                // Player has won
                $game['result'] = 'Player ' . $player . ' wins!';
            } else if ($this->checkTie($game['board'])) {
                // Game has ended in a tie
                $game['result'] = 'Tie game.';
            } else {
                // Game continues, render the game view with the updated board
                $game['player'] = $player == 'X' ? 'O' : 'X';
            }
        } else {
            // Invalid move, render the game view with an error message
            $game['error'] = 'Invalid move.';
        }
        session(['game' => $game]);
        return redirect()->back();
    }

    public function surrender()
    {
        $game = session('game');
        $player = $game['player'] == 'X' ? 'O' : 'X';

        $game['result'] = 'Player ' . $player . ' wins!';
        session(['game' => $game]);
        return redirect()->back();
    }

    private function checkWin($player, $board)
    {
        // Check rows
        for ($i = 0; $i < 4; $i++) {
            if ($board[$i][0] == $player && $board[$i][1] == $player &&
                $board[$i][2] == $player && $board[$i][3] == $player) {
                return true;
            }
        }

        // Check columns
        for ($j = 0; $j < 4; $j++) {
            if ($board[0][$j] == $player && $board[1][$j] == $player &&
                $board[2][$j] == $player && $board[3][$j] == $player) {
                return true;
            }
        }

        // Check diagonals
        if ($board[0][0] == $player && $board[1][1] == $player &&
            $board[2][2] == $player && $board[3][3] == $player) {
            return true;
        }

        if ($board[0][3] == $player && $board[1][2] == $player &&
            $board[2][1] == $player && $board[3][0] == $player) {
            return true;
        }

        return false;
    }

    private function checkTie($board)
    {
        // Check if there are any empty cells left
        for ($i = 0; $i < 4; $i++) {
            for ($j = 0; $j < 4; $j++) {
                if ($board[$i][$j] == '-') {
                    return false;
                }
            }
        }

        return true;
    }
}