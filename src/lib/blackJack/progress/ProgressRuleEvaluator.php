<?php

namespace BlackJack\Progress;

require_once(__DIR__ . '/IProgressRule.php');

/**
 * 進行ルール判別クラス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
class ProgressRuleEvaluator
{
    /**
     * コンストラクタ
     *
     * @param IProgressRule $progressRule 進行ルール
     */
    public function __construct(private IProgressRule $progressRule)
    {
    }

    /**
     * ゲーム本番
     *
     * @param array<string> $gameDeck デッキ
     * @return array<mixed> 勝敗判定
     */
    public function actualPerformance(array $gameDeck): array
    {
        return $this->progressRule->actualPerformance($gameDeck);
    }
}
