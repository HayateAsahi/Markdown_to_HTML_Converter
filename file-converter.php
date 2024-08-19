<?php
//php file-converter.php markdown input.md output.html
//Composerのオートローダーを読み込む
require '/home/asahi_8810/vendor/autoload.php';

// Parsedownクラスのインスタンスを作成
$parsedown = new Persedown();

$command = $argv[1];
$inputFile = $argv[2];
$outputFile = $argv[3];

class DataValidation {

    private $errorMsg = "";

    function validateInput($command, $inputFile, $outputFile){

        global $argv;

        //必要な引数の数を確認
        if (count($argv) < 4){
            $this -> errorMsg = "入力項目が足りません";
            return false;
        }

        //空文字の確認
        if ($command == "" || $inputFile == "" || $outputFile == "") {
            $this -> errorMsg = "入力されていない項目があります。";
            return false;
        }

        return true;

    }
    // エラーメッセージ取得用のメッソド
    function getErrorMsg(){
        return $this -> errorMsg;
    }
}

// インスタンス化
$dv = new DataValidation;

// バリデーションチェック
if ($dv -> validateInput($command, $inputFile, $outputFile)) {
    // バリデーション成功時の処理
    if($command == 'markdown'){
        //ファイルを受け取る
        $markdownContent = file_get_contents($inputFile);

        if($markdownContent === false) {
            echo "ファイルを読み込めませんでした。\n";
            exit;
        }

        // マークダウンをHTMLに変換
        $htmlContent = $parsedown->text($markdownContent);

        // 内容をファイルに書き込む
        if(file_put_contents($outputFile, $htmlContent) === false) {
            echo "ファイルの書き込みに失敗しました。\n";
            exit;
        }

        echo "ファイルが正常にHTMLへ変換されました。\n";
    }
} else {
    // バリデーション失敗時の処理
    echo $dv -> getErrorMsg() . "\n";
}

?>
