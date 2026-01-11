<?php

namespace App\Exports;

use App\Models\ActivityLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ActivityLogsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ActivityLog::with('user')->latest()->get();
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            'ID',
            'Description',
            'Subject',
            'Event Type',
            'User Name',
            'User Email',
            'IP Address',
            'User Agent',
            'Created At',
        ];
    }

    /**
    * @param ActivityLog $log
    * @return array
    */
    public function map($log): array
    {
        return [
            $log->id,
            $log->description,
            $log->subject,
            $log->event_type,
            $log->user ? $log->user->name : 'System',
            $log->user ? $log->user->email : 'N/A',
            $log->ip_address,
            $log->user_agent,
            $log->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
