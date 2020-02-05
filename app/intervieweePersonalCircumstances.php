<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \OwenIt\Auditing\Contracts\Auditable;
class intervieweePersonalCircumstances extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'interviewee_personal_circumstances';
}
