<?php

namespace BlackJack;

require_once('JudgmentRule.php');

/**
 * 勝敗判定（1on2）クラス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
class BlackJackJudgmentOneOnTwo implements JudgmentRule
{
    /* @var array ゲーム参加者 */
    private const GAME_PARTICIPANTS = [
        'プレイヤーA',
        'プレイヤーB',
        'ディーラー',
    ];

    /**
     * 勝敗判定
     *
     * @param array<mixed> $judgment 勝敗判定
     */
    public function getJudgment(array $judgment): void
    {
        foreach (self::GAME_PARTICIPANTS as $gameParticipant) {
            echo $gameParticipant . 'の得点は' . $judgment[$gameParticipant]['totalRank'] . 'です。' . PHP_EOL;
        }

        for ($i = 0; $i <= 1; $i++) {
            if ($this->isPlayerBust($judgment[self::GAME_PARTICIPANTS[$i]]['status'])) {
                echo self::GAME_PARTICIPANTS[$i] . 'の負けです。' . PHP_EOL;
            } elseif ($this->isPlayerWin($judgment[self::GAME_PARTICIPANTS[$i]]['status'], $judgment[self::GAME_PARTICIPANTS[2]]['status'])) {
                echo self::GAME_PARTICIPANTS[$i] . 'の勝ちです！' . PHP_EOL;
            } elseif ($this->isPlayerWin($judgment[self::GAME_PARTICIPANTS[$i]]['totalRank'], $judgment[self::GAME_PARTICIPANTS[2]]['totalRank'])) {
                echo self::GAME_PARTICIPANTS[$i] . 'の勝ちです！' . PHP_EOL;
            } elseif ($this->isDealerWin($judgment[self::GAME_PARTICIPANTS[$i]]['totalRank'], $judgment[self::GAME_PARTICIPANTS[2]]['totalRank'])) {
                echo self::GAME_PARTICIPANTS[$i] . 'の負けです。' . PHP_EOL;
            } elseif ($this->isDraw($judgment[self::GAME_PARTICIPANTS[$i]]['totalRank'], $judgment[self::GAME_PARTICIPANTS[2]]['totalRank'])) {
                echo '引き分けです。' . PHP_EOL;
            }
        }
    }

    /**
     * 勝敗判定（プレイヤー負け）
     *
     * @param int $playerNumber プレイヤーの値
     * @return bool 判定結果
     */
    private function isPlayerBust(int $playerNumber): bool
    {
        return $playerNumber === 1;
    }

    /**
     * 勝敗判定（プレイヤー勝ち）
     *
     * @param int $playerNumber プレイヤーの値
     * @param int $dealerNumber ディーラーの値
     * @return bool 判定結果
     */
    private function isPlayerWin(int $playerNumber, int $dealerNumber): bool
    {
        return $playerNumber > $dealerNumber;
    }

    /**
     * 勝敗判定（ディーラー勝ち）
     *
     * @param int $playerNumber プレイヤーの値
     * @param int $dealerNumber ディーラーの値
     * @return bool 判定結果
     */
    private function isDealerWin(int $playerNumber, int $dealerNumber): bool
    {
        return $playerNumber < $dealerNumber;
    }

    /**
     * 勝敗判定（引き分け）
     *
     * @param int $playerNumber プレイヤーの値
     * @param int $dealerNumber ディーラーの値
     * @return bool 判定結果
     */
    private function isDraw(int $playerNumber, int $dealerNumber): bool
    {
        return $playerNumber === $dealerNumber;
    }
}
