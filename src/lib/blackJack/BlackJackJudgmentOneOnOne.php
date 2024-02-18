<?php

namespace BlackJack;

require_once('JudgmentRule.php');

/**
 * 勝敗判定（1on1）クラス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
class BlackJackJudgmentOneOnOne implements JudgmentRule
{
    /* @var array ゲーム参加者 */
    private const GAME_PARTICIPANTS = [
        'プレイヤーA',
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

        if ($this->isPlayerWin($judgment[self::GAME_PARTICIPANTS[0]]['status'], $judgment[self::GAME_PARTICIPANTS[1]]['status'])) {
            echo self::GAME_PARTICIPANTS[0] . 'の勝ちです！' . PHP_EOL;
        } elseif ($this->isDealerWin($judgment[self::GAME_PARTICIPANTS[0]]['status'], $judgment[self::GAME_PARTICIPANTS[1]]['status'])) {
            echo self::GAME_PARTICIPANTS[0] . 'の負けです。' . PHP_EOL;
        } elseif ($this->isPlayerWin($judgment[self::GAME_PARTICIPANTS[0]]['totalRank'], $judgment[self::GAME_PARTICIPANTS[1]]['totalRank'])) {
            echo self::GAME_PARTICIPANTS[0] . 'の勝ちです！' . PHP_EOL;
        } elseif ($this->isDealerWin($judgment[self::GAME_PARTICIPANTS[0]]['totalRank'], $judgment[self::GAME_PARTICIPANTS[1]]['totalRank'])) {
            echo self::GAME_PARTICIPANTS[0] . 'の負けです。' . PHP_EOL;
        } elseif ($this->isDraw($judgment[self::GAME_PARTICIPANTS[0]]['totalRank'], $judgment[self::GAME_PARTICIPANTS[1]]['totalRank'])) {
            echo '引き分けです。' . PHP_EOL;
        }
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
