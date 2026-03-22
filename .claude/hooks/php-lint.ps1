# Reads Claude Code's PostToolUse JSON from stdin and runs php -l on .php files
$input = $stdin | Out-String
$payload = $input | ConvertFrom-Json

$filePath = $payload.tool_input.file_path

if (-not $filePath) { exit 0 }
if ($filePath -notlike "*.php") { exit 0 }
if (-not (Test-Path $filePath)) { exit 0 }

$result = & php -l $filePath 2>&1
$exitCode = $LASTEXITCODE

Write-Output $result

exit $exitCode
