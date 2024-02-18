<?php

namespace BlackJack;

require_once('CardRule.php');

/**
 * カードB（A=11）クラス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
class BlackJackCardB implements CardRule
{
    /* @var array カード順位 */
    private const CARD_RANK = [
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
        'A' => 11,
    ];

    /**
     * カード順位を取得
     *
     * @param string $card カード
     * @return int カード順位
     */
    public function getCardRank(string $card): int
    {
        return self::CARD_RANK[substr($card, 1, strlen($card) - 1)];
    }
}
