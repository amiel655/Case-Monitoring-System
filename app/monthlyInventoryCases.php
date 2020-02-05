<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \OwenIt\Auditing\Contracts\Auditable;
class monthlyInventoryCases extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'monthly_inventory_cases';
}
