<?php

namespace BlackJack\Judgment;

require_once(__DIR__ . '/IJudgmentRule.php');

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
     * @param IJudgmentRule $judgmentRule 勝敗ルール
     */
    public function __construct(private IJudgmentRule $judgmentRule)
    {
    }

    /**
     * 勝敗判定
     *
     * @param array<mixed> $judgment 勝敗判定
     */
    public function showJudgment(array $judgment): void
    {
        $this->judgmentRule->showJudgment($judgment);
    }
}
