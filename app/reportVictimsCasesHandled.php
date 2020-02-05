<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \OwenIt\Auditing\Contracts\Auditable;
class reportVictimsCasesHandled extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'report_victims_cases_handled';
}
