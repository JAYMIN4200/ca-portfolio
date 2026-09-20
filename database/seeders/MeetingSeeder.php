<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Meeting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MeetingSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('is_admin', true)->first();

        $meetings = [
            ['client' => 'ramesh@balajitraders.in', 'name' => 'Ramesh Patel', 'email' => 'ramesh@balajitraders.in', 'phone' => '+91 98250 12345', 'title' => 'GST return review for the month', 'days' => -8, 'time' => '10:30', 'type' => 'in_person', 'status' => 'completed', 'location' => 'Client office, Ahmedabad'],
            ['client' => 'priya@shahassociates.co.in', 'name' => 'Priya Shah', 'email' => 'priya@shahassociates.co.in', 'phone' => '+91 97270 44556', 'title' => 'Audit planning discussion', 'days' => -3, 'time' => '16:00', 'type' => 'online', 'status' => 'completed', 'location' => 'Google Meet'],
            ['client' => 'amit@desaiconsultants.com', 'name' => 'Amit Desai', 'email' => 'amit@desaiconsultants.com', 'phone' => '+91 99090 77889', 'title' => 'Income tax notice response walkthrough', 'days' => 1, 'time' => '11:30', 'type' => 'in_person', 'status' => 'confirmed', 'location' => 'Our office'],
            ['client' => 'kiran@kirantextiles.in', 'name' => 'Kiran Joshi', 'email' => 'kiran@kirantextiles.in', 'phone' => '+91 90999 33445', 'title' => 'Input credit reconciliation review', 'days' => 2, 'time' => '14:00', 'type' => 'phone', 'status' => 'pending', 'location' => null],
            ['client' => 'neel@trivedico.in', 'name' => 'Neel Trivedi', 'email' => 'neel@trivedico.in', 'phone' => '+91 98450 66778', 'title' => 'Monthly MIS presentation', 'days' => 4, 'time' => '12:00', 'type' => 'online', 'status' => 'confirmed', 'location' => 'Zoom'],
            ['client' => 'sunita@mehtaindustries.com', 'name' => 'Sunita Mehta', 'email' => 'sunita@mehtaindustries.com', 'phone' => '+91 99740 11223', 'title' => 'ROC filing document collection', 'days' => 6, 'time' => '15:30', 'type' => 'in_person', 'status' => 'pending', 'location' => 'Client office, Gandhinagar'],
            ['client' => 'amit@desaiconsultants.com', 'name' => 'Amit Desai', 'email' => 'amit@desaiconsultants.com', 'phone' => '+91 99090 77889', 'title' => 'Advance tax computation call', 'days' => 9, 'time' => '09:30', 'type' => 'phone', 'status' => 'confirmed', 'location' => null],
            ['client' => 'ramesh@balajitraders.in', 'name' => 'Ramesh Patel', 'email' => 'ramesh@balajitraders.in', 'phone' => '+91 98250 12345', 'title' => 'Annual finalisation kickoff', 'days' => 12, 'time' => '11:00', 'type' => 'in_person', 'status' => 'pending', 'location' => 'Our office'],
            ['client' => null, 'name' => 'Harsh Vora', 'email' => 'harsh.vora@example.com', 'phone' => '+91 90000 54321', 'title' => 'Initial consultation for GST registration', 'days' => 3, 'time' => '17:00', 'type' => 'online', 'status' => 'pending', 'location' => 'Google Meet'],
            ['client' => 'sunita@mehtaindustries.com', 'name' => 'Sunita Mehta', 'email' => 'sunita@mehtaindustries.com', 'phone' => '+91 99740 11223', 'title' => 'Quarterly TDS review (rescheduled)', 'days' => -5, 'time' => '13:00', 'type' => 'online', 'status' => 'cancelled', 'location' => 'Zoom'],
        ];

        foreach ($meetings as $data) {
            $client = $data['client'] ? Client::where('email', $data['client'])->first() : null;

            Meeting::updateOrCreate(
                ['email' => $data['email'], 'title' => $data['title']],
                [
                    'user_id' => $admin?->id,
                    'client_id' => $client?->id,
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                    'meeting_date' => Carbon::today()->addDays($data['days'])->toDateString(),
                    'start_time' => $data['time'],
                    'end_time' => null,
                    'type' => $data['type'],
                    'location' => $data['location'],
                    'status' => $data['status'],
                    'notes' => null,
                ]
            );
        }
    }
}
