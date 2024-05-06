<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\RetailSale;
use App\Models\Product;
use App\Models\Summary;
use App\Models\UserSummary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromCollection, WithHeadings
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
        foreach ($this->records as $record) {

            $photo = $record->fld_photo_file ? env('SERVER_BASE_URL') . $record->fld_photo_path . '/' . $record->fld_photo_file : "";
            $rowData = [
                $record->project->fld_name,
                $record->state->fld_state,
                $record->attenUser->fld_name,
                date(env('TIME_FORMAT', 'h:i a, ') . env('DATE_FORMAT'), strtotime($record->fld_datetime)),
                $record->fld_comment,


            ];
            $ans = [];
            $userAnsers = $this->getUserAnser($record);
            $cols = $this->getColumns();
            foreach ($cols as $key => $col) {
                $ans[] = isset($userAnsers[$key]) ? $userAnsers[$key] : '';
            }


            $rows =  array_merge($rowData, $ans);
            $data =  array_merge($rows, [
                $photo,
                "http://maps.google.com/?q={$record->fld_lat},{$record->fld_long}"
            ]);
            $exportData[] = $data;
        }


        return collect($exportData);
    }

    public function headings(): array
    {
        $headings = [
            'Project',
            'State',
            'Field User',
            'Start Time',
            'Remark',

        ];

        // Add product columns to headings
        $rows =  array_merge($headings, $this->getColumns());
        return array_merge($rows, [
            'Photo',
            'Map link'
        ]);
    }

    function getUserAnser($record)
    {

        return  UserSummary::where(['fld_uid' => $record->fld_uid, 'fld_pid' => $record->fld_pid, 'fld_date' => date('Y-m-d', strtotime($record->fld_datetime))])->orderBy('fld_scfid', 'asc')->pluck('fld_comment', 'fld_scfid')->toArray();
    }

    private function getColumns(): array
    {
        return Summary::orderBy('fld_scfid', 'asc')->where(['fld_pid' => $this->project_id, 'fld_status' => 1])->pluck('fld_question', 'fld_scfid')->toArray();
    }
}
