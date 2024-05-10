<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class NewDataImport implements ToCollection
{
    protected $allData = [];

    public function collection(Collection $rows)
    {
        $rows = $rows->slice(1);
        foreach ($rows as $row) {
            $this->allData[] = [
                'email' => $row[0],
            ];
        }
    }

    public function getAllData()
    {
        return $this->allData;
    }

}
