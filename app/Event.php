<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \OwenIt\Auditing\Contracts\Auditable;
class Event extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'calendar';
    protected $fillable = ['title', 'color', 'start_date', 'end_date'];
}
