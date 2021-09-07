<?php

namespace hrmis\Models;

use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    protected $table = "qrcodes";
    protected $primary_key = "id";

    protected $fillable = ['eid', 'qrcode'];

    protected $dates = ['created_at', 'updated_at'];

}
