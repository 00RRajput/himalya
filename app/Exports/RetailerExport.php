<?php

namespace App\Exports;

use App\Models\Retailer;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RetailerExport implements FromCollection, WithHeadings
{

    private $records;
    private $project_id;
    public function __construct($records, $project_id)
    {
        $this->records = $records;
        $this->project_id = $project_id;
    }

    public function collection()
    {
        $exportData = [];
        // Retrieve data from tbl_retail_sales and tbl_retail_sales_items
        foreach ($this->records as $record) {
            $storePhoto = $record->fld_photo_file ? env('SERVER_BASE_URL') . $record->fld_photo_path . '/' . $record->fld_photo_file : "";
            $googleMapsUrl = $record->fld_lat && $record->fld_long ? "https://www.google.com/maps?q={$record->fld_lat},{$record->fld_long}" : "";
            $converted = ($record->retail_sale_count_sum_fld_total === null)  ? "No" : "Yes";
            $data = [
                $record->project_name,
                $record->fld_state,
                $record->fld_district,
                $record->fld_store_name,
                $record->fld_owner_name,
                $record->fld_number,
                $converted,
                $record->retail_sale_count_sum_fld_total,
                $record->shop_type,
                $record->fld_tehsil,
                $record->fld_village,

            ];
            $ans = [];
            $userAnsers = $this->getUserAnser($record);
            $cols = $this->getColumns();
            foreach ($cols as $key => $col) {
                $ans[] = isset($userAnsers[$key]) ? $userAnsers[$key] : '';
            }


            $rows =  array_merge($data, $ans);
            $data =  array_merge($rows, [
                $record->fld_comments_1,
                $record->fld_comments_2,
                $record->fld_comments_3,
                $storePhoto,
                $googleMapsUrl
            ]);
            $exportData[] = $data;
        }
        // Transform data for export


        return collect($exportData);
    }

    public function headings(): array
    {
        $headings = [
            'Project',
            'State',
            'District',
            'Store name',
            'Owner name',
            'Phone number',
            'Converted',
            'Total Sale',
            'Type',
            'Tehsil/town',
            'Village name',


        ];

        // Add product columns to headings
        $rows =  array_merge($headings, $this->getColumns());
        return array_merge($rows, [
            'Remark 1',
            'Remark 2',
            'Remark 3',
            'Store photo',
            'Map'
        ]);
    }

    function getUserAnser($record)
    {

        return  DB::table('retailers_fields')->where(['fld_rid' => $record->fld_rid, 'fld_pid' => $this->project_id])->orderBy('fld_cfid', 'asc')->pluck('fld_choice', 'fld_cfid')->toArray();
    }

    private function getColumns(): array
    {
        return DB::table('x_fields')->orderBy('fld_cfid', 'asc')->where(['fld_pid' => $this->project_id, 'fld_status' => 1])->pluck('fld_question', 'fld_cfid')->toArray();
    }
}
