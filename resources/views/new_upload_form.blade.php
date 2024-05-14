<!-- upload_form.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload Excel File</div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('newupload') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="file">Choose Excel File</label>
                                <input type="file" class="form-control-file" name="file" accept=".xlsx, .xls">
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                            <a href="{{ route('download.new.sample.excel') }}" class="btn btn-primary">Download Sample Excel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Your Blade View -->
<div class="mt-5">
    @if(empty($importedData))
        <p class="text-center">No data imported yet.</p>
    @else
        @php
            $allResults = '';
        @endphp

        @foreach($importedData as $data)
        @if (is_null($data['nama']))
            @continue
        @endif
        <?php

        $parts = explode("@", $data['email']);
        $nrp = $parts[0];
        $commaPosition = strpos($data['nama'], ',');
        if ($commaPosition !== false) {
            $name = substr($data['nama'], 0, $commaPosition);
            $nameWithoutTitles = trim($name);
        }else{
            $nameWithoutTitles = trim($data['nama']);
        }
        $namaBaru = rtrim($nameWithoutTitles, ".");
        $nama = str_replace("'", "", $namaBaru);
        $name=trim($nama);
        $lowercaseName = strtolower($nama);
        $OldnameParts = explode(" ",$lowercaseName);
        $nameParts = array_filter($OldnameParts);
        $output = "";
        foreach ($nameParts as $kata) {
            if (strlen($kata) >= 3) {
                $output .= $kata . ".";
            }
        }
        $newOutput = explode(".",$output);
        $names = array_filter($newOutput);
        $gName = reset($names);
        $sName = end($names);
        $angka = substr($nrp, 0, 5);
        $emailAlias = $gName.'.'.$sName.$angka.'@polri.go.id';
        $CreateAliasEmail = "zmprov aaa '$data[email]' $emailAlias;".'echo "done add alias '.$data['email'].'";';
        $allResults .= $CreateAliasEmail . PHP_EOL;
        ?>
        @endforeach

        <div class="input-group mb-3">
            <textarea class="form-control" rows="10">{{ $allResults }}</textarea>
            <button class="btn btn-outline-secondary" type="button" data-clipboard-text="{{ $allResults }}">Copy All</button>
        </div>
    @endif
</div>

<script>
    // Initialize Clipboard.js
    new ClipboardJS('.btn-outline-secondary');
</script>

@endsection
