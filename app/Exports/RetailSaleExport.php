<?php

namespace App\Exports;

use App\Models\RetailSale;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RetailSaleExport implements FromCollection, WithHeadings
{

    private $ids;
    private $project_id;
    public function __construct(array $ids, $project_id)
    {
        $this->ids = $ids;
        $this->project_id = $project_id;
    }

    public function collection()
    {

        // Retrieve data from tbl_retail_sales and tbl_retail_sales_items
        $salesData = RetailSale::with('items')->wherein('fld_rsid', $this->ids)->orderby('fld_date', 'desc')->get();
        // Transform data for export
        $exportData = [];
        foreach ($salesData as $sale) {
            $storePhoto = $sale->retailer->fld_photo_file ? env('SERVER_BASE_URL') . $sale->retailer->fld_photo_path . '/' . $sale->retailer->fld_photo_file : "";

            $billPhoto = $sale->fld_bill_photo_file ? env('SERVER_BASE_URL') . $sale->fld_bill_photo_path . '/' . $sale->fld_bill_photo_file : "";

            $googleMapsUrl = $sale->fld_lat && $sale->fld_long ? "https://www.google.com/maps?q={$sale->fld_lat},{$sale->fld_long}" : "";

            $rowData = [
                $sale->retailer->state->fld_state,
                $sale->user->fld_name,
                $sale->retailer->district->fld_district,
                $sale->retailer->tehsil->fld_tehsil,
                $sale->retailer->village->fld_village,
                $sale->retailer->fld_store_name,
                $sale->retailer->fld_owner_name,


            ];


            $ans = [];
            $userAnsers = $this->getUserAnser($sale);
            $cols = $this->getColumns();
            foreach ($cols as $key => $col) {
                $ans[] = isset($userAnsers[$key]) ? $userAnsers[$key] : '';
            }

            // Insert the new key-value pairs into the original array
            //  $rowData =    array_splice($rowData, $insertIndex, 0, $ans);
            $rowData = array_merge($rowData, $ans);
            $midC = [
                $sale->retailer->fld_type === 1 ? "Retailer" : "Retailer",
                $sale->retailer->fld_number,
                $sale->fld_total,
                date(env('DATE_FORMAT'), strtotime($sale->fld_date))
            ];
            $rowData = array_merge($rowData, $midC);

            // Initialize product columns with default value 0
            $productColumns = array_fill_keys($this->getProductColumns(), "0");

            // Populate product columns based on sales items
            foreach ($sale->items as $item) {
                $productName = $item->product->fld_name;
                $quantity = isset($item->fld_qty) ? $item->fld_qty : 0;
                $price = isset($item->fld_price) ? $item->fld_price : 0;
                $productColumns["Quantity - $productName"] += $quantity;
                $productColumns["Sales - $productName (Rs)"] += $price;
            }
            // Fill remaining product columns with 0
            foreach ($productColumns as $columnName => $value) {
                if (!$value) {
                    $productColumns[$columnName] = "0";
                }
            }

            $valueRows = array_merge($rowData, $productColumns);
            $endColumn = [
                $storePhoto,
                $billPhoto,
                $sale->retailer->fld_comments_1,
                $sale->retailer->fld_comments_2,
                $sale->retailer->fld_comments_3,
                $googleMapsUrl
            ];
            $exportData[] = array_merge($valueRows, $endColumn);
        }

        return collect($exportData);
    }

    public function headings(): array
    {
        $headings = [
            'State',
            'Field User',
            'District',
            'Town',
            'Location',
            'Outlet Name',
            'Owner Name',

        ];


        $headings3 =  array_merge($headings, $this->getColumns());

        $headings4 = [
            'Type',
            'Mobile',
            'Total Retailer Sale(Rs.)',
            'Order date'
        ];
        // Add product columns to headings
        $headings5 =  array_merge($headings3, $headings4);
        $headings6 =  array_merge($headings5, $this->getProductColumns());
        return array_merge($headings6, [
            'Store Photo',
            'Bill Photo',
            'Remark 1',
            'Remark 2',
            'Remark 3',
            'Map',
        ]);
    }

    private function getProductColumns(): array
    {
        // Fetch product names dynamically from your database
        // Adjust this according to your actual implementation
        $productNames = Product::pluck('fld_name')->toArray();
        // Generate column names for each product
        $productColumns = [];
        foreach ($productNames as $productName) {
            $productColumns[] = "Quantity - $productName";
            $productColumns[] = "Sales - $productName (Rs)";
        }
        return $productColumns;
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
