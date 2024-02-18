<?php

namespace BlackJack;

/**
 * カードルールインターフェイス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
interface CardRule
{
    /**
     * カード順位を取得
     *
     * @param string $card カード
     * @return int カード順位
     */
    public function getCardRank(string $card): int;
}
