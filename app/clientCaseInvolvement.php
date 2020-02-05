<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \OwenIt\Auditing\Contracts\Auditable;
class clientCaseInvolvement extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'client_case_involvement';
}
