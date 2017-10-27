<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiDonor extends Model
{
    protected $dates = ['created_at', 'updated_at'];

    public function pendonor()
    {
        return $this->belongsTo('App\Pendonor', 'id', 'pendonor_id');
    }

    public function scopeDtBanding($q, $tglban)
    {
        return $q->whereBetween('created_at', ['2015-01-01 00:00:00', $tglban.'-31 00:00:00']);
    }

    public function scopeFBan($q, $tglban)
    {
        return $q->where('created_at', 'not like', $tglban.'%');
    }

    public function scopeLBan($q, $tglban)
    {
        return $q->where('created_at', 'like', $tglban.'%')->where('jumlah_donor', '>', 1);
    }

    public function getFAttribute()
    {
        return $this->jumlah_donor;
    }

    public function getMAttribute()
    {
        return (int) $this->CC * $this->jumlah_donor;
    }

    public function scopeAscTanggal($q)
    {
        return $q->orderBy('created_at', 'asc');
    }
}
