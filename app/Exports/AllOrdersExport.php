<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use phpDocumentor\Reflection\File;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AllOrdersExport implements FromView , WithHeadings , ShouldAutoSize , WithCustomCsvSettings
{

    public $data;


    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getCsvSettings() : array {
        return [
            'delimiter'              => ',',
            'enclosure'              => '"',
            'line_ending'            => PHP_EOL,
            'use_bom'                => false,
            'include_separator_line' => true,
            'excel_compatibility'    => true,
        ];
    }


    public function title(): string{
        return "Orders";
    }


    public function headings():array{
        return[
            translate('Client') ,
            translate('Address'),
            translate('Phone'),
            translate('City'),
            translate('Price'),
            translate('storage icon'),
            translate('Order Code'),
            translate('Date')
        ];
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->orders;
    }






    public function view() : View{
        return view('admin.sales.all_orders.export' ,  $this->data);
    }
}


