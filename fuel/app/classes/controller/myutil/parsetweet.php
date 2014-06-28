<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Controller_Myutil_Parsetweet extends Controller {

    public function action_fntweet() {

        require_once( APPPATH . 'classes/model/Multithreading.php');
        $array_url = array();

        Log::info('twitter解析開始');
        $query = DB::select('url', 'id', 'tweet_count')->from('sk_news')
                ->where('created_at', '>=', date("Ymd"))
                ->execute();
        Log::info("対象データ:" . count($query));

        foreach ($query as $key => $data) {

            $id = $data['id'];
            $url = $data['url'];
            $tweet_count = $data['tweet_count'];
            //$html = 'http://dev-tachiyomi.torico-tokyo.com/commic_news/public/myutil/getimagefromurl/getimagefromurl?' .
            $th = 'http://localhost/sukima_server/public/myutil/parsetweet/tweetcount?' .
                    "id=$id" . '&' . "url=$url" . '&' . "tweet_count=$tweet_count";

            array_push($array_url, $th);
        }

        Multithreading::execute($array_url);
        Log::info('twitter解析終了');

        return;
    }

    public function action_tweetcount() {

        $id = Input::param('id');
        $url = Input::param('url');
        $tweet_count = Input::param('tweet_count');

        try {
            $sp = explode('?', $url); //パラメータがある場合は区切り文字で分割            
            $twitterurl = 'http://urls.api.twitter.com/1/urls/count.json?url='; // APIのURL
            $apiurl = $twitterurl . $sp[0];
            $json1 = file_get_contents($apiurl); // JSON取得
            $json2 = mb_convert_encoding($json1, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN'); // UTF-8に変換            
            $obj = json_decode($json2); // デコード
            // 配列にキーがあるか確認
            if (array_key_exists('count', $obj)) {
                $count = $obj->count; // つぶやき回数取得
            }
        } catch (Exception $exc) {
            Log::info("(エラー) つぶやき回数取得失敗 / 対象URL:$url" . $exc->getMessage());
            return 0;
        }
        Log::info("つぶやき回数取得結果:$count / 対象URL:$url");

        // 更新処理
        DB::update('sk_news')->set(array(
            'tweet_count' => $count,
            'tweet_count_rise' => $count - $tweet_count,
        ))->where('id', $id)->execute();
        return;
    }

    public function action_fngraph() {

        require_once( APPPATH . 'classes/model/Multithreading.php');
        $array_url = array();

        Log::info('graph解析開始');
        $query = DB::select('url', 'id', 'tweet_count')->from('sk_news')
                ->where('created_at', '>=', date("Ymd"))
                ->execute();
        Log::info("対象データ:" . count($query));

        foreach ($query as $key => $data) {

            $id = $data['id'];
            $url = $data['url'];
            //$html = 'http://dev-tachiyomi.torico-tokyo.com/commic_news/public/myutil/getimagefromurl/getimagefromurl?' .
            $th = 'http://localhost/sukima_server/public/myutil/parsetweet/goodcount?' .
                    "id=$id" . '&' . "url=$url";

            array_push($array_url, $th);
        }

        Multithreading::execute($array_url);
        Log::info('graph解析終了');

        return;
    }

    public function action_goodcount() {

        $id = Input::param('id');
        $url = Input::param('url');
        $shares = '';
        $comments = '';

        try {
            $sp = explode('?', $url); //パラメータがある場合は区切り文字で分割            
            $graphurl = 'http://graph.facebook.com/'; // APIのURL
            $apiurl = $graphurl . $sp[0];
            //$json1 = file_get_contents($apiurl); // JSON取得
            $json1 = @file_get_contents($apiurl, NULL, NULL, 1);
            if (!$json1) {
                Log::debug("存在しないURL:" . $apiurl);
                return NULL;
            }
            $json2 = mb_convert_encoding($json1, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN'); // UTF-8に変換            
            $obj = json_decode($json2); // デコード
            // 配列にキーがあるか確認
            if (array_key_exists('shares', $obj)) {
                $shares = $obj->shares; // つぶやき回数取得
            }
            if (array_key_exists('comments', $obj)) {
                $comments = $obj->comments; // つぶやき回数取得
            }
        } catch (Exception $exc) {
            Log::info("(エラー) facebook graph取得失敗 / 対象URL:$url　" . $exc->getMessage());
            return 0;
        }
        Log::info("シェア回数:$shares / コメント回数:$comments /　対象URL:$url");

        // 更新処理
        DB::update('sk_news')->set(array(
            'ranking1' => $shares,
            'ranking2' => $comments,
        ))->where('id', $id)->execute();
        return;
    }

}
