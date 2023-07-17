<?php

namespace Track;

ini_set("memory_limit", -1);

function main($lines)
{
    foreach ($lines as $index => $value) {

        // 処理を実行し、結果を標準出力
        printf("line[%s]: %s\n", $index, execute($value));
    }
}

/**
 * 処理実行
 * 
 * @param string $inputval 標準入力から入力された値
 * @return int 最小回数
 */
function execute(string $inputval): int
{
    // スタートマス分マイナス
    $targetVal = intval($inputval) - 1;
    $cnt = 0;
    for ($i = 6; $i >= 2; $i--) {
        $cnt++;
        // サイコロ目で乗算
        $calculation = $targetVal / $i;

        if ($calculation <= 1) {
            // これ以上割り切れない場合
            return $cnt;
        }

        if (is_int($calculation)) {
            // 整数値の場合（割り切れた場合）
            return $calculation;
        }

        // 小数点以下切り捨て
        $calculationFloor =  floor($calculation);

        // 残値を算出
        $targetVal  = $targetVal - ($calculationFloor * $i);
        $cnt = intval($calculationFloor);
    }

    return $cnt;
}

/**
 * バリデーションチェック処理
 * 
 * @param mixed $inputVal 標準入力から入力された値
 * @return bool true:OK false:NG
 */
function validation(mixed $inputVal): bool
{

    if (is_null($inputVal)) {
        // Nullチェック
        return false;
    }

    if (empty($inputVal)) {
        // 空チェック
        return false;
    }

    if (is_int($inputVal)) {
        // 整数値チェック
        return false;
    }

    if (2 > $inputVal || 100000 < $inputVal) {
        // 範囲チェック（2 ≤ A ≤100000）
        return false;
    }

    return true;
}

$array = array();

while (count($array) < 1) {

    // 標準入力より値を取得
    list($inputVal) = explode(" ", trim(fgets(STDIN)));

    if (!validation($inputVal)) {
        // 入力値のチェック
        echo "2以上100000以下の整数値を入力してください。";
        break;
    }

    $array[] = $inputVal;
}

main($array);
