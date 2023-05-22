<?php

namespace App\Exports;

use App\Models\KopKartuAngsuran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class KartuAngsuranExport implements FromView
{
    use Exportable;

    protected $no_rekening, $format;

    function __construct($no_rekening, $format)
    {
        $this->no_rekening = $no_rekening;
        $this->format = $format;
    }

    function view(): View
    {
        $format = $this->format;

        $show = KopKartuAngsuran::get_history_financing($this->no_rekening);
        $detail = KopKartuAngsuran::get_detail_profile($this->no_rekening);

        return view('kartuangsuran', [
            'format' => $format,
            'kartuangsuran' => $show,
            'detail' => $detail
        ]);
    }
}
