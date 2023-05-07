<?php

namespace App\Http\Controllers;

//use宣言は外部にあるクラスをPostController内にインポートできる。
//この場合、App\Models内のPostクラスをインポートしている。
use App\Models\Post;
use App\Http\Requests\PostRequest;
class PostController extends Controller
{
    /**
    * Post一覧を表示する
    * 
    * @param Post Postモデル
    * @return array Postモデルリスト
    */
    public function index(Post $post)//インポートしたPostをインスタンス化して$postとして使用。
    {
        return view('posts/index')->with(['posts' => $post->getPaginateByLimit()]);
        //blade内で使う変数'posts''と設定。'posts'の中身にupdated_atで降順に並べたあと、
        //10件の件数制限をかけて取得するgetPagenateBylimit()を使い、インスタンス化した$postを代入。
    }
    
    public function create()//ブログ投稿作成画面のviewを返却する関数。
    {
        return view('posts/create');
    }
    
    public function store(PostRequest $request, Post $post) //RequestをPostRequestに変更
    /**Request $request
     * ユーザからのリクエストが含まれるデータを扱う場合、Requestインスタンスを利用する。
     * Post $post
     * この関数ではユーザの入力データをDBのpostsテーブルにアクセスし保存する必要があるため、
     * 空のPostインスタンスを利用する。
     */
    {
        /**リクエストの中身
         * $request['post']を利用すると、postをキーに持つリクエストパラメータを取得できる。
         * $requestのキーは、HTMLのFormタグ内で定義した各入力項目のname属性と一致する。
         * 今回は入れ子構造になっているため、このような取得をすると
         * $inputは[ 'title' => 'タイトル', 'body' => '本文']のような配列型式となる。
         */
        
        /**保存処理
         * ・インスタンスのプロパティを上書きする
         * 　$post->fill($input)とすることで、先ほどまでからだったPostインスタンスのプロパティを、
         * 　受け取ったキーごとに上書きができる。
         * 　具体的には、$post->titleはタイトル、$post->bodyは本文という値になる。
         * 　ただし、fillを実行するとき、PostModel側でfillableというプロパティにfillが可能なプロパティを指定しておく必要がある。
         * 
         * ・保存処理を実行する
         * 　プロパティを上書きしたインスタンスをsaveすることで、フレームワーク内部でMySQLへのINSERT文が実行され、
         * 　DBへデータが追加される。
         * 　通常、SQLを作成し実行しなければデータの追加は行えない。
         * 　LaravelではEloquentというORマッパーが用意されており、モデルクラスがそれにあたる。
         * 　fill関数やsave関数はこのモデルクラスに含まれる。
         * 　これを実行することで、内部的にSQLの作成&実行が行われるので、
         * 　頑張ってSQLをソース内に書かなくても、データの取得や追加などができる。
         */
        
        /**リダイレクト
         * 保存処理が終了すると、/posts/1など、今回保存したpostのIDを含んだRLにリダイレクトする。
         * $post->save()が完了した段階で、PostインスタンスにはIDが採番され、
         * プロパティとしても保持しておりアクセス可能。
         * そのため、return redirect('posts/' . $post->id);と記載できる。
         */
        $input = $request['post'];//$input = [ 'title' => 'タイトル', 'body' => '本文']
        $post->fill($input)->save();
        return redirect('/posts/' . $post->id);
    }
    
    /**
     * 特定IDのpostを表示する
     * 
     * @params Object Post // 引数の$postはid=1のPostインスタンス
     * @return Reponse post view
     */
    public function show(Post $post)
    {
        return view('posts/show')->with(['post' => $post]);
     //'post'はbladeファイルで使う変数。中身は$postはid=1のPostインスタンス。
    }
}