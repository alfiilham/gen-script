@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Enter Text with Multiple Words</div>

                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="text">Text</label>
                            <textarea class="form-control" id="text" rows="5" placeholder="Enter your text containing multiple words"></textarea>
                        </div>
                    </form>
                    <button class="btn btn-primary" id="extractWordsBtn">Extract Words</button>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <textarea id="wordList" class="form-control" id="text" rows="5"></textarea>
                    <button class="btn btn-primary mt-2" id="copyBtn">Copy</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('extractWordsBtn').addEventListener('click', function() {
    // Get the text from the textarea
    var text = document.getElementById('text').value;
    
    // Split the text into an array of words
    var words = text.split(/\s+/).filter(function(word) {
        return word.trim() !== ''; // Remove any empty strings
    });
    
    function addBackslash(input) {
        return input.replace(/\./g, "\\.");
    }
    // Modify each word and append them back into the textarea
    var newText = '';
    words.forEach(function(word) {
        var modifiedString = addBackslash(word);
        newText += `postqueue -p | tail -n +2 | awk 'BEGIN { RS = "" } /@` + modifiedString + `/ { print $1 }' | tr -d '*!' | postsuper -d -  ;`;
    });
    document.getElementById('wordList').value = newText.trim();
    });

    // Function to copy the words to the clipboard
    document.getElementById('copyBtn').addEventListener('click', function() {
        var wordListText = document.getElementById('wordList').innerText;
        navigator.clipboard.writeText(wordListText).then(function() {
            alert('Words copied to clipboard!');
        }, function(err) {
            console.error('Failed to copy: ', err);
        });
    });
</script>
@endsection
