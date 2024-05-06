<?php

namespace App\Exports;

use App\Models\PurchaseDetail;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchaseSaleExport implements FromCollection, WithHeadings
{
    private $ids;
    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }
    public function collection()
    {
        // Retrieve data from tbl_retail_sales and tbl_retail_sales_items
        $salesData = PurchaseDetail::with('items')->wherein('fld_prid', $this->ids)->orderby('fld_date', 'desc')->get();

        // Transform data for export
        $exportData = [];
        foreach ($salesData as $sale) {

            $stockiestPhoto = $sale->stockiest->fld_photo_file ? env('SERVER_BASE_URL') . $sale->stockiest->fld_photo_path . '/' . $sale->stockiest->fld_photo_file : "";

            $billPhoto = $sale->fld_bill_photo_file ? env('SERVER_BASE_URL') . $sale->fld_bill_photo_path . '/' . $sale->fld_bill_photo_file : "";

            $googleMapsUrl = $sale->stockiest->fld_lat && $sale->stockiest->fld_long ? "https://www.google.com/maps?q={$sale->stockiest->fld_lat},{$sale->stockiest->fld_long}" : "";

            $rowData = [
                $sale->stockiest->state->fld_state,
                $sale->attenUser->fld_name,
                $sale->stockiest->district->fld_district,
                $sale->stockiest->fld_firm_name,
                $sale->stockiest->fld_stockist_name,
                $sale->stockiest->fld_number,
                $sale->fld_total,
                $sale->fld_date,
                $stockiestPhoto,
                $billPhoto,
                $googleMapsUrl,
            ];

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

            $exportData[] = array_merge($rowData, $productColumns);
        }

        return collect($exportData);
    }

    public function headings(): array
    {
        $headings = [
            'State',
            'Field User',
            'District',
            'Firm Name',
            'Stockiest Name',
            'Mobile',
            'Purchase amount',
            'Purchase Date',
            'Stockiest Photo',
            'Bill Photo',
            'Stockiest Map',
        ];

        // Add product columns to headings
        return array_merge($headings, $this->getProductColumns());
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
}
