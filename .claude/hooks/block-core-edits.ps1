# Blocks accidental edits to WordPress core, WooCommerce plugin, or other vendor files.
# Reads Claude Code PreToolUse JSON from stdin.

$inputData = $input | Out-String
try {
    $payload = $inputData | ConvertFrom-Json
} catch {
    exit 0
}

$filePath = $payload.tool_input.file_path
if (-not $filePath) { exit 0 }

# Normalize to forward slashes for consistent matching
$normalizedPath = $filePath -replace '\\', '/'

$blockedPatterns = @(
    '/wp-includes/',
    '/wp-admin/',
    '/plugins/woocommerce/',
    '/plugins/advanced-custom-fields',
    '/plugins/advanced-custom-fields-pro'
)

foreach ($pattern in $blockedPatterns) {
    if ($normalizedPath -like "*$pattern*") {
        Write-Error "BLOCKED: Cannot edit core/vendor file: $filePath`nEdit via hooks/filters or child theme overrides instead."
        exit 1
    }
}

exit 0
