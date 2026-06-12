<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\InventarisPeralatan;

$items = InventarisPeralatan::all();
foreach ($items as $item) {
    if ($item->jumlah > 1) {
        $count = $item->jumlah;
        
        $item->jumlah = 1;
        $item->kode_unik_aset = $item->kode_barang . '-001';
        $item->save();
        
        for ($i = 2; $i <= $count; $i++) {
            $newItem = $item->replicate();
            $newItem->kode_unik_aset = $item->kode_barang . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);
            $newItem->save();
        }
        echo "Split item {$item->kode_barang} into {$count} items\n";
    } else {
        if (!$item->kode_unik_aset) {
            $maxCode = InventarisPeralatan::where('kode_barang', $item->kode_barang)
                        ->whereNotNull('kode_unik_aset')
                        ->orderBy('kode_unik_aset', 'desc')
                        ->first();
            $nextIdx = 1;
            if ($maxCode && preg_match('/-(\d+)$/', $maxCode->kode_unik_aset, $m)) {
                $nextIdx = intval($m[1]) + 1;
            }
            $item->kode_unik_aset = $item->kode_barang . '-' . str_pad($nextIdx, 3, '0', STR_PAD_LEFT);
            $item->save();
            echo "Assigned code {$item->kode_unik_aset} to existing item\n";
        }
    }
}
echo "Migration complete\n";
