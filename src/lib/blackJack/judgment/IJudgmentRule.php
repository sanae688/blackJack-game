<?php

namespace BlackJack\Judgment;

/**
 * 勝敗ルールインターフェイス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
interface IJudgmentRule
{
    /**
     * 勝敗判定
     *
     * @param array<mixed> $judgment 勝敗判定
     */
    public function showJudgment(array $judgment): void;
}
