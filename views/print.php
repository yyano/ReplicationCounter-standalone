<?php
// require '../vendor/autoload.php';

use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\CapabilityProfile;

if (isset($request)) {
    $connector = new FilePrintConnector($lpPath ?? "/dev/usb/lp1");
    $profile = CapabilityProfile::load($model ?? "CT-S651");
    $printer = new Printer($connector, $profile);

    $printer->setJustification(Printer::JUSTIFY_CENTER);
    
    $printer->setTextSize(2, 3);
    $printer->setEmphasis(true);
    $printer->text(sprintf("%s\n", $title));
    $printer->setEmphasis(false);
    $printer->setTextSize(1, 1);
    $printer->feed();

    if(isset($request['inputValue']) && $request['inputValue'] != '') {
        $size = 10 - floor(strlen($request['inputValue']) / 20);
        $size = 10 < $size ? 10 : $size;

        $printer->qrCode($request['inputValue'], Printer::QR_ECLEVEL_M, $size, Printer::QR_MODEL_2);
        $printer->feed();
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text(sprintf("%s\n", trim($request['inputValue'])));
        $printer->feed();
    }

    $counter = $request['counter'] ?? $counter ?? 0;
    $prefix = $request['prefix'] ?? $prefix ?? "";

    if($counter != 0) {
        if(isset($prefix) && $prefix != '') {
            $txtCounter = sprintf("%s-%04d", strtoupper($prefix), $counter );
        } else {
            $txtCounter = sprintf("%04d", $counter);
        }
        $printer->setJustification(Printer::JUSTIFY_CENTER);

        $spacer = str_repeat(" ", 10 - floor(strlen($txtCounter)/2));
        $printer->setReverseColors(true);
        $printer->setTextSize(2, 2);
        $printer->text(sprintf("%s%s%s\n", $spacer, str_repeat(" ", strlen($txtCounter)), $spacer));
        $printer->text(sprintf("%s%s%s\n", $spacer, $txtCounter, $spacer));
        $printer->text(sprintf("%s%s%s\n", $spacer, str_repeat(" ", strlen($txtCounter)), $spacer));
        $printer->setTextSize(1, 1);
        $printer->setReverseColors(false);
        $printer->feed();

        $printer->setBarcodeHeight(80);
        $printer->barcode($txtCounter, Printer::BARCODE_CODE39);
        $printer->feed();
    }
    // $printer->setLineSpacing(20);

    $date = new DateTime('now');
    $date->setTimezone(new DateTimeZone($timezone ?? 'UTC'));

    $datetime = $date->format($datetimeFormat ?? 'Y-m-d H:i:s',);
    $printer->setJustification(Printer::JUSTIFY_RIGHT);
    $printer->text(sprintf("%s\n", $datetime));

    $printer->cut();
    $printer->close();

    echo "<p>Printed ($datetime)</p>";
} else {
    echo "<p>no print<p>";
};
