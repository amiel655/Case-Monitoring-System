<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \OwenIt\Auditing\Contracts\Auditable;
class listDetaineesRepresentedCourt extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'list_detainees_represented_court';
}
