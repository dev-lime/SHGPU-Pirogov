param(
    [string]$Path = ".",
    [switch]$IncludeExtensions = $false,
    [int]$MaxDepth = 0,
    [switch]$IncludeRoot = $true
)

function Format-Tree {
    param(
        [string]$CurrentPath,
        [int]$CurrentDepth = 0,
        [string]$Prefix = "",
        [bool]$IsLast = $true
    )
    
    if ($MaxDepth -gt 0 -and $CurrentDepth -gt $MaxDepth) {
        return
    }
    
    $item = Get-Item $CurrentPath
    $name = if ($item.PSIsContainer) { 
        $item.Name + "/" 
    }
    else { 
        if ($IncludeExtensions) { 
            $item.Name 
        }
        else { 
            [System.IO.Path]::GetFileNameWithoutExtension($item.Name) 
        }
    }
    
    $connector = if ($IsLast) { "$([char]0x2514)$([char]0x2500) " } else { "$([char]0x251C)$([char]0x2500) " }
    $line = if ($IsLast) { "    " } else { "$([char]0x2502)   " }
    
    Write-Output ($Prefix + $connector + $name)
    
    if ($item.PSIsContainer) {
        $children = Get-ChildItem $CurrentPath | Sort-Object Name
        $childCount = $children.Count
        
        for ($i = 0; $i -lt $childCount; $i++) {
            $child = $children[$i]
            $childIsLast = ($i -eq $childCount - 1)
            Format-Tree -CurrentPath $child.FullName -CurrentDepth ($CurrentDepth + 1) -Prefix ($Prefix + $line) -IsLast $childIsLast
        }
    }
}

function Get-RelativeTree {
    param(
        [string]$RootPath
    )
    
    $rootItem = Get-Item $RootPath
    
    if ($IncludeRoot) {
        $rootName = $rootItem.Name + "/"
        Write-Output $rootName
        
        $children = Get-ChildItem $RootPath | Sort-Object Name
        $childCount = $children.Count
        
        for ($i = 0; $i -lt $childCount; $i++) {
            $child = $children[$i]
            $isLast = ($i -eq $childCount - 1)
            Format-Tree -CurrentPath $child.FullName -CurrentDepth 1 -Prefix "" -IsLast $isLast
        }
    }
    else {
        $children = Get-ChildItem $RootPath | Sort-Object Name
        $childCount = $children.Count
        
        for ($i = 0; $i -lt $childCount; $i++) {
            $child = $children[$i]
            $item = Get-Item $child.FullName
            $name = if ($item.PSIsContainer) { 
                $item.Name + "/" 
            }
            else { 
                if ($IncludeExtensions) { 
                    $item.Name 
                }
                else { 
                    [System.IO.Path]::GetFileNameWithoutExtension($item.Name) 
                }
            }
            
            Write-Output $name
        }
    }
}

try {
    $resolvedPath = Resolve-Path $Path -ErrorAction Stop
    Get-RelativeTree -RootPath $resolvedPath.Path
}
catch {
    Write-Error "Ошибка: Неверный путь или недостаточно прав: $Path"
    exit 1
}

# если отключить корень, то программа не заходит во внутренние папки
