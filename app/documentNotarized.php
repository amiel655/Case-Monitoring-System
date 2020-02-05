<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \OwenIt\Auditing\Contracts\Auditable;
class documentNotarized extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'document_notarized';
}
