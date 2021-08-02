<?php

/* echo '書籍名：銀河鉄道の夜' . PHP_EOL;
echo '著者名：宮沢賢治' . PHP_EOL;
echo '読書状況：結構読んだ' . PHP_EOL;
echo '評価：５' . PHP_EOL;
echo '感想：あらゆる小説を読破し、小説グルメ家とまで呼ばれた私を持ってしても、この作品は素晴らしいと言わざるを得ないだろう。' . PHP_EOL; */
function dbConnect(){
$link = mysqli_connect('db','book_log','pass','book_log');
if(!$link) {
    echo 'Error:データベースに接続できませんでした' . PHP_EOL;
    echo 'Debugging error:' . mysqli_connect_error() . PHP_EOL;
    exit;
}
echo 'データベースに接続できました' . PHP_EOL;
return $link;
}
$link = dbConnect();

function validate($review) {
    $errors = [];
    //書籍名のチェック
    if(!strlen($review['book_name'])){
        $errors['book_name'] = '書籍名を入力してください';
    } elseif (strlen($review['book_name']) > 31){
        $errors['book_name'] = '書籍名は31文字以内で入力してください。';
    }

    if (!strlen($review['author'])) {
        $errors['author'] = '著者名を入力してください';
    } elseif (strlen($review['book_name']) > 31) {
        $errors['author'] = '著者名は31文字以内で入力してください。';
    }

    if (!strlen($review['proceeding'])) {
        $errors['proceeding'] = '読書状況を入力してください';
    }elseif(!in_array($review['proceeding'],['未読', '読了', '読んでる'], true)){
        $errors['proceeding'] = '読書状況は「未読」「読了」「読んでる」のいずれかを入力してください。';
    }

    if (!strlen($review['score'])) {
        $errors['score'] = '評価を入力してください';
    }elseif($review['score'] < 1 || $review['score'] > 5 || (int)$review['score'] != $review['score']){
        $errors['score'] = '評価は１以上５以下の整数で入力してください。';
    }

    if (!strlen($review['impression'])) {
        $errors['impression'] = '感想を入力してください';
    } elseif (strlen($review['impression']) > 1000) {
        $errors['impression'] = '感想は1000文字以内で入力してください。';
    }

    return $errors;
}

function createReviews($link){
    $review = [];
    echo '読書ログを登録してください' . PHP_EOL;
    echo '書籍名：';
    $review['book_name'] = trim(fgets(STDIN));
    echo '著者名：';
    $review['author'] = trim(fgets(STDIN));
    echo '読書状況：';
    $review['proceeding'] = trim(fgets(STDIN));
    echo '評価：';
    $review['score'] = trim(fgets(STDIN));
    echo '感想：';
    $review['impression'] = trim(fgets(STDIN));

    $validated = validate($review);
    if(count($validated) > 0) {
        foreach ($validated as $error){
            echo $error . PHP_EOL;
        }
        return;
    }


$sql = <<<EOT
INSERT INTO reviews(
    book_name,
    author,
    proceeding,
    score,
    impression
)VALUES(
    "{$review['book_name']}",
    "{$review['author']}",
    "{$review['proceeding']}",
    "{$review['score']}",
    "{$review['impression']}"
    )
EOT;
            $result = mysqli_query($link,$sql);
            if($result) {
                echo '登録が完了しました。' . PHP_EOL;
            }else{
                echo '登録できませんでした' . PHP_EOL;
                echo 'Debugging error:' . mysqli_error($link) . PHP_EOL;
            }
        }
function showReviews($link){
    echo '登録されている読書ログを表示します' . PHP_EOL . PHP_EOL;
    $sql = 'SELECT * FROM reviews';
    $results = mysqli_query($link, $sql);
    while($data = mysqli_fetch_assoc($results)){
        echo '書籍名：' . $data['book_name'] . PHP_EOL;
        echo '著者名：' . $data['author'] . PHP_EOL;
        echo '読書状況：' . $data['proceeding'] . PHP_EOL;
        echo '評価：' . $data['score'] . PHP_EOL;
        echo '感想：' . $data['impression'] . PHP_EOL;
        echo '___________________' . PHP_EOL . PHP_EOL;
    }
    mysqli_free_result($results);
}
while(true){
    echo '1.読書ログを登録' . PHP_EOL;
    echo '2.読書ログを表示' . PHP_EOL;
    echo '9.アプリケーションを終了' . PHP_EOL;
    echo '番号を洗濯してください(1,2,9)：';

    $num = trim(fgets(STDIN));

    if($num === '１'){
        createReviews($link);
    }else if($num === '２'){
        showReviews($link);
    }else if($num === '９'){
        echo 'アプリケーションを終了します' . PHP_EOL;
        mysqli_close($link);
        echo 'データベースとの接続を切断しました。' . PHP_EOL;
        break;
    }
}


/* echo '読書ログを登録してください' . PHP_EOL;
echo '書籍名：';
$book_name = trim(fgets(STDIN));
echo '著者名：';
$name = trim(fgets(STDIN));
echo '読書状況：';
$proceeding = trim(fgets(STDIN));
echo '評価：';
$score = trim(fgets(STDIN));
echo '感想：';
$impression = trim(fgets(STDIN));
echo '登録が完了しました' . PHP_EOL . PHP_EOL;
echo '読書ログを表示します' . PHP_EOL;
echo '書籍名：' . $book_name . PHP_EOL;
echo '著者名：' . $name . PHP_EOL;
echo '読書状況：' . $proceeding . PHP_EOL;
echo '評価：' . $score . PHP_EOL;
echo '感想：' . $impression . PHP_EOL; */
