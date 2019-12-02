<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class expensepayment extends Model
{
    protected $table = 'expensepayment';
      protected $primaryKey = 'expensepaymentid';
   protected $fillable = [
   	'adminid','employeeid','expensecategoryid','paymenttype','amount','dte','status','gstamount','billno','accountno','bankname','Chequeno',
     ];}
