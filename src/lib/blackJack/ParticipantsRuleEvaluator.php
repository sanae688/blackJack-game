<?php

namespace BlackJack;

require_once('ParticipantsRule.php');

/**
 * 参加者ルール判別クラス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
class ParticipantsRuleEvaluator
{
    /**
     * コンストラクタ
     *
     * @param ParticipantsRule $participantsRule 参加者ルール
     */
    public function __construct(private ParticipantsRule $participantsRule)
    {
    }

    /**
     * 初回の手札を取得
     *
     * @param array<string> $gameDeck デッキ
     * @return array<string,int> 初回の手札
     */
    public function getInitHand(array $gameDeck): array
    {
        return $this->participantsRule->getInitHand($gameDeck);
    }

    /**
     * 手札を取得
     *
     * @param array<string> $gameDeck デッキ
     * @param array<string,int> $initHands 初回の手札
     * @return array<string,int> 手札
     */
    public function getHand(array $gameDeck, array $initHands): array
    {
        return $this->participantsRule->getHand($gameDeck, $initHands);
    }
}
