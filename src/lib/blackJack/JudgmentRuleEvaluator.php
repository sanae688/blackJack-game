<?php

namespace BlackJack;

require_once('JudgmentRule.php');

/**
 * 勝敗ルール判別クラス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
class JudgmentRuleEvaluator
{
    /**
     * コンストラクタ
     *
     * @param JudgmentRule $judgmentRule 勝敗ルール
     */
    public function __construct(private JudgmentRule $judgmentRule)
    {
    }

    /**
     * 勝敗判定
     *
     * @param array<mixed> $judgment 勝敗判定
     */
    public function getJudgment(array $judgment): void
    {
        $this->judgmentRule->getJudgment($judgment);
    }
}
