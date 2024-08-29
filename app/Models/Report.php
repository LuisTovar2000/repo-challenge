<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date', 'end_date', 'total_sales', 'total_cost', 'total_tax',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
