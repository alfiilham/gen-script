<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class NewDataImport implements ToCollection,WithChunkReading
{
    protected $allData = [];

    public function collection(Collection $rows)
    {
        $rows = $rows->slice(2);
        foreach ($rows as $row) {
            $this->allData[] = [
                'email' => $row[1],
                'nama' => $row[2],
            ];
        }
    }

    public function getAllData()
    {
        return $this->allData;
    }

    public function chunkSize(): int
    {
        return 60000;
    }
    
}
