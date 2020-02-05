<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \OwenIt\Auditing\Contracts\Auditable;

class additionalInformationCase extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'additional_information_case';
}
