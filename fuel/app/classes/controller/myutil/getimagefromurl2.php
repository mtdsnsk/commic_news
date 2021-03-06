<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Controller_Myutil_Getimagefromurl2 extends Controller {
    /*
     * 
     */

    public function action_fn() {

        try {
            $id = Input::param('id');
            $url = Input::param('url');

            if ($url == '') {
                Log::debug('(エラー)　画像取得開始 url=' . $url);
                return;
            }
            $this->getimage($id, $url);
        } catch (Exception $ex) {
            Log::debug($ex->getMessage());
        }
    }

    /*
     * 
     */

    private function getimage($id, $url) {

        $image_count = 0;
        $max_image_count = 10;
        $str_url = array();
        Log::debug('画像取得開始 url=' . $url);

        // 画像URL配列作成
        $image_array = $this->getimage_array($id, $url);
        foreach ($image_array as $key => $row) {
            $image_size[$key] = $row['size'];
            $image_url[$key] = $row['url'];
        }
        // サイズ順に並べ替え
        if (count($image_array) > 0) {
            array_multisort($image_size, SORT_DESC, $image_url, SORT_ASC, $image_array);
        }
        // URL配列作成
        foreach ($image_array as $data) {
            array_push($str_url, $data['url']);
            $image_count++;
            // 最大取得数を指定しているとき
            if ($image_count > $max_image_count) {
                // 何もしない 
                //break;
            }
        }
        if (count($str_url) > 0) {
            $string = implode(',', $str_url);
            Log::debug('画像取得OK url=' . $string);
            DB::update('sk_news')->set(array(
                        'image_url' => $string,
                        'updated_at' => date("Y-m-d H:i:s"),
                    ))->where('id', $id)
                    ->execute();
        }
    }

    /*
     * 
     */

    private function getimage_array($id, $url) {

        $image_dat = array(); // リンクの画像データの配列を格納する
        if ($url == '') {
            Log::debug("エラー１");
            return $image_dat;
        }
        // 存在するかだけをチェック
        $exist = @file_get_contents($url, NULL, NULL, 1, 1);
        if (!$exist) {
            // 取得先URLにコンテンツが存在しない
            Log::debug("エラー２");
            return $image_dat;
        }
        // 必要文字配列取得
        $sp = $this->html_string_parse($id, $url);
        if ($sp == NULL) {
            Log::debug("エラー３");
            return $image_dat;
        }
        foreach ($sp as $data) {
            $data_ = $this->push_images($data, $url);
            if ($data_ != NULL) {
                array_push($image_dat, array(
                    'url' => $data_['url'], 'size' => $data_['size'],
                ));
            }
        }
        return $image_dat;
    }

    private function html_string_parse($id, $url) {

        $exist = @file_get_contents($url, NULL, NULL, 1);
        if (!$exist) {
            Log::debug("存在しないURL:" . $url);
            return NULL;
        } else {
            DB::update('sk_news')->set(array(
                        'contents' => $exist,
                    ))->where('id', $id)
                    ->execute();
        }

        $ex0 = preg_replace("/<a .*?(amazon|rakuten|valuecommerce|linksynergy|trafficgate|logo).*?>.*?<\/a>/i", " ", $exist);
        $ex1 = preg_replace("/<a .*?(\.html|\.js).*?>.*?<\/a>/i", " ", $ex0);
        $ex2 = preg_replace("/[<>]/", " ", $ex1); // データ文字列を置換
        $ex3 = preg_replace("/(\&quot)/", " ", $ex2); // データ文字列を置換
        $sp1 = explode(" ", $ex3); // 文字列を分割
        $sp2 = array_unique($sp1); // 重複排除
        $sp3 = array_filter($sp2, 'strlen'); // null削除
        return $sp3;
    }

    private function push_images($data, $url, $kekka = '') {

        // jpeg,pngを探す
        $bl = preg_match('/http.*?(jpe?g|pne?g)/i', $data, $kekka);
        if (!$bl) {
            return NULL; // ファイル拡張子がjpeg,pngでない
        }

        //既に画像DBに存在するURLかをチェック
        $db_exist = DB::select()->from('sk_icon_images')
                ->where('image_url', $kekka[0])
                ->execute();
        if (count($db_exist) > 0) {
            return NULL; // 1つ以上存在する場合は追加しない
        }

        $exist = @file_get_contents($kekka[0], NULL, NULL, 1);
        if (!$exist) {
            //Log::debug("画像が存在しない:" . $kekka[0]);
            return NULL;
        }

        $size = ceil(strlen($exist) / 1024); // ファイルサイズ
        if ($size < 15) {
            //画像が存在しない;
            return NULL;
        }

        $dat['url'] = $kekka[0];
        $dat['size'] = $size;
        return $dat;
    }

}
