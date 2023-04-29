<?php

if (!function_exists("rupiah")) {
  function rupiah($bilangan) {
    return 'Rp '.number_format($bilangan,0, "", ".");
  }
}
function diskon($bil1, $bil2) {
  if($bil1 == 0 || $bil2 == 0 ) return "Tidak ada diskon";
  return ceil(100 - ($bil1 / $bil2 * 100))."%";
}
?>