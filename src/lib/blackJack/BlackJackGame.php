<?php

namespace BlackJack;

use Exception;

require_once('BlackJackDeck.php');
require_once('ProgressRule.php');
require_once('ProgressRuleEvaluator.php');
require_once('BlackJackProgressOneOnOne.php');
require_once('BlackJackProgressOneOnTwo.php');
require_once('BlackJackProgressOneOnThree.php');
require_once('JudgmentRule.php');
require_once('JudgmentRuleEvaluator.php');
require_once('BlackJackJudgmentOneOnOne.php');
require_once('BlackJackJudgmentOneOnTwo.php');
require_once('BlackJackJudgmentOneOnThree.php');

/**
 * ゲームクラス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
class BlackJackGame
{
    /* @var array ゲーム参加人数 */
    private const GAME_PLAYERS = [
        '1',
        '2',
        '3',
    ];

    public function __construct()
    {
        echo 'ブラックジャックを開始します。' . PHP_EOL;
    }

    /**
     * ゲーム実行
     */
    public function gameStart(): void
    {
        try {
            $inputPlayers = '';
            while (in_array($inputPlayers, self::GAME_PLAYERS) === false) {
                echo 'プレイヤーの人数を入力して下さい。最大3人まで選択可能です。（1/2/3）' . PHP_EOL;
                $inputPlayers = trim(fgets(STDIN));
            }

            $deck = new BlackJackDeck();
            $gameDeck = $deck->getDeck();

            $progressRule = $this->getProgressRule($inputPlayers);
            $progressEvaluator = new ProgressRuleEvaluator($progressRule);
            $judgment = $progressEvaluator->actualPerformance($gameDeck);

            $judgmentRule = $this->getJudgmentRule($inputPlayers);
            $judgmentEvaluator = new JudgmentRuleEvaluator($judgmentRule);
            $judgmentEvaluator->getJudgment($judgment);
        } catch (Exception $e) {
            // NOTE：今回エラー発生は想定していないが、練習としてtry-catchを使用したかったため記載
            echo 'エラーが発生しました。再度実行して下さい。：' . $e->getMessage() . PHP_EOL;
        } finally {
            echo 'ブラックジャックを終了します。' . PHP_EOL;
        }
    }

    /**
     * 進行ルールを取得
     *
     * @param string $inputPlayers プレイヤーの人数
     * @return ProgressRule 進行ルールインスタンス
     */
    private function getProgressRule(string $inputPlayers): ProgressRule
    {
        $progressRule = new BlackJackProgressOneOnOne();
        if ($inputPlayers === self::GAME_PLAYERS[1]) {
            $progressRule = new BlackJackProgressOneOnTwo();
        }
        if ($inputPlayers === self::GAME_PLAYERS[2]) {
            $progressRule = new BlackJackProgressOneOnThree();
        }

        return $progressRule;
    }

    /**
     * 勝敗ルールを取得
     *
     * @param string $inputPlayers プレイヤーの人数
     * @return JudgmentRule 勝敗ルールインスタンス
     */
    private function getJudgmentRule(string $inputPlayers): JudgmentRule
    {
        $judgmentRule = new BlackJackJudgmentOneOnOne();
        if ($inputPlayers === self::GAME_PLAYERS[1]) {
            $judgmentRule = new BlackJackJudgmentOneOnTwo();
        }
        if ($inputPlayers === self::GAME_PLAYERS[2]) {
            $judgmentRule = new BlackJackJudgmentOneOnThree();
        }

        return $judgmentRule;
    }
}

$game = new BlackJackGame();
$game->gameStart();
