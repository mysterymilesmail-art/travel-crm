<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalesStage;

class SalesStageSeeder extends Seeder
{
    public function run(): void
    {
        $stages = [
            'Enquiry',
            'Quotation Given',
            'Follow Up',
            'PO Issued',
            'Advance Payment Received',
            'Full Payment Received',
            'Billing Completed',
        ];

        foreach ($stages as $index => $stage) {
            SalesStage::create([
                'name' => $stage,
                'order' => $index + 1
            ]);
        }
    }
}