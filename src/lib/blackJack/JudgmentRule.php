<?php

namespace BlackJack;

/**
 * 勝敗ルールインターフェイス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
interface JudgmentRule
{
    /**
     * 勝敗判定
     *
     * @param array<mixed> $judgment 勝敗判定
     */
    public function getJudgment(array $judgment): void;
}
