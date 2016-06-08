<?php
/**
 * Template Name: Planos 01
 *
 * @package g5PlusFrameWork
 */
global $cupid_data;

get_header();
get_template_part('content','top');
get_template_part('templates/page');
get_footer();
?>

<script type="text/javascript">
  (function (window, $) {
    if (!$) return;

    window.showInternationalPlans = function () {
      displayElements('.plan-international', '.plan-national');
    }

    window.showNationalPlans = function () {
      displayElements('.plan-national', '.plan-international');
    }

    function displayElements(toShow, toHide) {
      $(toShow).show();
      $(toHide).hide();
    }
  })(window, jQuery);
</script>

<?php
$geoip = file_get_contents('http://www.geoplugin.net/json.gp?ip=' . $_SERVER['REMOTE_ADDR']);
$geoip = json_decode($geoip);

$countryCode = strtolower($geoip->geoplugin_countryCode);

// #yolo
if ($countryCode == 'br') {
  echo '<script> showNationalPlans(); </script>';
} else {
  echo '<script> showInternationalPlans(); </script>';
}
?>
