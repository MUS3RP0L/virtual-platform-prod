<?php
return array(
 'pdf' => array(
 'enabled' => true,
 'binary' => base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64'),
 'timeout' => false,
 'options' => array(
 	'footer-center' => 'Pagina [page] de [toPage]',
 	'footer-font-size' => 9,
 	'footer-left' => 'PLATAFORMA VIRTUAL DE LA MUTUAL DE SERVICIOS AL POLICIA - 2017'
 ),
 ),
 'image' => array(
 'enabled' => true,
 'binary' => base_path('vendor/h4cc/wkhtmltoimage-amd64/bin/wkhtmltoimage-amd64'),
 'timeout' => false,
 'options' => array(),
 ),
);