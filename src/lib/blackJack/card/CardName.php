<?php

namespace BlackJack\Card;

require_once(__DIR__ . '/../deck/Deck.php');

use BlackJack\Deck\Deck;

/**
 * カード名称クラス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
class CardName
{
    /* @var array カード種別名 */
    public const CARD_KIND_NAME = [
        Deck::CARD_KIND[0] => 'ハート',
        Deck::CARD_KIND[1] => 'スペード',
        Deck::CARD_KIND[2] => 'ダイヤ',
        Deck::CARD_KIND[3] => 'クラブ',
    ];

    /**
     * カード名称を取得
     *
     * @return array<string,string> カード名称
     */
    public function getCardName(): array
    {
        $cardName = [];
        foreach (Deck::CARD_KIND as $kind) {
            foreach (Deck::CARD_NUMBER as $number) {
                $cardName[$kind . $number] = self::CARD_KIND_NAME[$kind] . 'の' . $number;
            }
        }
        return $cardName;
    }
}
