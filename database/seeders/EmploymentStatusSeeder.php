<?php

namespace Database\Seeders;

use App\Modules\EmployeesModule\Models\EmploymentStatus;
use Illuminate\Database\Seeder;

class EmploymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = database_path('data/employment_statuses.csv');

        if (!file_exists($csvPath)) {
            $this->command->warn("Archivo CSV de estados laborales no encontrado: {$csvPath}");
            return;
        }

        $statuses = $this->readCsv($csvPath);

        foreach ($statuses as $status) {
            \Illuminate\Support\Facades\DB::table('employment_statuses')->updateOrInsert(
                ['id' => $status['id']],
                ['name' => $status['name']]
            );
        }

        $this->command->info('Estados laborales sembrados exitosamente.');
    }

    private function readCsv(string $filePath): array
    {
        $data = [];
        $header = null;

        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($row = fgetcsv($handle, 0, ',')) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    if (count($header) === count($row)) {
                        $data[] = array_combine($header, $row);
                    }
                }
            }
            fclose($handle);
        }

        return $data;
    }
}
