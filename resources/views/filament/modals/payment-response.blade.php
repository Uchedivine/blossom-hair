<div class="p-4">
    <h3 class="text-lg font-semibold mb-4">Gateway Response</h3>
    
    @if($response)
        <pre class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg overflow-auto max-h-96 text-sm">{{ json_encode(is_string($response) ? json_decode($response) : $response, JSON_PRETTY_PRINT) }}</pre>
    @else
        <p class="text-gray-500">No gateway response available.</p>
    @endif
</div>
