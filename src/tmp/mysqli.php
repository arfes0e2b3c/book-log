<?php

$link = mysqli_connect('db','book_log','pass','book_log');
if(!$link) {
    echo 'Error:データベースに接続できませんでした。' . PHP_EOL;
    echo 'Debugging error :' . mysqli_connect_error() . PHP_EOL;
    exit;
}
$sql = <<<EOT
INSERT INTO reviews (
    book_name,
    author,
    proceeding,
    score,
    impression
) VALUES (
    'ore',
    'ore',
    'mettya',
    5

)
EOT;
$result = mysqli_query($link,$sql);
if($result) {
    echo 'データを追加しました。' . PHP_EOL;
} else {
    echo 'データの追加に失敗しました' . PHP_EOL;
    echo 'Debugging error:' . mysqli_error($link) . PHP_EOL;
}
/* if(!$result) {
    echo 'Error:データベースにデータを登録できませんでした。' . PHP_EOL;
    echo 'Debugging error:' . mysqli_query_error() . PHP_EOL;
    exit;
} */
echo 'データベース(mysql)に登録できました。' . PHP_EOL;
mysqli_close($link);
echo 'データベース(mysql)との接続を切断しました' . PHP_EOL;
