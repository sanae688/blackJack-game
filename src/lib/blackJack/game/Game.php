<?php

namespace BlackJack\Game;

require_once(__DIR__ . '/../deck/Deck.php');
require_once(__DIR__ . '/../progress/IProgressRule.php');
require_once(__DIR__ . '/../progress/ProgressRuleEvaluator.php');
require_once(__DIR__ . '/../progress/ProgressRuleOneOnOne.php');
require_once(__DIR__ . '/../progress/ProgressRuleOneOnTwo.php');
require_once(__DIR__ . '/../progress/ProgressRuleOneOnThree.php');
require_once(__DIR__ . '/../judgment/IJudgmentRule.php');
require_once(__DIR__ . '/../judgment/JudgmentRuleEvaluator.php');
require_once(__DIR__ . '/../judgment/JudgmentRuleOneOnOne.php');
require_once(__DIR__ . '/../judgment/JudgmentRuleOneOnTwo.php');
require_once(__DIR__ . '/../judgment/JudgmentRuleOneOnThree.php');

use Exception;
use BlackJack\Deck\Deck;
use BlackJack\Progress\IProgressRule;
use BlackJack\Progress\ProgressRuleEvaluator;
use BlackJack\Progress\ProgressRuleOneOnOne;
use BlackJack\Progress\ProgressRuleOneOnTwo;
use BlackJack\Progress\ProgressRuleOneOnThree;
use BlackJack\Judgment\IJudgmentRule;
use BlackJack\Judgment\JudgmentRuleEvaluator;
use BlackJack\Judgment\JudgmentRuleOneOnOne;
use BlackJack\Judgment\JudgmentRuleOneOnTwo;
use BlackJack\Judgment\JudgmentRuleOneOnThree;

/**
 * ゲームクラス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
class Game
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
            while (!in_array($inputPlayers, self::GAME_PLAYERS)) {
                echo 'プレイヤーの人数を入力して下さい。最大3人まで選択可能です。（1/2/3）' . PHP_EOL;
                $inputPlayers = trim(fgets(STDIN));
            }

            // デッキを作成及びシャフル
            $deck = new Deck();
            $gameDeck = $deck->getShuffleDeck();

            // プレイヤーの人数に従ってゲームを進行
            $progressRule = $this->getProgressRule($inputPlayers);
            $progressEvaluator = new ProgressRuleEvaluator($progressRule);
            $judgment = $progressEvaluator->actualPerformance($gameDeck);

            // プレイヤーの人数に従ってゲームの勝敗判定
            $judgmentRule = $this->getJudgmentRule($inputPlayers);
            $judgmentEvaluator = new JudgmentRuleEvaluator($judgmentRule);
            $judgmentEvaluator->showJudgment($judgment);
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
     * @return IProgressRule 進行ルールインスタンス
     */
    private function getProgressRule(string $inputPlayers): IProgressRule
    {
        $progressRule = '';
        switch ($inputPlayers) {
            case self::GAME_PLAYERS[0]:
                $progressRule = new ProgressRuleOneOnOne();
                break;
            case self::GAME_PLAYERS[1]:
                $progressRule = new ProgressRuleOneOnTwo();
                break;
            case self::GAME_PLAYERS[2]:
                $progressRule = new ProgressRuleOneOnThree();
                break;
        }

        return $progressRule;
    }

    /**
     * 勝敗ルールを取得
     *
     * @param string $inputPlayers プレイヤーの人数
     * @return IJudgmentRule 勝敗ルールインスタンス
     */
    private function getJudgmentRule(string $inputPlayers): IJudgmentRule
    {
        $judgmentRule = '';
        switch ($inputPlayers) {
            case self::GAME_PLAYERS[0]:
                $judgmentRule = new JudgmentRuleOneOnOne();
                break;
            case self::GAME_PLAYERS[1]:
                $judgmentRule = new JudgmentRuleOneOnTwo();
                break;
            case self::GAME_PLAYERS[2]:
                $judgmentRule = new JudgmentRuleOneOnThree();
                break;
        }

        return $judgmentRule;
    }
}

$game = new Game();
$game->gameStart();
