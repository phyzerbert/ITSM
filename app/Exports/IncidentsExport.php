<?php

namespace App\Exports;

use App\Incident;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IncidentsExport implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $data = $this->data;
        $incidents = array();
        $i = 0;
        foreach ($data as $item) {
            $incidents[$i] = array();
            $incidents[$i]['no'] = $item->id;
            $incidents[$i]['short_description'] = $item->short_description;
            $incidents[$i]['description'] = $item->description;
            $incidents[$i]['priority'] = $item->priority;
            $incidents[$i]['assignment_group'] = $item->group->name ?? '';
            $incidents[$i]['resolved_by'] = $item->resolved_user->name ?? '';

            $incidents[$i]['opened_at'] = date('m/d/Y H:i', strtotime($item->created_at));

            if($item->resolved_at){
                $incidents[$i]['resolved_at'] = date('m/d/Y H:i', strtotime($item->resolved_at));
            }else{
                $incidents[$i]['resolved_at'] = '';
            }

            $i++;
        }
        return $incidents;
    }

    public function headings(): array
    {
        return [
            'No',
            'Short Description',
            'Fault Description',
            'Priority',
            'Assignment Group',
            'Resolved By',
            'Opened At',
            'Resolved At',
        ];
    }
}
