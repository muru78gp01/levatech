<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use宣言は外部にあるクラスをPostController内にインポートできる。
//この場合、App\Models内のPostクラスをインポートしている。
use App\Models\Post;
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
}