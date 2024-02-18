# ブラックジャックゲーム

## ルール

1. ディーラーとプレイヤーで対戦するコンソールゲーム
    - プレイヤーは最大3人まで選択可能(ただし、ディーラーとプレイヤーの2人目以降はCPU実行とする)
2. 基本的なルールのみで作成
    - 1〜13までの数が書かれた52枚のカードを使用
    - 実行開始時、ディーラーとプレイヤー全員に2枚ずつカードが配られる
    - 自分のカードの合計値が21に近づくよう、カードを追加するか、追加しないかを決める
    - カードの合計値が21を超えてしまった時点で、その場で負けが確定する
    - プレイヤーはカードの合計値が21を超えない限り、好きなだけカードを追加できる
    - ディーラーとプレイヤーの2人目以降はカードの合計値が17を超えるまでカードを追加する
    - 各カードの点数は以下の通り
      - 2〜9までは書かれている数の通りの点数
      - 10,J,Q,Kは10点
      - Aは1点あるいは11点として、カードの合計値が21以内で最大となる方で数える
    - 「ダブルダウン、スプリット、サレンダー」などの特殊ルールは現時点では未対応

## ゲーム実行方法

1. Docker コンテナの準備

```bash
# Docker コンテナの生成
docker compose build

# Docker コンテナの起動
docker compose up -d

# Docker コンテナの停止(ゲーム実行が終了した場合のみ)
docker compose stop
```

2. ターミナル上で下記コマンドを実行

```bash
# ゲーム開始
php lib/blackJack/BlackJackGame.php
```

## 目的

* PHPの基本的な文法を理解する
* オブジェクト指向でプログラムを作成する
* ブラックジャックゲーム作成にあたり作成したファイル(src/lib/blackJack配下)
```bash
.
└── src
    └── lib
        └── blackJack
            ├── BlackJackCardA.php
            ├── BlackJackCardB.php
            ├── BlackJackDeck.php
            ├── BlackJackGame.php
            ├── BlackJackJudgmentOneOnOne.php
            ├── BlackJackJudgmentOneOnThree.php
            ├── BlackJackJudgmentOneOnTwo.php
            ├── BlackJackParticipantsDealer.php
            ├── BlackJackParticipantsPlayerA.php
            ├── BlackJackParticipantsPlayerB.php
            ├── BlackJackParticipantsPlayerC.php
            ├── BlackJackProgressOneOnOne.php
            ├── BlackJackProgressOneOnThree.php
            ├── BlackJackProgressOneOnTwo.php
            ├── CardRule.php
            ├── CardRuleEvaluator.php
            ├── JudgmentRule.php
            ├── JudgmentRuleEvaluator.php
            ├── ParticipantsRule.php
            ├── ParticipantsRuleEvaluator.php
            ├── ProgressRule.php
            └── ProgressRuleEvaluator.php
```

## 教材

[独学エンジニア](https://dokugaku-engineer.com/)
