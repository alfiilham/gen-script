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
        <?php
        $at_position = strpos($data['email'], "@");
        if ($at_position !== false) {
            // Extract the substring before the "@" symbol
            $substring_before_at = substr($data['email'], 0, $at_position);

            // Remove leading zeros if any
            $substring_before_at = ltrim($substring_before_at, "0");

            // Get the length of the remaining string
            $num_digits = strlen($substring_before_at);

            // Check if the number of digits before "@" is not 8
            if ($num_digits !== 8) {
                // Output the email address
                echo $data['email'] . PHP_EOL;
            }
        }
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
