<?php
/**
 * Edit BBCode+ Configuration
 */

auth_reauthenticate( );
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

layout_page_header( plugin_lang_get( 'title' ) );

layout_page_begin( 'manage_overview_page.php' );
print_manage_menu( 'manage_plugin_page.php' );
?>

<div class="col-md-12 col-xs-12">
<div class="space-10"></div>
<div class="form-container" >

<form id="bbcodeplus-config-form" action="<?php echo plugin_page( 'config_edit' )?>" method="post">
<?php echo form_security_field( 'plugin_BBCodePlus_config_edit' ) ?>
<div class="widget-box widget-color-blue2">
<div class="widget-header widget-header-small">
	<h4 class="widget-title lighter">
		<i class="ace-icon fa fa-text-width"></i>
		<?php echo plugin_lang_get( 'title' ) . ': ' . plugin_lang_get( 'config' )?>
	</h4>
</div>
<div class="widget-body">
<div class="widget-main no-padding">
<div class="table-responsive">
<table class="table table-bordered table-condensed table-striped">
<tr>
	<th class="category width-40">
		<?php echo plugin_lang_get( 'process_text' )?>
	</th>
	<td class="center" width="20%">
		<label><input type="radio" class="ace" name="process_text" value="1" <?php echo( ON == plugin_config_get( 'process_text' ) ) ? 'checked="checked" ' : ''?>/>
			<span class="lbl"> <?php echo plugin_lang_get( 'enabled' )?></span></label>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" class="ace" name="process_text" value="0" <?php echo( OFF == plugin_config_get( 'process_text' ) ) ? 'checked="checked" ' : ''?>/>
			<span class="lbl"> <?php echo plugin_lang_get( 'disabled' )?></span></label>
	</td>
</tr>
<tr>
	<th class="category width-40">
		<?php echo plugin_lang_get( 'process_email' )?>
	</th>
	<td class="center" width="20%">
		<label><input type="radio" class="ace" name="process_email" value="1" <?php echo( ON == plugin_config_get( 'process_email' ) ) ? 'checked="checked" ' : ''?>/>
			<span class="lbl"> <?php echo plugin_lang_get( 'enabled' )?></span></label>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" class="ace" name="process_email" value="0" <?php echo( OFF == plugin_config_get( 'process_email' ) ) ? 'checked="checked" ' : ''?>/>
			<span class="lbl"> <?php echo plugin_lang_get( 'disabled' )?></span></label>
	</td>
</tr>
<tr>
	<th class="category width-40">
		<?php echo plugin_lang_get( 'process_rss' )?>
	</th>
	<td class="center" width="20%">
		<label><input type="radio" class="ace" name="process_rss" value="1" <?php echo( ON == plugin_config_get( 'process_rss' ) ) ? 'checked="checked" ' : ''?>/>
			<span class="lbl"> <?php echo plugin_lang_get( 'enabled' )?></span></label>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" class="ace" name="process_rss" value="0" <?php echo( OFF == plugin_config_get( 'process_rss' ) ) ? 'checked="checked" ' : ''?>/>
			<span class="lbl"> <?php echo plugin_lang_get( 'disabled' )?></span></label>
	</td>
</tr>
<tr>
	<th class="category width-40">
		<?php echo plugin_lang_get( 'process_highlight' )?>
	</th>
	<td class="center" width="20%">
		<label><input type="radio" class="ace" name="process_highlight" value="1" <?php echo( ON == plugin_config_get( 'process_highlight' ) ) ? 'checked="checked" ' : ''?>/>
			<span class="lbl"> <?php echo plugin_lang_get( 'enabled' )?></span></label>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" class="ace" name="process_highlight" value="0" <?php echo( OFF == plugin_config_get( 'process_highlight' ) ) ? 'checked="checked" ' : ''?>/>
			<span class="lbl"> <?php echo plugin_lang_get( 'disabled' )?></span></label>
	</td>
</tr>
<tr>
	<th class="category width-40">
		<?php echo plugin_lang_get( 'process_markitup' )?>
	</th>
	<td class="center" width="20%">
		<label><input type="radio" class="ace" name="process_markitup" value="1" <?php echo( ON == plugin_config_get( 'process_markitup' ) ) ? 'checked="checked" ' : ''?>/>
			<span class="lbl"> <?php echo plugin_lang_get( 'enabled' )?></span></label>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" class="ace" name="process_markitup" value="0" <?php echo( OFF == plugin_config_get( 'process_markitup' ) ) ? 'checked="checked" ' : ''?>/>
			<span class="lbl"> <?php echo plugin_lang_get( 'disabled' )?></span></label>
	</td>
</tr>
<tr>
	<th class="category width-40">
		<?php echo plugin_lang_get( 'markitup_skin' ) ?>
	</th>
	<td colspan="2">
		<select name="markitup_skin">
			<?php
			$f_markitup_skin = plugin_config_get( 'markitup_skin' );
			$t_arr = explode( ',', 'mantis,plain' );
			$enum_count = count( $t_arr );
			for( $i = 0;$i < $enum_count;$i++ ) {
				$t_style = string_attribute( $t_arr[$i] );
				echo '<option value="' . $t_style . '"';
				check_selected( $t_style, $f_markitup_skin );
				echo '>' . $t_style . '</option>';
			}
			?>
		</select>
	</td>
</tr>
<tr>
	<th class="category width-40">
		<?php echo plugin_lang_get( 'highlight_extralangs' )?>
	</th>
	<td class="center" width="20%">
		<label><input type="radio" class="ace" name="highlight_extralangs" value="1" <?php echo( ON == plugin_config_get( 'highlight_extralangs' ) ) ? 'checked="checked" ' : ''?>/>
			<span class="lbl"> <?php echo plugin_lang_get( 'enabled' )?></span></label>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" class="ace" name="highlight_extralangs" value="0" <?php echo( OFF == plugin_config_get( 'highlight_extralangs' ) ) ? 'checked="checked" ' : ''?>/>
			<span class="lbl"> <?php echo plugin_lang_get( 'disabled' )?></span></label>
	</td>
</tr>
<tr>
	<th class="category width-40">
		<?php echo plugin_lang_get( 'highlight_css' ) ?>
	</th>
	<td colspan = 2 >
		<select name="highlight_css" class="input-sm">
			<?php
				$f_highlight_css = plugin_config_get( 'highlight_css' );
				$t_arr = explode( ',', 'default,dark,funky,okaidia,twilight,coy' );
				$enum_count = count( $t_arr );
				for( $i = 0;$i < $enum_count;$i++ ) {
					$t_style = string_attribute( $t_arr[$i] );
					echo '<option value="' . $t_style . '"';
					check_selected( $t_style, $f_highlight_css );
					echo '>' . $t_style . '</option>';
				}
			?>
		</select>
	</td>
</tr>

<tr>
	<td class="form-title" colspan="3">
		<p><strong><?php echo plugin_lang_get( 'credits' ) ?></strong></p>
		<p class="small"><?php echo plugin_lang_get( 'credits_line1' )?><br/>
		<?php echo plugin_lang_get( 'credits_line2' )?></p>
		<p class="small"><?php echo plugin_lang_get( 'credits_line3' )?></p>
	</td>
</tr>
</table>
</div>
</div>
	<div class="widget-toolbox padding-8 clearfix">
		<input type="submit" class="btn btn-primary btn-white btn-round" value="<?php echo lang_get( 'change_configuration' )?>" />
	</div>
</div>
</div>
</form>

</div>
</div>

<?php
layout_page_end();