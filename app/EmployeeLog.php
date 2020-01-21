<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeLog extends Model
{
    protected $table = 'hr_employeelog';
    protected $primaryKey = 'emplogid';
}
