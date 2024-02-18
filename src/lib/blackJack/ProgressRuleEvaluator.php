<?php

namespace BlackJack;

require_once('ProgressRule.php');

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
     * @param ProgressRule $progressRule 進行ルール
     */
    public function __construct(private ProgressRule $progressRule)
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
