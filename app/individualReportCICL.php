<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \OwenIt\Auditing\Contracts\Auditable;
class individualReportCICL extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'individual_report_cicl';
}
