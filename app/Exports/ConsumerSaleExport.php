<?php

namespace App\Exports;

use App\Models\ConsumerSale;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ConsumerSaleExport implements FromCollection, WithHeadings
{


    private $records;
    public function __construct($records)
    {
        $this->records = $records;
    }
    public function collection()
    {
        // Retrieve data from tbl_retail_sales and tbl_retail_sales_items

        // Transform data for export
        $exportData = [];
        foreach ($this->records as $consumer) {


            $googleMapsUrl = $consumer->fld_lat && $consumer->fld_long ? "https://www.google.com/maps?q={$consumer->fld_lat},{$consumer->fld_long}" : "";

            $rowData = [
                $consumer->project_name,
                $consumer->consumer_name,
                $consumer->fld_number,
                $consumer->fld_name,
                $consumer->state_name,
                $consumer->district_name,
                $consumer->tehsil_name,
                $consumer->village_name,
                $consumer->fld_remark,
                $consumer->fld_remark2,
                $consumer->fld_remark3,
                date(env('DATE_FORMAT'), strtotime($consumer->fld_created_at)),
                $googleMapsUrl,
                $consumer->fld_total
            ];
            $exportData[] = $rowData;
        }

        return collect($exportData);
    }

    public function headings(): array
    {
        $headings = [
            'Project',
            'Consumer',
            'Mobile',
            'State',
            'District',
            'Tehsil',
            'Village',
            'Remark 1',
            'Remark 2',
            'Remark 3',
            'Date',
            'Map',
            'Total'
        ];

        // Add product columns to headings
        return $headings;
    }
}
