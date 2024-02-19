<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class YourDataImport implements ToCollection
{
    protected $allData = [];

    public function collection(Collection $rows)
    {
        $rows = $rows->slice(2);
        foreach ($rows as $row) {
            $this->allData[] = [
                'nama' => $row[1],
                'pangkat' => $row[2],
                'nrp' => $row[3],
                'kesatuan' => $row[4],
                'email' => $row[5],
            ];
        }
    }

    public function getAllData()
    {
        return $this->allData;
    }

}
