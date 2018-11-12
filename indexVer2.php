<?php
// POSTとして送信されてきたときのみ実行
// (通常アクセスはGET，フォーム送信はPOST)


function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

session_start(); // 1

$name = (string)filter_input(INPUT_POST, 'name'); 
$text = (string)filter_input(INPUT_POST, 'text');
$token = (string)filter_input(INPUT_POST, 'token'); // 3


$fp = fopen('data.csv', 'a+b'); // 1
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    fputcsv($fp, [$_POST['name'], $_POST['text']]);
    rewind($fp); // 2
}
while ($row = fgetcsv($fp)) { // 3
    $rows[] = $row; // 4
}
fclose($fp);

?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="a.css">
    <link href="https://fonts.googleapis.com/earlyaccess/nicomoji.css" rel="stylesheet">

    <title>Document</title>
</head>

<body>
    <div class="toptitle">
        <a href="http://teppane.raindrop.jp/index.php">Nちゃんねる</a>
    </div>
    <div class="title">
        <p>[概要]</p>
    </div>
    <div class="sub">
        <p>とりあえず、好きなこと書き込んでください。でも、この掲示板への迷惑行為。<br>
            エロチャはなしで(するなら別の場所に移しておなしゃす。)</p>
    </div>



    <section>
        <div class="title">
            <p>新規投稿</p>
        </div>
        <div class="sub">
            <p>(名前と本文を記入してください)</p>
        </div>
        <div class="name">
        <form action="" method="post">
            名前: <input type="text" name="name" value=""><br>
            本文: <input type="text" name="text" value=""><br>
            <button type="submit">投稿</button>
        </form>
    </div>
    </section>
    <section>
            <div class="title">
                <p>投稿一覧</p>
            </div>
            <div class="sel">
            <?php if (!empty($rows)): ?>
            <ul>
                <?php foreach ($rows as $row): ?>
                <li>
                    <?=$row[1]?> (
                    <?=$row[0]?>)</li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <p>投稿はまだありません</p>
            <?php endif; ?>
        </div>
    </section>
</body>

</html>