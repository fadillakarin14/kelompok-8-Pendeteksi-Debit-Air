<?php
function tentukanStatusAir($volume)
{
    if ($volume <= 150) {
        return 'HAMPIR HABIS';
    } elseif ($volume <= 300) {
        return 'SEDANG';
    } else {
        return 'PENUH';
    }
}

function warnaStatusAir($status)
{
    switch ($status) {
        case 'HAMPIR HABIS':
            return 'danger';
        case 'SEDANG':
            return 'warning';
        case 'PENUH':
            return 'success';
        default:
            return 'secondary';
    }
}
function emojiStatusAir($status)
{
    switch ($status) {
        case 'HAMPIR HABIS':
            return '🔴';
        case 'SEDANG':
            return '🟡';
        case 'PENUH':
            return '🟢';
        default:
            return '⚪';
    }
}

function persentaseVolume($volume)
{
    $persen = ($volume / KAPASITAS_MAKSIMUM_ML) * 100;
    $persen = max(0, min(100, $persen)); // clamp 0 - 100
    return round($persen, 1);
}

function sensorOnline($lastTimestamp)
{
    if (!$lastTimestamp) {
        return false;
    }
    $lastTime = strtotime($lastTimestamp);
    $now = time();
    return ($now - $lastTime) <= SENSOR_TIMEOUT_SECONDS;
}
function cekNotifikasi($volume)
{
    if ($volume >= VOLUME_HAMPIR_PENUH) {
        return [
            'type' => 'warning',
            'message' => '⚠ Tangki Hampir Penuh'
        ];
    } elseif ($volume <= VOLUME_HAMPIR_HABIS) {
        return [
            'type' => 'danger',
            'message' => '⚠ Air Hampir Habis'
        ];
    }
    return null;
}function formatTanggalIndo($datetime)
{
    $bulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    $ts = strtotime($datetime);
    return date('j', $ts) . ' ' . $bulan[(int)date('n', $ts)] . ' ' . date('Y', $ts);
}

function jsonResponse($data, $statusCode = 200)
{
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
