<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkingDays extends Model
{
    protected $table = 'workingcalander'; 
    protected $primaryKey = 'workingcalid';
}
