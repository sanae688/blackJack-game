<?php

namespace BlackJack\Card;

/**
 * カードルールインターフェイス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
interface ICardRule
{
    /**
     * カード順位を取得
     *
     * @return array<string,int> カード順位
     */
    public function getCardRank(): array;
}
