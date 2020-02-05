<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \OwenIt\Auditing\Contracts\Auditable;
class individualPerformanceReport extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'individual_performance_report';
}
