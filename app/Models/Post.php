<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;// クラス宣言直後に置かないといけない。
    //fillが実行可能にするためのプロパティ設定
    protected $fillable = [
        'title',
        'body',
        'category_id'
    ];
    use HasFactory;
    public function getByLimit(int $limit_count = 10)
    {
        // updated_atで降順に並べたあと、limitで件数制限をかける
        return $this->orderBy('updated_at', 'DESC')->limit($limit_count)->get();
    }
    
    public function getPaginateByLimit(int $limit_count = 5)
    {
        // updated_atで降順に並べたあと、limitで件数制限をかける
        // Eagerローディング'::with(リレーション名)'はリレーションによって増えてしまうデータベースアクセスを減らすため
        return $this::with('category')->orderBy('updated_at', 'DESC')->paginate($limit_count);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
