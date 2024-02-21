<?php

namespace BlackJack\Participants;

require_once(__DIR__ . '/IParticipantsRule.php');

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
     * @param IParticipantsRule $participantsRule 参加者ルール
     */
    public function __construct(private IParticipantsRule $participantsRule)
    {
    }

    /**
     * 初回の手札を取得
     *
     * @param array<string> $gameDeck デッキ
     * @return array<string,int> 初回の手札
     */
    public function getStartHands(array $gameDeck): array
    {
        return $this->participantsRule->getStartHands($gameDeck);
    }

    /**
     * 手札を取得
     *
     * @param array<string> $gameDeck デッキ
     * @param array<string,int> $startHands 初回の手札
     * @return array<string,int> 手札
     */
    public function getHands(array $gameDeck, array $startHands): array
    {
        return $this->participantsRule->getHands($gameDeck, $startHands);
    }
}
