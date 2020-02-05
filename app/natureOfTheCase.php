<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \OwenIt\Auditing\Contracts\Auditable;
class natureOfTheCase extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'nature_of_the_case';
}
