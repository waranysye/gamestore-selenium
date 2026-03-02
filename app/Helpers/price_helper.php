<?php
function rupiah($price)
{
    return 'Rp ' . number_format($price, 0, ',', '.');
}