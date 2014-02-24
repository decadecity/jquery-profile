<!DOCTYPE html>
<?php
$version = '1.11.0';
if (isset($_GET['v'])) {
  if ($_GET['v'] == 2) {
    $version = '2.1.0';
  }
}
?>
<head>
  <title>jQuery parse time</title>
  <script src="./jquery/jquery-<?php echo $version ?>.min.js"></script>
</head>
<body>

  <form id="device-form">
    <label>Device name: <input type="text" id="device"/></label>
    <input type="hidden" value="<?php echo ($_GET['v'] or 1) ?>" name="v"/>
    <input type="submit" value="Go"/>
  </form>

  <script src="./lib/ua_parser.js"></script>
  <script src="./lib/cookies.js"></script>
  <script>
var ua = new UAParser;

var device = $('#device').val();
if (!device && DECADE_CITY.COOKIES.hasItem('device')) {
  $('#device').val(DECADE_CITY.COOKIES.getItem('device'));
}

$('#device-form').on('submit', function (e) {
  DECADE_CITY.COOKIES.setItem('device', $('#device').val(), 60 * 60 * 24 * 7);
});

device = DECADE_CITY.COOKIES.getItem('device');

if (device) {
  $.ajax({
    url: 'logger.php',
    type: 'post',
    dataType: 'json',
    data: JSON.stringify({
      'jquery': $().jquery,
      'parse_time': t_end - t_start,
      'browser': ua.getResult(),
      'device': device
    })
  });
}
  </script>
<pre><script>
document.write('Time taken to parse jQuery: ' + (t_end - t_start) + 'ms');
</script></pre>
</body>
