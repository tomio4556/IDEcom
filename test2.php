<?php

namespace Track;

ini_set("memory_limit", -1);

define('BLACK', "B");
define('WHITE', "W");
define('LEFT', "L");
define('RIGTH', "R");

function main($lines)
{
    foreach ($lines as $index => $value) {
        // 処理を実行し、結果を標準出力
        printf("line[%s]: %s\n", $index, execute($value));
    }
}

/**
 * 処理を実行
 * 
 * @param string $value 標準入力から入力された値
 * @return string 黒石の数　白石の数
 */
function execute(string $inputVal): string
{
    // 文字列を分割
    $inputArray = str_split($inputVal);

    // ボードリストを生成
    $stoneList = [
        0 => BLACK,
        1 => WHITE
    ];

    // 石追加・石色の変更処理
    $cnt = 0;
    foreach ($inputArray as $index => $LR) {
        $cnt++;
        if ($cnt % 2 === 0) {

            // カウントが偶数は白
            $myColor = WHITE;
            $opponentColor = BLACK;

            // 入力値より指定する側（右・左）へ「石の追加、色の変更処理」を実行
            $stoneList = addStornAndChangeColor($LR, $myColor, $opponentColor, $stoneList);
        } else {

            // カウント数が奇数は、黒
            $myColor = BLACK;
            $opponentColor = WHITE;

            // 入力値より指定する側（右・左）へ「石の追加、色の変更処理」を実行
            $stoneList = addStornAndChangeColor($LR, $myColor, $opponentColor, $stoneList);
        }
    }

    // 石の色の数を取得
    $resultArray = array_count_values($stoneList);
    $blackCnt = array_key_exists(BLACK, $resultArray) ? $resultArray[BLACK] : 0;
    $whitCnt =  array_key_exists(WHITE, $resultArray) ? $resultArray[WHITE] : 0;

    return $blackCnt . " " . $whitCnt;
}

/**
 * 石の追加、色の変更を実行
 * 
 * @param string $LR L:左側の変更・追加　R：右側の変更・追加
 * @param string $myColor ターンの色（奇数の場合：黒色　偶数の場合：白色）
 * @param string $opponentColor ターンと反対の色（奇数の場合：白色　偶数の場合：黒色）
 * @param array $stoneList 石の一覧
 * @return array 変更後の石の一覧
 */
function addStornAndChangeColor(string $LR, string $myColor, string $opponentColor, array $stoneList): array
{
    switch ($LR) {
        case RIGTH: //右
            // 降順にソート
            krsort($stoneList);
            // 石色の変更
            $stoneList = changeColor($myColor, $opponentColor, $stoneList);

            // 昇順にソート
            ksort($stoneList);
            array_push($stoneList, $myColor);

            break;

        case LEFT: //左
            // 昇順にソート
            ksort($stoneList);
            // 石の追加、石色の変更
            $stoneList = changeColor($myColor, $opponentColor, $stoneList);

            $temp = [$myColor];
            $stoneList = array_merge($temp, $stoneList);

            break;
        default:
    }

    return $stoneList;
}

/**
 * 色の変更処理
 * 
 * @param string $myColor ターンの色（奇数の場合：黒色　偶数の場合：白色）
 * @param string $opponentColor ターンと反対の色（奇数の場合：白色　偶数の場合：黒色）
 * @param array $stoneList 石の一覧
 * @return array 変更後の石の一覧
 */
function changeColor(string $myColor, string $opponentColor, array $stoneList): array
{
    if (in_array($opponentColor, $stoneList) && in_array($myColor, $stoneList)) {
        // 両方の色が存在する場合、
        foreach ($stoneList as $index => $value) {
            if ($value == $opponentColor) {
                // 自分色に変更
                $stoneList[$index] = $myColor;
            } else {
                // 自分の色になったら抜ける
                break;
            }
        }
    }

    return $stoneList;
}

/**
 * バリデーションチェック処理
 * 
 * @param mixed $targetValue 標準入力から入力された値
 * @return bool true:OK false:NG
 */
function validation(mixed $inputval): bool
{

    if (is_null($inputval)) {
        // Nullチェック
        return false;
    }

    if (empty($inputval)) {
        // 空チェック
        return false;
    }

    if (!preg_match("/[LR]/", $inputval)) {
        // 入力値がLまたはRかチェック
        return false;
    }

    $inputSplit = str_split($inputval);
    if (1 > count($inputSplit) || 1000000 < count($inputSplit)) {
        // 文字数チェック（1 ≤ A ≤ 1000000）
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
        echo "LまたはRの文字のみを使用し、1から1000000文字数で入力してください。";
        break;
    }

    $array[] = $inputVal;
}

main($array);
