<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTable extends Model
{
	protected $table = null;
   
    protected $fillable = [
        'data',
    ];

    protected $casts = [
        'data' => 'object',
    ];

    public function setTable($tableName)
    {
        $this->table = $tableName;
    }

    public function scopeTable($query, $tableName)
    {
        $query->getQuery()->from = $tableName;
        return $query;
    }
}
