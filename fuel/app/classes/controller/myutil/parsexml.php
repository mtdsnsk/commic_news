<?php

// リダイレクト先のURLを取得するクラス読み込み
use \Model\Getheaders;

Class Controller_Myutil_Parsexml extends Controller {

    public function action_execute($param) {

        $rsslist = DB::select()->from('sk_rsslist')
                ->where('category', $param)
                ->execute();

        Log::info("xml解析START カテゴリー:$param 対象RSS数:" . count($rsslist));

        foreach ($rsslist as $value) {
            $id = $value['id'];
            $url = $value['rssurl'];
            $category = $value['category'];
            $this->action_parsexml($id, $url, $category);
        }

        Log::info('xml解析終了');
    }

    public function action_parsexml($rssid, $myurl, $category) {

        Log::info("[$rssid] xml解析対象RSS:$myurl");

        try {
            $context = stream_context_create(array(
                'http' => array('ignore_errors' => true)
            ));
            $mycontents = file_get_contents($myurl, false, $context); // RSSの内容を取得
            if ($mycontents === 'false') {
                Log::info("file_get_contents エラー url:$myurl");
                return FALSE;
            }
            $pos = strpos($http_response_header[0], '200'); // レスポンス取得
            if ($pos === false) {
                Log::info("http_response_header エラー url:$myurl");
                return FALSE;
            }
            if ($mycontents == NULL) {
                Log::info("mycontents Null エラー url:$myurl");
                return FALSE;
            }

            // XML文字列に変換
            $myrss = simplexml_load_string($mycontents);
            foreach ($myrss->item as $item) {
                $imgurl = '';
                $kekka = '';
                if ($item->description != '') {
                    $desc = $item->description;
                } else {
                    $desc = $item->summary;
                }
                $bl = preg_match('/http.*?(jpe?g|png)/i', $desc, $kekka);
                if ($bl) {
                    $imgurl = $kekka[0];
                }
                $source = $myrss->channel->title;
                $pubDate = date('Y-m-d H:i:s', strtotime($item->pubDate));
                $dc = $item->children('http://purl.org/dc/elements/1.1/');
                $date = date('Y-m-d', strtotime($dc->date));
                if ($pubDate < $date) {
                    $pubDate = $date;
                }
                $this->insert_news($rssid, $item->title, $item->link, $item->guid, $imgurl, $desc, $category, $source, $pubDate);
            }
            foreach ($myrss->entry as $item) {
                $imgurl = '';
                $kekka = '';
                if ($item->summary != '') {
                    $desc = $item->summary;
                } else {
                    $desc = $item->description;
                }
                $bl = preg_match('/http.*?(jpe?g|png)/i', $desc, $kekka);
                if ($bl) {
                    $imgurl = $kekka[0];
                }
                $source = $myrss->channel->title;
                $pubDate = date('Y-m-d H:i:s', strtotime($item->updated));
                $linkurl = $item->link->attributes()->href;
                $this->insert_news($rssid, $item->title, $linkurl, $item->guid, $imgurl, $desc, $category, $source, $pubDate);
            }
            foreach ($myrss->channel->item as $item) {
                $imgurl = '';
                $kekka = '';
                if ($item->description != '') {
                    $desc = $item->description;
                } else {
                    $desc = $item->desc;
                }
                $bl = preg_match('/http.*?(jpe?g|png)/i', $desc, $kekka);
                if ($bl) {
                    $imgurl = $kekka[0];
                }
                $source = $myrss->channel['title'];
                $pubDate = date('Y-m-d H:i:s', strtotime($item->pubDate));
                $dc = $item->children('http://purl.org/dc/elements/1.1/');
                $date = date('Y-m-d', strtotime($dc->date));
                if ($pubDate < $date) {
                    $pubDate = $date;
                }
                $this->insert_news($rssid, $item->title, $item->link, $item->guid, $imgurl, $desc, $category, $source, $pubDate);
            }
            echo '<hr>';
        } catch (Exception $exc) {
            // エラー
            Log::info('取得失敗 RSS NO:' . $rssid . '/URL:' . $myurl . ' (エラー)' . $exc->getMessage());
            DB::update('sk_rsslist')->set(array(
                'error' => 1,
            ))->where('id', $rssid)->execute();
            return FALSE;
        }
        //成功
        Log::info('取得成功 RSS NO:' . $rssid . '/URL:' . $myurl);
        DB::update('sk_rsslist')->set(array(
            'error' => 0,
        ))->where('id', $rssid)->execute();

        return $this;
    }

    private function insert_news($rssid, $title, $m_url, $guid, $imgurl, $desc, $category, $source, $pubdate) {

        $url = Getheaders::get_header($m_url);
        Log::debug("$m_url ' to redirect ' $url");

        $query = DB::select('id')->from('sk_news')
                ->where('url', $url)
                ->execute();

        if (DB::count_last_query() > 0) {
            DB::update('sk_news')->set(array(
                'title' => $title,
                'url' => $url,
                'guid' => $guid,
                'description' => $desc,
                'category' => $category,
                'source' => $source,
                'updated_at' => date("Y-m-d H:i:s"),
                'rsslist_id' => $rssid,
                'pubdate' => $pubdate,
            ))->where('id', $query[0]['id'])->execute();
        } else {
            DB::insert('sk_news')->set(array(
                'title' => $title,
                'url' => $url,
                'guid' => $guid,
                'image_url' => $imgurl,
                'description' => $desc,
                'category' => $category,
                'source' => $source,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'rsslist_id' => $rssid,
                'pubdate' => $pubdate,
            ))->execute();
        }
    }

}
