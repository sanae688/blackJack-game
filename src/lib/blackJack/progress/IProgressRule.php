<?php

namespace BlackJack\Progress;

/**
 * 進行ルールインターフェイス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
interface IProgressRule
{
    /**
     * ゲーム本番
     *
     * @param array<string> $gameDeck デッキ
     * @return array<mixed> 勝敗判定
     */
    public function actualPerformance(array $gameDeck): array;
}
