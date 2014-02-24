<?php
header('Content-type: application/json');

/**
 * Handles returning an HTTP error code and exiting.
 *
 * @param $code {integer} HTTP error code
 */
function error($code) {
  $code = (int) $code;
  switch ($code) {
    case 400:
      $description = 'Bad Request';
      break;
    case 404:
      $description = 'Not Found';
      break;
    case 405:
      $description = 'Method Not Allowed';
      break;
    default:
      $description = 'Server Error';
  }
  header("HTTP/1.1 $code $description");
  exit();
}

if (!isset($_SERVER['REQUEST_METHOD'])) {
  error(500);
} else if (in_array($_SERVER['REQUEST_METHOD'], array('GET', 'POST'))) {
  $request = $_GET;
} else {
  error(405);
}

$incoming = json_decode(file_get_contents("php://input"), true);
if (gettype($incoming) != 'array') {
  // Probably an error in json_decode - it seems to fail silently.
  error(400);
}

$data_file = './data/results.json';

if (!file_exists($data_file)) {
  $data = '[]';
} else {
  $data = file_get_contents($data_file);
}
$data = json_decode($data);
$data[] = $incoming;
file_put_contents($data_file, json_encode($data, JSON_PRETTY_PRINT));

//var_dump($incoming);

?>
