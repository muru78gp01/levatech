<!DOCTYPE html> <!-- ドキュメントタイプ宣言。HTML文書ファイルの先頭記述し、そのHTMLバージョンを宣言する -->
<html lang="{{ str_replace('_' , '-' , app()->getLocale()) }}"> 
<!-- app()->getLocale()：ユーザーの言語環境を取得
     str_replace( $検索文字列 , $置換後文字列 , $検索対象文字列)：文字列を置換する
     ユーザーの言語環境によって文字変換されるコードという意味-->
    <head>　<!-- この文書のヘッダ部を指定する。ヘッダ部には、この文書全体に関する指定などを書く。 -->
        <meta charset="utf-8"> 
        <!-- metaタグはヘッダ部に配置して、ページに関する様々な情報を記述する。
             設定したい情報の種類を属性名で指定し、その内容を属性値に記述する。
             文字コードを指定するには、charset属性という属性を使い、
             その属性値に"HTMLファイルを作成したテキストエディタの文字コード"を指定する-->
        <title>Blog</title> 
        <!-- この文書のタイトル。ヘッダ部に一度だけ記述する。
             タイトルは、ブラウザのツールバー、履歴、検索エンジンの検索結果などで表示される。
             titleだけは省略することができない！-->
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <!-- linkはhref属性で指定した文書を参照する。
             href属性で文書のURLを指定する。
             rel属性でこの文書から見た参照先の文書との関係を指定する。-->
    </head>
    <body> <!-- 文書の本体を記述する。 -->
        <h1>Blog Name</h1> <!-- Heading(見出し)。h1は一番大きな見出し -->
        <div class='posts'> <!-- 'posts'ブロック -->
            @foreach ($posts as $post)
                <div class='post'>
                    <h2 class='title'>{{ $post->title }}
                        <a href="/posts/{{ $post->id }}">{{ $post->title }}</a>
                    </h2>
                    <p class='body'>{{ $post->body }}</p> <!-- 段落 -->
                    <!-- ブログ投稿削除実行用導線 -->
                    <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="deletePost({{ $post->id }})">delete</button>
                    </form>
                </div>
            @endforeach
        </div>
        <div class='pagenate'> <!-- ページネーションのブロック -->
            {{ $posts->links() }}
        </div>
        <div class='create'> <!-- ブログ投稿作成画面リンクブロック -->
            <a href='/posts/create'>create</a>
        </div>
    <!-- 削除確認を行うためのダイアログを表示するJavaScript -->
    <script>
        function deletePost(id) {
            'use strict'
            
            if(confirm('削除すると復元できません。\n本当に削除しますか？')) {
                document.getElementById(`form_${id}`).submit();
            }
        }
    </script>
    </body>
</html>