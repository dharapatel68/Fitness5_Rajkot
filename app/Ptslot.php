<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ptslot extends Model
{
    protected $table='ptslot';
    protected $primaryKey = 'ptslotid';
    protected $fillable = [
        'ptslotid','Trainerid','Day','todate','700','800','900','1000','1100','1200','1300','1400','1500','1600','1700','1800','1900','2000','2100','2200','2300'
    ];
  
}
