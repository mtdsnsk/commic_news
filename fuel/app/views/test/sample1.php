<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>sample</title>
        <?php echo Asset::css('bootstrap.css'); ?>
        <style>
            table{
                width: 100%;
                border-collapse: collapse;
            }
            th {
                border:1px solid #ccc;
                background:#e1e1e1;
                padding:5px;
            }
            td {
                vertical-align: top;
                border:1px solid #ccc;
                padding:5px;
            }
            .t01{
                width: 50%;
            }

            .t02{
                width: 50%;
            }
            img{
                max-height: 160px;
                float: right;
            }
            .sm img{
                max-height: 120px;
            }
            .midashi{
                font-size: 22px;
            }
            .teikyo{
                
            }
        </style>
    </head>
    <body>
        <table class="sample_01">
            <tbody>
                <tr>
                    <td colspan="2">
                        <span>
                            <img src="http://imgcc.naver.jp/kaze/mission/USER/20140602/18/167278/3/300x200xc3e2ea0963e690928f879980.jpg"/>
                            <span class="midashi">トップニュース</span><br>
                            <a link="#">リンクがついたニュースの概要を表示するテキスト</a>
                            リンクがついたニュースの概要を表示するテキスト
                            リンクがついたニュースの概要を表示するテキスト
                            リンクがついたニュースの概要を表示するテキスト
                            リンクがついたニュースの概要を表示するテキスト
                            リンクがついたニュースの概要を表示するテキスト
                            リンクがついたニュースの概要を表示するテキスト
                            リンクがついたニュースの概要を表示するテキスト
                            <br>
                            <span class="teikyo">
                            提供元:<b>トップサイト</b>
                            </span>
                        </span>

                    </td>
                </tr>
                <tr>
                    <td class="t01 sm">
                        <img src="http://imgcc.naver.jp/kaze/mission/USER/20140602/18/167278/3/300x200xc3e2ea0963e690928f879980.jpg"/>
                        <span class="midashi"><?= $title[0]; ?></span><br>
                        <a link="#">リンクがついたニュースの概要を表示するテキスト</a>
                        リンクがついたニュースの概要を表示するテキスト
                        <br>
                        <span>
                            提供元:<b>トップサイト</b>
                            </span>
                    </td>
                    <td class="sm">
                        <img src="http://imgcc.naver.jp/kaze/mission/USER/20140602/18/167278/3/300x200xc3e2ea0963e690928f879980.jpg"/>
                        <span class="midashi"><?= $title[1]; ?></span><br>
                        <a link="#">リンクがついたニュースの概要を表示するテキスト</a>
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        <br>
                        提供元:<b>トップサイト</b>
                    </td>
                </tr>
                <tr>
                    <td class="t01 sm">
                        <img src="http://imgcc.naver.jp/kaze/mission/USER/20140602/18/167278/3/300x200xc3e2ea0963e690928f879980.jpg"/>
                        <span class="midashi">トップニュース</span><br>
                        <a link="#">リンクがついたニュースの概要を表示するテキスト</a>
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        <br>
                        提供元:<b>トップサイト</b>
                    </td>
                    <td class="sm">
                        <img src="http://imgcc.naver.jp/kaze/mission/USER/20140602/18/167278/3/300x200xc3e2ea0963e690928f879980.jpg"/>
                        <span class="midashi">トップニュース</span><br>
                        <a link="#">リンクがついたニュースの概要を表示するテキスト</a>
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        <br>
                        提供元:<b>トップサイト</b>
                    </td>
                </tr>
                <tr>
                    <td class="t01 sm">
                        <img src="http://imgcc.naver.jp/kaze/mission/USER/20140602/18/167278/3/300x200xc3e2ea0963e690928f879980.jpg"/>
                        <span class="midashi">トップニュース</span><br>
                        <a link="#">リンクがついたニュースの概要を表示するテキスト</a>
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        <br>
                        提供元:<b>トップサイト</b>
                    </td>
                    <td class="sm">
                        <img src="http://imgcc.naver.jp/kaze/mission/USER/20140602/18/167278/3/300x200xc3e2ea0963e690928f879980.jpg"/>
                        <span class="midashi">トップニュース</span><br>
                        <a link="#">リンクがついたニュースの概要を表示するテキスト</a>
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        <br>
                        提供元:<b>トップサイト</b>
                    </td>
                </tr>
                <tr>
                    <td class="t01 sm">
                        <img src="http://imgcc.naver.jp/kaze/mission/USER/20140602/18/167278/3/300x200xc3e2ea0963e690928f879980.jpg"/>
                        <span class="midashi">トップニュース</span><br>
                        <a link="#">リンクがついたニュースの概要を表示するテキスト</a>
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        <br>
                        提供元:<b>トップサイト</b>
                    </td>
                    <td class="sm">
                        <img src="http://imgcc.naver.jp/kaze/mission/USER/20140602/18/167278/3/300x200xc3e2ea0963e690928f879980.jpg"/>
                        <span class="midashi">トップニュース</span><br>
                        <a link="#">リンクがついたニュースの概要を表示するテキスト</a>
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        <br>
                        提供元:<b>トップサイト</b>
                    </td>
                </tr>
                <tr>
                    <td class="t01 sm">
                        <img src="http://imgcc.naver.jp/kaze/mission/USER/20140602/18/167278/3/300x200xc3e2ea0963e690928f879980.jpg"/>
                        <span class="midashi">トップニュース</span><br>
                        <a link="#">リンクがついたニュースの概要を表示するテキスト</a>
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        <br>
                        提供元:<b>トップサイト</b>
                    </td>
                    <td class="sm">
                        <img src="http://imgcc.naver.jp/kaze/mission/USER/20140602/18/167278/3/300x200xc3e2ea0963e690928f879980.jpg"/>
                        <span class="midashi">トップニュース</span><br>
                        <a link="#">リンクがついたニュースの概要を表示するテキスト</a>
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        リンクがついたニュースの概要を表示するテキスト
                        <br>
                        提供元:<b>トップサイト</b>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>