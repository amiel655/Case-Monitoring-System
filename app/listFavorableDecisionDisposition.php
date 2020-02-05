<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \OwenIt\Auditing\Contracts\Auditable;
class listFavorableDecisionDisposition extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'list_favorable_decision_disposition';
}
