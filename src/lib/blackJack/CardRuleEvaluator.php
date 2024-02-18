<?php

namespace BlackJack;

require_once('CardRule.php');

/**
 * カードルール判別クラス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
class CardRuleEvaluator
{
    /**
     * コンストラクタ
     *
     * @param CardRule $cardRule カードルール
     */
    public function __construct(private CardRule $cardRule)
    {
    }

    /**
     * カード順位を取得
     *
     * @param string $card カード
     * @return int カード順位
     */
    public function getCardRank(string $card): int
    {
        return $this->cardRule->getCardRank($card);
    }
}
