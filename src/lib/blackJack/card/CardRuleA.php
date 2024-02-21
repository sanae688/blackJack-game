<?php

namespace BlackJack\Card;

require_once(__DIR__ . '/ICardRule.php');
require_once(__DIR__ . '/../deck/Deck.php');

use BlackJack\Deck\Deck;

/**
 * カードA（A=1）クラス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
class CardRuleA implements ICardRule
{
    /* @var array カード順位 */
    private const CARD_RANK = [
        'A' => 1,
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,
        '10' => 10,
        'J' => 10,
        'Q' => 10,
        'K' => 10,
    ];

    /**
     * カード順位を取得
     *
     * @return array<string,int> カード順位
     */
    public function getCardRank(): array
    {
        $cardRank = [];
        foreach (Deck::CARD_KIND as $kind) {
            foreach (Deck::CARD_NUMBER as $number) {
                $cardRank[$kind . $number] = self::CARD_RANK[$number];
            }
        }
        return $cardRank;
    }
}
