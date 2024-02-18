<?php

namespace BlackJack;

/**
 * 参加者ルールインターフェイス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
interface ParticipantsRule
{
    /**
     * 初回の手札を取得
     *
     * @param array<string> $gameDeck デッキ
     * @return array<string,int> 初回の手札
     */
    public function getInitHand(array $gameDeck): array;

    /**
     * 手札を取得
     *
     * @param array<string> $gameDeck デッキ
     * @param array<string,int> $initHands 初回の手札
     * @return array<string,int> 手札
     */
    public function getHand(array $gameDeck, array $initHands): array;
}
