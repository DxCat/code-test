<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Distribute cards to players equally.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function distribute(Request $request): JsonResponse
    {
        // Ensure the input value is given, must be an integer and is greater than 0
        $request->validate([
            'people_count' => 'required|integer|min:1',
        ], [
            'people_count.required' => 'Input value does not exist or value is invalid',
            'people_count.integer' => 'Input value does not exist or value is invalid',
            'people_count.min' => 'Input value does not exist or value is invalid',
        ]);

        $peopleCount = $request->input('people_count');
        $deck = $this->generateDeck();
        shuffle($deck);

        $currentPerson = 0;
        $distributed = array_fill(0, $peopleCount, []); // Set an array for each person

        // When the person count is more than the number of cards,
        // some people will not get any cards and their array will be empty
        foreach ($deck as $card) {
            // Assign the card to the current person
            $distributed[$currentPerson][] = $card;

            // Move to the next person
            $currentPerson++;

            // If the current person exceeds the number of people, reset to the first person
            if ($currentPerson >= $peopleCount) {
                $currentPerson = 0;
            }
        }

        return response()->json($distributed);
    }

    /**
     * Generate a deck of cards.
     *
     * @return array
     */
    private function generateDeck(): array
    {
        /**
         * Suits: C (Clubs), D (Diamonds), H (Hearts), S (Spades)
         * Numbered cards: 2-9 as is, 10 as X
         * Face cards: A (Ace), J (Jack), Q (Queen), K (King)
         *
         * Output example: C-2 means 2 of Clubs
         */
        $suits = ['C', 'D', 'H', 'S'];
        $ranks = ['A', '2', '3', '4', '5', '6', '7', '8', '9', 'X', 'J', 'Q', 'K'];
        $deck = [];

        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $deck[] = "{$suit}-{$rank}";
            }
        }

        return $deck;
    }
}
