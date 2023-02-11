<?php

if (!function_exists("rupiah")) {
  function rupiah($bilangan) {
    return number_format($bilangan,0, "", ".");
  }
}
?>