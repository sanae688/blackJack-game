<?php

namespace BlackJack\Deck;

/**
 * デッキ（52枚）クラス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
class Deck
{
    /* @var array カード種別 */
    public const CARD_KIND = [
        'H',
        'S',
        'D',
        'C',
    ];

    /* @var array カード番号 */
    public const CARD_NUMBER = [
        'A',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        'J',
        'Q',
        'K',
    ];

    public function __construct()
    {
        echo 'デッキをシャッフルします。' . PHP_EOL;
    }

    /**
     * デッキを作成及びシャフル
     *
     * @return array<string> ゲームで使用するデッキ
     */
    public function getShuffleDeck(): array
    {
        $gameDeck = [];
        foreach (self::CARD_KIND as $kind) {
            foreach (self::CARD_NUMBER as $number) {
                $gameDeck[] = $kind . $number;
            }
        }

        shuffle($gameDeck);

        return $gameDeck;
    }
}
