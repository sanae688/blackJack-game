<?php

namespace BlackJack\Card;

require_once(__DIR__ . '/ICardRule.php');

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
     * @param ICardRule $cardRule カードルール
     */
    public function __construct(private ICardRule $cardRule)
    {
    }

    /**
     * カード順位を取得
     *
     * @return array<string,int> カード順位
     */
    public function getCardRank(): array
    {
        return $this->cardRule->getCardRank();
    }
}
