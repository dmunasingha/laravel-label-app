<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labels extends Model {
    use HasFactory;
    protected $fillable = [
        'page_size',
        'label_width',
        'label_height',
        'orientation',
        'date_start',
        'date_end',
        'start_label_position',
        'end_label_position',
        'pdf',
    ];
}