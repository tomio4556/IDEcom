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
 * @param string $inputVal 標準入力から入力された値
 * @return string 入力値の数字組み合わせで、接頭が0以外の最小値
 */
function execute(string $inputVal): string
{
    // 入力値を分割
    $inputArray = str_split($inputVal);

    // 昇順で並び変え
    sort($inputArray);

    $result = "";
    foreach ($inputArray as $value) {
        if ($value !== "0") {
            // 0以外の場合、文字列結合
            $result = $result . $value;
        }
    }

    if (count($inputArray) !== count(str_split($result))) {
        // 入力値に0がある場合、0埋め
        $topchar = substr($result, 0, 1);
        $result = mb_substr($result, 1);
        $result = str_pad($result, count($inputArray) - 1, "0", STR_PAD_LEFT);
        $result = $topchar . $result;
    }

    return $result;
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

    if (!preg_match("/^([1-9][0-9]*)$/", $inputVal)) {
        // 整数チェック
        return false;
    }

    $inputSplit = str_split($inputVal);
    if (1 > count($inputSplit) || 100 < count($inputSplit)) {
        // 桁数チェック（1 ≤ N ≤ 100）
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
        echo "1桁から100桁までの整数値を入力してください。";
        break;
    }

    $array[] = $inputVal;
}

main($array);
