<?php

namespace App\Exports;

use App\Models\sganim;
use Illuminate\Contracs\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class SeriesActivas implements FromCollection
{
	use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       return sganim::all();

    }

}
