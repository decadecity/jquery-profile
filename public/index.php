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
</head>
<body>
  <script src="./jquery/jquery-<?php echo $version ?>.min.js"></script>

  <script src="./lib/ua_parser.js"></script>
<script>
var ua = new UAParser;
var browser = ua.getBrowser();
</script>
<pre><script>
document.write('jQuery version: ' + $().jquery + '\n');
document.write('Parse time: ' + (t_end - t_start) + 'ms');
</script>

</pre>
</body>
