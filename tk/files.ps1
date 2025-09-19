Get-ChildItem -Path "." -Recurse -Force | ForEach-Object {
    Write-Host "=== $($_.FullName) ===" -ForegroundColor Green
    
    if ($_.PSIsContainer) {
        Write-Host "[Directory]"
    } else {
        try {
            $content = Get-Content -Path $_.FullName -Raw -ErrorAction Stop
            Write-Host $content
        }
        catch {
            Write-Host "[Content cannot be read]"
        }
    }
    
    Write-Host "`n" + ("-" * 80) + "`n"
}