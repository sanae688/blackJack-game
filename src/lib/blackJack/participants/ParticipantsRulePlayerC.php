<?php

namespace BlackJack\Participants;

require_once(__DIR__ . '/IParticipantsRule.php');
require_once(__DIR__ . '/../card/ICardRule.php');
require_once(__DIR__ . '/../card/CardRuleEvaluator.php');
require_once(__DIR__ . '/../card/CardRuleA.php');
require_once(__DIR__ . '/../card/CardRuleB.php');
require_once(__DIR__ . '/../card/CardName.php');

use BlackJack\Card\ICardRule;
use BlackJack\Card\CardRuleEvaluator;
use BlackJack\Card\CardRuleA;
use BlackJack\Card\CardRuleB;
use BlackJack\Card\CardName;

/**
 * プレイヤーC（CPU）クラス
 *
 * @author naito
 * @version ver1.0.0 2024/02/12
 */
class ParticipantsRulePlayerC implements IParticipantsRule
{
    /**
     * 初回の手札を取得
     *
     * @param array<string> $gameDeck デッキ
     * @return array<string,int> 初回の手札
     */
    public function getStartHands(array $gameDeck): array
    {
        $totalRank = 0;
        $dealCards = [$gameDeck[0], $gameDeck[1]];
        $startHands = [];
        $cardName = new CardName();
        $cardShowName = $cardName->getCardName();
        foreach ($dealCards as $dealCard) {
            echo 'プレイヤーCの引いたカードは' . $cardShowName[$dealCard] . 'です。' . PHP_EOL;
            $cardRule = $this->getCardRule($totalRank);
            $cardRuleEvaluator = new CardRuleEvaluator($cardRule);
            $cardRank = $cardRuleEvaluator->getCardRank();
            $startHands[$dealCard] = $cardRank[$dealCard];
            $totalRank = array_sum($startHands);
        }

        return $startHands;
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
        $totalRank = array_sum($startHands);
        $hands = $startHands;
        $count = 0;
        $cardName = new CardName();
        $cardShowName = $cardName->getCardName();
        while ($totalRank <= 17) {
            echo 'プレイヤーCの現在の得点は' . $totalRank . 'です。' . PHP_EOL;

            $cardRule = $this->getCardRule($totalRank);
            $cardRuleEvaluator = new CardRuleEvaluator($cardRule);
            $cardRank = $cardRuleEvaluator->getCardRank();
            $hands[$gameDeck[$count]] = $cardRank[$gameDeck[$count]];
            $totalRank = array_sum($hands);

            echo 'プレイヤーCの引いたカードは' . $cardShowName[$gameDeck[$count]] . PHP_EOL;

            $count++;
        }

        return $hands;
    }

    /**
     * カードルールを取得
     *
     * @param int $totalRank 手札の合計値
     * @return ICardRule カードルールインスタンス
     */
    private function getCardRule(int $totalRank): ICardRule
    {
        $cardRule = new CardRuleA();
        if ($totalRank + 11 <= 21) {
            $cardRule = new CardRuleB();
        }

        return $cardRule;
    }
}
