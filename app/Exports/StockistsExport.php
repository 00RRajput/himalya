<?php

namespace App\Exports;

use App\Models\Retailer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockistsExport implements FromCollection, WithHeadings
{

    private $records;
    public function __construct($records)
    {
        $this->records = $records;
    }

    public function collection()
    {
        $exportData = [];
        // Retrieve data from tbl_retail_sales and tbl_retail_sales_items
        foreach ($this->records as $record) {
            $storePhoto = $record->fld_photo_file ? env('SERVER_BASE_URL') . $record->fld_photo_path . '/' . $record->fld_photo_file : "";
            $googleMapsUrl = $record->fld_lat && $record->fld_long ? "https://www.google.com/maps?q={$record->fld_lat},{$record->fld_long}" : "";
            $converted = ($record->converted === null)  ? "No" : "Yes";
            $data = [
                $record->project_name,
                $record->fld_username,
                $record->fld_state,
                $record->fld_district,
                $record->fld_stockist_name,
                $record->fld_firm_name,
                $record->stockist_number,
                $record->purchase_sum_fld_total,
                date(env('DATE_FORMAT'), strtotime($record->fld_created_at)),
                $storePhoto,
                $googleMapsUrl
            ];
            $exportData[] = $data;
        }
        // Transform data for export

        return collect($exportData);
    }

    public function headings(): array
    {
        $headings = [
            'Project',
            'User name',
            'State',
            'District',
            'Stockist firm name',
            'Stockist name',
            'Phone number',
            'Total Purchase',
            'Date',
            'Store photo',
            'Map'
        ];

        // Add product columns to headings
        return $headings;
    }
}
