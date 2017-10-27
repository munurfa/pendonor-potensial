<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendonor extends Model
{
    public function transaksi()
    {
        return $this->hasMany('App\TransaksiDonor', 'pendonor_id', 'id');
    }
}
