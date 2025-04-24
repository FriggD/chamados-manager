<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'due_date',
        'solution_date',
        'category_id',
        'status_id'
    ];

    /**
     * Get the category that owns the order.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the status that owns the order.
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}

