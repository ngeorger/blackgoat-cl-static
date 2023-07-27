<?php
/**
 * @package Unlimited Elements
 * @author UniteCMS.net
 * @copyright (C) 2017 Unite CMS, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
defined('UNLIMITED_ELEMENTS_INC') or die('Restricted access');

$bottomLineClass = "";
if($view == "layout")
    $bottomLineClass = " unite-position-right";

 ob_start();
 
 self::requireView($view);
 
 $htmlView = ob_get_contents();
 
 ob_end_clean();
    
 $htmlClassAdd = "";
 if(!empty($view)){
 	$htmlClassAdd = " unite-view-{$view}";
 	$bottomLineClass .= " unite-view-{$view}";
 }
 
?>

<?php HelperHtmlUC::putGlobalsHtmlOutput(); ?>

	<script type="text/javascript">
		var g_view = "<?php echo self::$view?>";
	</script>

<?php HelperHtmlUC::putInternalAdminNotices()?>


<div id="viewWrapper" class="unite-view-wrapper unite-admin unite-inputs <?php echo do_shortcode($html)ClassAdd?>">

<?php
	echo UniteProviderFunctionsUC::escCombinedHtml($htmlView);
	
	//include provider view if exists
	$filenameProviderView = GlobalsUC::$pathProviderViews.$view.".php";
	if(file_exists($filenameProviderView))
		require_once($filenameProviderView);
?>

</div>

<?php 
	$filepathProviderMasterView = GlobalsUC::$pathProviderViews."master_view.php";
	if(file_exists($filepathProviderMasterView))
		require_once $filepathProviderMasterView;
		
?>

<?php if(GlobalsUC::$blankWindowMode == false):?>

<?php HelperHtmlUC::putFooterAdminNotices() ?>


<div id="uc_dialog_version" title="<?php esc_html_e("Version Release Log. Current Version: ".UNLIMITED_ELEMENTS_VERSION." ", "unlimited_elements")?>" style="display:none;">
	<div class="unite-dialog-inside">
		<div id="uc_dialog_version_content" class="unite-dialog-version-content">
			<div id="uc_dialog_loader" class="loader_text"><?php esc_html_e("Loading...", "unlimited_elements")?></div>
		</div>
	</div>
</div>

<div class="unite-clear"></div>

<?php endif?>
