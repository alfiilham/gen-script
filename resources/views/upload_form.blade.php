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

                        <form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="file">Choose Excel File</label>
                                <input type="file" class="form-control-file" name="file" accept=".xlsx, .xls">
                            </div>
                            <div class="form-group">
                                <label for="pw">Input Password</label>
                                <input type="text" class="form-control" id="pw" name="pw">
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Your Blade View -->
<div class="mt-5">
    @if(empty($importedData))
        <p>No data imported yet.</p>
    @else
        @php
            $allResults = '';
            $allEmailResults = '';
            $allRenameEmail = '';
        @endphp

        @foreach($importedData as $data)
            
            <?php
            $commaPosition = strpos($data['nama'], ',');
            if ($commaPosition !== false) {
                $name = substr($data['nama'], 0, $commaPosition);
                $nameWithoutTitles = trim($name);
            }else{
                $nameWithoutTitles = $data['nama'];
            }
            $nameParts = explode(" ",$nameWithoutTitles);
            $gName = $nameParts[0];
            $sName = end($nameParts);
            $lowercaseName = strtolower($nameWithoutTitles);
            $nameParts = explode(" ", $lowercaseName);
            $lastname = end($nameParts);
            $angka = substr($data['nrp'], 0, 5);
            $emailAlias = $nameParts[0].'.'.$lastname.$angka.'@polri.go.id';
            $email = $data['nrp'].'@polri.go.id';
            $pass = $pw;
            ?>
            @php
                $result = "zmprov ca $email $pass cn '$data[nama]' displayName '$data[nama]' givenName $gName sn $sName description '$data[kesatuan]' ; zmprov aaa $email $emailAlias ";
                $allResults .= $result . PHP_EOL;
                $emailResult = "$email";
                $allEmailResults .= $emailResult . PHP_EOL;
                $RenameEmail = "yes | zmprov RenameAccount '$data[email]' $email ; zmprov AddAccountAlias $email '$data[email]'";
                $allRenameEmail .= $RenameEmail . PHP_EOL;
            @endphp

        @endforeach
        <div class="input-group mb-3">
            <textarea class="form-control" rows="10">{{ $allResults }}</textarea>
            <button class="btn btn-outline-secondary" type="button" data-clipboard-text="{{ $allResults }}">Copy All</button>
        </div>
        <div class="input-group mb-3">
            <textarea class="form-control" rows="10">{{ $allEmailResults }}</textarea>
            <button class="btn btn-outline-secondary" type="button" data-clipboard-text="{{ $allEmailResults }}">Copy All</button>
        </div>
        <div class="input-group mb-3">
            <textarea class="form-control" rows="10">{{ $allRenameEmail}}</textarea>
            <button class="btn btn-outline-secondary" type="button" data-clipboard-text="{{ $allRenameEmail }}">Copy All</button>
        </div>
    @endif
</div>

<script>
    // Initialize Clipboard.js
    new ClipboardJS('.btn-outline-secondary');
</script>

@endsection
