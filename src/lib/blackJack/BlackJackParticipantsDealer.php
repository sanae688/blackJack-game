<?php

namespace BlackJack;

require_once('ParticipantsRule.php');
require_once('BlackJackDeck.php');
require_once('CardRule.php');
require_once('CardRuleEvaluator.php');
require_once('BlackJackCardA.php');
require_once('BlackJackCardB.php');

/**
 * ディーラー（CPU）クラス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
class BlackJackParticipantsDealer implements ParticipantsRule
{
    /**
     * 初回の手札を取得
     *
     * @param array<string> $gameDeck デッキ
     * @return array<string,int> 初回の手札
     */
    public function getInitHand(array $gameDeck): array
    {
        $totalRank = 0;
        $initHands = [];
        for ($i = 0; $i <= 1; $i++) {
            if ($i === 0) {
                echo 'ディーラーの引いたカードは' . BlackJackDeck::CARD_KIND_NAME[substr($gameDeck[$i], 0, 1)] . 'の' .
                    substr($gameDeck[$i], 1, strlen($gameDeck[$i]) - 1) . 'です。' . PHP_EOL;
            } elseif ($i === 1) {
                echo 'ディーラーの引いた2枚目のカードはわかりません。' . PHP_EOL;
            }
            $cardRule = $this->getCardRule($totalRank);
            $cardRuleEvaluator = new CardRuleEvaluator($cardRule);
            $initHands[$gameDeck[$i]] = $cardRuleEvaluator->getCardRank($gameDeck[$i]);
            $totalRank = array_sum($initHands);
        }

        return $initHands;
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
        $initHandsKeys = array_keys($initHands);
        echo 'ディーラーの引いた2枚目のカードは' . BlackJackDeck::CARD_KIND_NAME[substr($initHandsKeys[1], 0, 1)] . 'の' .
            substr($initHandsKeys[1], 1, strlen($initHandsKeys[1]) - 1) . 'でした。' . PHP_EOL;

        $totalRank = array_sum($initHands);
        $hands = $initHands;
        $count = 0;
        while ($totalRank <= 17) {
            echo 'ディーラーの現在の得点は' . $totalRank . 'です。' . PHP_EOL;

            $cardRule = $this->getCardRule($totalRank);
            $cardRuleEvaluator = new CardRuleEvaluator($cardRule);
            $hands[$gameDeck[$count]] = $cardRuleEvaluator->getCardRank($gameDeck[$count]);
            $totalRank = array_sum($hands);

            echo 'ディーラーの引いたカードは' . BlackJackDeck::CARD_KIND_NAME[substr($gameDeck[$count], 0, 1)] . 'の' .
                substr($gameDeck[$count], 1, strlen($gameDeck[$count]) - 1) . 'です。' . PHP_EOL;

            $count++;
        }

        return $hands;
    }

    /**
     * カードルールを取得
     *
     * @param int $totalRank 手札の合計値
     * @return CardRule カードルールインスタンス
     */
    private function getCardRule(int $totalRank): CardRule
    {
        $cardRule = new BlackJackCardA();
        if ($totalRank + 11 <= 21) {
            $cardRule = new BlackJackCardB();
        }

        return $cardRule;
    }
}