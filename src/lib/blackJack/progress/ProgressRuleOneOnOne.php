<?php

namespace BlackJack\Progress;

require_once(__DIR__ . '/IProgressRule.php');
require_once(__DIR__ . '/../participants/IParticipantsRule.php');
require_once(__DIR__ . '/../participants/ParticipantsRuleEvaluator.php');
require_once(__DIR__ . '/../participants/ParticipantsRuleDealer.php');
require_once(__DIR__ . '/../participants/ParticipantsRulePlayerA.php');

use BlackJack\Participants\IParticipantsRule;
use BlackJack\Participants\ParticipantsRuleEvaluator;
use BlackJack\Participants\ParticipantsRuleDealer;
use BlackJack\Participants\ParticipantsRulePlayerA;

/**
 * ディーラー対プレイヤー（1on1）クラス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
class ProgressRuleOneOnOne implements IProgressRule
{
    /* @var array ゲーム参加者 */
    private const GAME_PARTICIPANTS = [
        'プレイヤーA',
        'ディーラー',
    ];

    /* @var sting 負け */
    private const BUST = 'bust';
    /* @var sting 判定 */
    private const JUDGMENT = 'judgment';
    /* @var sting 勝ち */
    private const WIN = 'win';

    /* @var array 結果ステータス */
    private const RESULT_STATUS = [
        self::BUST => 1,
        self::JUDGMENT => 2,
        self::WIN => 3,
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

            if ($gameParticipant === self::GAME_PARTICIPANTS[0] && $this->isBust($judgment[$gameParticipant]['totalRank'])) {
                $judgment[$gameParticipant]['status'] = self::RESULT_STATUS[self::BUST];
                $judgment[self::GAME_PARTICIPANTS[1]]['totalRank'] = array_sum($startHands[self::GAME_PARTICIPANTS[1]]);
                $judgment[self::GAME_PARTICIPANTS[1]]['status'] = self::RESULT_STATUS[self::WIN];
                break;
            } elseif ($gameParticipant === self::GAME_PARTICIPANTS[1] && $this->isBust($judgment[$gameParticipant]['totalRank'])) {
                $judgment[$gameParticipant]['status'] = self::RESULT_STATUS[self::BUST];
                $judgment[self::GAME_PARTICIPANTS[0]]['status'] = self::RESULT_STATUS[self::WIN];
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
