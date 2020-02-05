<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \OwenIt\Auditing\Contracts\Auditable;
class natureRequest extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'control_reference_and_nature_of_request';
}
