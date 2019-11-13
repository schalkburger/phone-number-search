<?php
if (isset($_POST['submit'])) {
    $text = $_POST['text'];
    $removethis = array(' ', '&nbsp;', '-', '.');
    $output = str_replace($removethis, '', $text);
    $number = $removearea = str_replace('+27', '0', $output);
    if (trim($number) == '' || strlen($number) != 10) {
        $hasError = true;
    } else {
        $format1 = $number; // 0821234567
        $format2 = '%2b27' . substr($number, 1); // 27821234567
        $format3 = '27' . substr($number, 1); // 27821234567
        $format4 = urlencode(substr(wordwrap($text, 3, " ", true), 0, -2) . substr($number, 9)); // 082 123 4567
        $format5 = urlencode(substr(wordwrap($text, 3, "-", true), 0, -2) . substr($number, 9)); // 082-123-4567
        $format6 = urlencode(substr(wordwrap($text, 3, ".", true), 0, -2) . substr($number, 9)); // 082.123.4567
        $GoodtoGo = true;
    }
}
?>
<?php if (isset($hasError)) { //If errors are found ?>
<div class="alert alert-warning mt-2 mb-5">Please enter a number in one of the formats above.</div>
<?php }?>

<form class="form-inline mt-3 mb-3" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
  <div class="form-group mr-md-3 mb-2">
    <input type="tel" name="text" id="number" value="" class="form-control form-control-lg required" placeholder="Phone number">
  </div>
  <button type="submit" id="submit" name="submit" class="button primary mt-md-n2 mx-auto mx-md-0">Search</button>
</form>

<?php if (isset($GoodtoGo) && $GoodtoGo == true) { //If good ?>
<?php
if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
    $uri = 'https://';
} else {
    $uri = 'http://';
}
    $uri .= '//google.com/search?q=' . '"' . $format1 . '"+OR+"' . $format2 . '"+OR+"' . $format3 . '"+OR+"' . $format4 . '"+OR+"' . $format5 . '"+OR+"' . $format6 . '"';
    echo ("<script>location.href = '$uri';</script>");
    exit;}?>
