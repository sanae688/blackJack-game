<?php

namespace BlackJack;

require_once('ProgressRule.php');
require_once('ParticipantsRule.php');
require_once('ParticipantsRuleEvaluator.php');
require_once('BlackJackParticipantsDealer.php');
require_once('BlackJackParticipantsPlayerA.php');
require_once('BlackJackParticipantsPlayerB.php');
require_once('BlackJackParticipantsPlayerC.php');

/**
 * ディーラー対プレイヤー（1on3）クラス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
class BlackJackProgressOneOnThree implements ProgressRule
{
    /* @var array ゲーム参加者 */
    private const GAME_PARTICIPANTS = [
        'プレイヤーA',
        'プレイヤーB',
        'プレイヤーC',
        'ディーラー',
    ];

    /* @var sting 負け */
    private const BUST = 'bust';
    /* @var sting 判定 */
    private const JUDGMENT = 'judgment';

    /* @var array 結果ステータス */
    private const RESULT_STATUS = [
        self::BUST => 1,
        self::JUDGMENT => 2,
    ];

    /**
     * ゲーム本番
     *
     * @param array<string> $gameDeck デッキ
     * @return array<mixed> 勝敗判定
     */
    public function actualPerformance(array $gameDeck): array
    {
        $initHands = [];
        foreach (self::GAME_PARTICIPANTS as $gameParticipant) {
            $participantsRule = $this->getParticipantsRule($gameParticipant);
            $ruleEvaluator = new ParticipantsRuleEvaluator($participantsRule);
            $initHands[$gameParticipant] = $ruleEvaluator->getInitHand($gameDeck);
            array_splice($gameDeck, 0, count($initHands[$gameParticipant]));
        }

        $judgment  = [];
        foreach (self::GAME_PARTICIPANTS as $gameParticipant) {
            $confirmHands = [];
            $participantsRule = $this->getParticipantsRule($gameParticipant);
            $ruleEvaluator = new ParticipantsRuleEvaluator($participantsRule);
            $confirmHands = $ruleEvaluator->getHand($gameDeck, $initHands[$gameParticipant]);
            array_splice($gameDeck, 0, count($confirmHands) - 2);
            $judgment[$gameParticipant]['totalRank'] = array_sum($confirmHands);

            if ($gameParticipant !== self::GAME_PARTICIPANTS[3] && $this->isBust($judgment[$gameParticipant]['totalRank'])) {
                $judgment[$gameParticipant]['status'] = self::RESULT_STATUS[self::BUST];
                continue;
            } elseif ($gameParticipant === self::GAME_PARTICIPANTS[3] && $this->isBust($judgment[$gameParticipant]['totalRank'])) {
                $judgment[$gameParticipant]['status'] = self::RESULT_STATUS[self::BUST];
                break;
            }

            $judgment[$gameParticipant]['status'] = self::RESULT_STATUS[self::JUDGMENT];
        }

        return $judgment;
    }

    /**
     * 参加者ルールを取得
     *
     * @param string $gameParticipant ゲーム参加者
     * @return ParticipantsRule 参加者ルールインスタンス
     */
    private function getParticipantsRule(string $gameParticipant): ParticipantsRule
    {
        $participantsRule = new BlackJackParticipantsPlayerA();
        if ($gameParticipant === self::GAME_PARTICIPANTS[1]) {
            $participantsRule = new BlackJackParticipantsPlayerB();
        } elseif ($gameParticipant === self::GAME_PARTICIPANTS[2]) {
            $participantsRule = new BlackJackParticipantsPlayerC();
        } elseif ($gameParticipant === self::GAME_PARTICIPANTS[3]) {
            $participantsRule = new BlackJackParticipantsDealer();
        }

        return $participantsRule;
    }

    /**
     * 失格判定
     *
     * @param int $totalRank 手札の合計値
     * @return bool 判定結果
     */
    private function isBust(int $totalRank): bool
    {
        return $totalRank > 21;
    }
}
