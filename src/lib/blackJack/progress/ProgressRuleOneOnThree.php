<?php

namespace BlackJack\Progress;

require_once(__DIR__ . '/IProgressRule.php');
require_once(__DIR__ . '/../participants/IParticipantsRule.php');
require_once(__DIR__ . '/../participants/ParticipantsRuleEvaluator.php');
require_once(__DIR__ . '/../participants/ParticipantsRuleDealer.php');
require_once(__DIR__ . '/../participants/ParticipantsRulePlayerA.php');
require_once(__DIR__ . '/../participants/ParticipantsRulePlayerB.php');
require_once(__DIR__ . '/../participants/ParticipantsRulePlayerC.php');

use BlackJack\Participants\IParticipantsRule;
use BlackJack\Participants\ParticipantsRuleEvaluator;
use BlackJack\Participants\ParticipantsRuleDealer;
use BlackJack\Participants\ParticipantsRulePlayerA;
use BlackJack\Participants\ParticipantsRulePlayerB;
use BlackJack\Participants\ParticipantsRulePlayerC;

/**
 * ディーラー対プレイヤー（1on3）クラス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
class ProgressRuleOneOnThree implements IProgressRule
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
        $startHands = [];
        foreach (self::GAME_PARTICIPANTS as $gameParticipant) {
            $participantsRule = $this->getParticipantsRule($gameParticipant);
            $ruleEvaluator = new ParticipantsRuleEvaluator($participantsRule);
            $startHands[$gameParticipant] = $ruleEvaluator->getStartHands($gameDeck);
            array_splice($gameDeck, 0, count($startHands[$gameParticipant]));
        }

        $judgment  = [];
        foreach (self::GAME_PARTICIPANTS as $gameParticipant) {
            $confirmHands = [];
            $participantsRule = $this->getParticipantsRule($gameParticipant);
            $ruleEvaluator = new ParticipantsRuleEvaluator($participantsRule);
            $confirmHands = $ruleEvaluator->getHands($gameDeck, $startHands[$gameParticipant]);
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
     * @return IParticipantsRule 参加者ルールインスタンス
     */
    private function getParticipantsRule(string $gameParticipant): IParticipantsRule
    {
        $participantsRule = '';
        switch ($gameParticipant) {
            case self::GAME_PARTICIPANTS[0]:
                $participantsRule = new ParticipantsRulePlayerA();
                break;
            case self::GAME_PARTICIPANTS[1]:
                $participantsRule = new ParticipantsRulePlayerB();
                break;
            case self::GAME_PARTICIPANTS[2]:
                $participantsRule = new ParticipantsRulePlayerC();
                break;
            case self::GAME_PARTICIPANTS[3]:
                $participantsRule = new ParticipantsRuleDealer();
                break;
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
