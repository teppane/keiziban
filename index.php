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


<meta charset="UTF-8">



<font face="arial black">

<h7>N</h7><h11>ちゃんねる</h11>
<input type="button" value="     更新     " onclick="window.location.reload();" />
</font>
<br><br>
<h1>[概要]</h1>

<div class="haikei1"><p1>とりあえず、好きなこと書き込んでください。でも、この掲示板への迷惑行為。</p1><br><p1>上の更新ボタンで投稿一覧を更新できます</p1>
</div>

<link rel="stylesheet" href="keiziban.css">
<br><br>
<section>

    <h1>[新規投稿]</h1><h3>(ニックネームと本文を記入してください)</h3>
    <br>
    <div>
    <form action="" method="post">
        名前: <input type="text" name="name" value=""><br>
        本文: <input type="text" name="text" value=""><br>
        <button type="submit">投稿</button>
    </form>
    </div>
</section>
<section><br><br>
    <h1>[投稿一覧]</h1>

    <div>
    <?php if (!empty($rows)): ?>
    <ul>
<?php foreach ($rows as $row): ?>
        <li><?=$row[1]?> (<?=$row[0]?>)</li>
<?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>投稿はまだありません</p>
    <?php endif; ?>
    </div>
</section>