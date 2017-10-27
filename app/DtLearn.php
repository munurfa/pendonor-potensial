<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DtLearn extends Model
{
    protected $appends = ['huji', 'potensial', 'hasilpotensi'];

    public function pendonor()
    {
        return $this->hasOne('App\Pendonor', 'kode_pendonor', 'kode');
    }

    public static function selban($tglDt)
    {
        $Dt = Self::all();
        $jmlDt = $Dt->count();
        $tgl = (null == $jmlDt) ? $tglDt : substr($Dt->first()->created_at, 0, 7);

        if (($tglDt != $tgl) || (null == $jmlDt)) {
            $jmlData = 1000;
            $dl = round($jmlData * 0.25);
            $tl = round($jmlData - $dl);
            $f = Pendonor::whereHas('transaksi', function ($q) use ($tglDt) {
                $q->DtBanding($tglDt)->fban($tglDt);
            })->inRandomOrder()->take($tl)->get();
            $l = Pendonor::whereHas('transaksi', function ($q) use ($tglDt) {
                $q->DtBanding($tglDt)->lban($tglDt);
            })->inRandomOrder()->take($dl)->get();

            $r = $f->merge($l)->all();
            $r = collect($r);
            $seleksi = [];
            $r = $r->shuffle();
            foreach ($r as $k) {
                $p = $k->transaksi()->DtBanding($tglDt)->AscTanggal()->get()->toArray();
                $p = collect($p);
                $dd = [];
                foreach ($p as $o) {
                    $dd[] = $o['created_at'];
                }
                $dd = collect($dd);
                $last = $dd->last();
                $near = $dd->take(-2)->first();
                if ($k->transaksi()->DtBanding($tglDt)->lban($tglDt)->first()) {
                    $C = 1;
                } else {
                    $C = 0;
                }
                if (0 == $C) {
                    $akhir = Carbon::createFromDate(substr($tglDt, 0, 4), substr($tglDt, 5, 2), 1);
                    $dekat = Carbon::createFromDate(substr($last, 0, 4), substr($last, 5, 2), substr($last, 8, 2));
                } elseif (1 == $C) {
                    $akhir = Carbon::createFromDate(substr($last, 0, 4), substr($last, 5, 2), substr($last, 8, 2));
                    $dekat = Carbon::createFromDate(substr($near, 0, 4), substr($near, 5, 2), substr($near, 8, 2));
                }
                $R = $dekat->diffInMonths($akhir);
                $F = (int) $k->transaksi()->DtBanding($tglDt)->AscTanggal()->get()->last()->f - $C;
                $M = $k->transaksi->last()->m;
                $seleksi[] = [
                          'kode' => $k->kode_pendonor,
                          'nama' => $k->nama,
                          'jk' => $k->jenis_kelamin,
                          'goldar' => $k->goldar,
                          'umur' => $k->transaksi->last()->umur,
                          'r' => $R,
                          'f' => $F,
                          'm' => $M,
                          'c' => $C,
                          'created_at' => $tglDt.'-01 00:00:00',
                         ];
            }

            Self::truncate();
            Self::insert($seleksi);
        }

        return false;
    }

    public function getHujiAttribute()
    {
        if (in_array((int) $this->m, range(0, 524))) {
            return $huji = 0;
        }

        if (in_array((int) $this->m, range(525, 1924))) {
            if (in_array((int) $this->f, range(0, 1))) {
                if (in_array((int) $this->r, range(0, 0))) {
                    return $huji = 1;
                }
                if (in_array((int) $this->r, range(1, 1))) {
                    return $huji = 0;
                }
                if (in_array((int) $this->r, range(2, 5))) {
                    return $huji = 1;
                }
                if (in_array((int) $this->r, range(6, 100))) {
                    if (in_array((int) $this->umur, range(1, 32))) {
                        return $huji = 1;
                    }
                    if (in_array((int) $this->umur, range(33, 70))) {
                        return $huji = 0;
                    }
                }
            }
            if (in_array((int) $this->f, range(2, 5))) {
                return $huji = 0;
            }
            if (in_array((int) $this->f, range(6, 100))) {
                return $huji = 0;
            }
        }
        if (in_array((int) $this->m, range(1925, 30000))) {
            if (in_array((int) $this->r, range(0, 0))) {
                return $huji = 0;
            }
            if (in_array((int) $this->r, range(1, 1))) {
                return $huji = 0;
            }
            if (in_array((int) $this->r, range(2, 5))) {
                return $huji = 1;
            }
            if (in_array((int) $this->r, range(6, 100))) {
                return $huji = 1;
            }
        }
    }

    public function getPotensialAttribute()
    {
        if ((1 == $this->c) && (1 == $this->huji)) {
            $data['tpT'] = 1;
        } else {
            $data['tpT'] = 0;
        }
        // $tposT += $tpT;

        if ((1 == $this->c) && (0 == $this->huji)) {
            $data['fpT'] = 1;
        } else {
            $data['fpT'] = 0;
        }
        // $fposT += $fpT;

        if ((0 == $this->c) && (0 == $this->huji)) {
            $data['tnT'] = 1;
        } else {
            $data['tnT'] = 0;
        }
        // $tnegT += $tnT;

        if ((0 == $this->c) && (1 == $this->huji)) {
            $data['fnT'] = 1;
        } else {
            $data['fnT'] = 0;
        }
        // $fnegT+=$fnT;

        return $data;
    }

    public function getHasilpotensiAttribute()
    {
        if (($this->potensial['tpT']) || ($this->potensial['tnT'])) {
            return 'POTENSIAL';
        } elseif (($this->potensial['fpT']) || ($this->potensial['fnT'])) {
            return 'TIDAK';
        }
    }

    public static function hasilUji($rows)
    {
        if (in_array((int) $rows->m, range(0, 524))) {
            return $huji = 0;
        }

        if (in_array((int) $rows->m, range(525, 1924))) {
            if (in_array((int) $rows->f, range(0, 1))) {
                if (in_array((int) $rows->r, range(0, 0))) {
                    return $huji = 1;
                }
                if (in_array((int) $rows->r, range(1, 1))) {
                    return $huji = 0;
                }
                if (in_array((int) $rows->r, range(2, 5))) {
                    return $huji = 1;
                }
                if (in_array((int) $rows->r, range(6, 100))) {
                    if (in_array((int) $rows->umur, range(1, 32))) {
                        return $huji = 1;
                    }
                    if (in_array((int) $rows->umur, range(33, 70))) {
                        return $huji = 0;
                    }
                }
            }
            if (in_array((int) $rows->f, range(2, 5))) {
                return $huji = 0;
            }
            if (in_array((int) $rows->f, range(6, 100))) {
                return $huji = 0;
            }
        }
        if (in_array((int) $rows->m, range(1925, 30000))) {
            if (in_array((int) $rows->r, range(0, 0))) {
                return $huji = 0;
            }
            if (in_array((int) $rows->r, range(1, 1))) {
                return $huji = 0;
            }
            if (in_array((int) $rows->r, range(2, 5))) {
                return $huji = 1;
            }
            if (in_array((int) $rows->r, range(6, 100))) {
                return $huji = 1;
            }
        }
    }

    public static function potensialPro($c, $huji)
    {
        if ((1 == $c) && (1 == $huji)) {
            $data['tpT'] = 1;
        } else {
            $data['tpT'] = 0;
        }
        // $tposT += $tpT;

        if ((1 == $c) && (0 == $huji)) {
            $data['fpT'] = 1;
        } else {
            $data['fpT'] = 0;
        }
        // $fposT += $fpT;

        if ((0 == $c) && (0 == $huji)) {
            $data['tnT'] = 1;
        } else {
            $data['tnT'] = 0;
        }
        // $tnegT += $tnT;

        if ((0 == $c) && (1 == $huji)) {
            $data['fnT'] = 1;
        } else {
            $data['fnT'] = 0;
        }
        // $fnegT+=$fnT;

        return $data;
    }

    public static function hasilPotensial($potensial)
    {
        if (($potensial['tpT']) || ($potensial['tnT'])) {
            return 'POTENSIAL';
        } elseif (($potensial['fpT']) || ($potensial['fnT'])) {
            return 'TIDAK';
        }
    }

    public static function csv($query)
    {
        $multiplied = $query->map(function ($item) {
            $data['kode'] = $item->kode;
            $data['nama'] = $item->nama;
            $data['umur'] = $item->umur;
            $data['jk'] = $item->jk;
            $data['goldar'] = $item->goldar;
            $data['r'] = $item->r;
            $data['f'] = $item->f;
            $data['m'] = $item->m;
            $data['c'] = $item->c;
            $data['huji'] = \App\DtLearn::hasilUji($item);
            $data['potensial'] = \App\DtLearn::potensialPro($item->c, $data['huji']);
            $data['hasilpotensi'] = \App\DtLearn::hasilPotensial($data['potensial']);

            return $data;
        });

        return collect($multiplied->all());
    }
}
