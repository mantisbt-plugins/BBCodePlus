<?php
/**
 * Edit BBCode+ Configuration
 */

auth_reauthenticate( );
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

html_page_top( plugin_lang_get( 'title' ) );
print_manage_menu( );

?>

<br />
<form id="bbcodeplus-config-form" action="<?php echo plugin_page( 'config_edit' )?>" method="post">
<?php echo form_security_field( 'plugin_BBCodePlus_config_edit' ) ?>
<table align="center" class="width50" cellspacing="1">

<tr>
	<td class="form-title" colspan="3">
		<strong><?php echo plugin_lang_get( 'title' ) . ': ' . plugin_lang_get( 'config' )?></strong>
		<br /><span class="small"><?php echo plugin_lang_get( 'description' )?></span>		
	</td>
</tr>

<tr <?php echo helper_alternate_class( )?>>
	<td class="category" width="60%">
		<?php echo plugin_lang_get( 'process_text' )?>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="process_text" value="1" <?php echo( ON == plugin_config_get( 'process_text' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo plugin_lang_get( 'enabled' )?></label>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="process_text" value="0" <?php echo( OFF == plugin_config_get( 'process_text' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo plugin_lang_get( 'disabled' )?></label>
	</td>
</tr>

<tr <?php echo helper_alternate_class( )?>>
	<td class="category" width="60%">
		<?php echo plugin_lang_get( 'process_email' )?>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="process_email" value="1" <?php echo( ON == plugin_config_get( 'process_email' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo plugin_lang_get( 'enabled' )?></label>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="process_email" value="0" <?php echo( OFF == plugin_config_get( 'process_email' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo plugin_lang_get( 'disabled' )?></label>
	</td>
</tr>

<tr <?php echo helper_alternate_class( )?>>
	<td class="category" width="60%">
		<?php echo plugin_lang_get( 'process_rss' )?>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="process_rss" value="1" <?php echo( ON == plugin_config_get( 'process_rss' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo plugin_lang_get( 'enabled' )?></label>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="process_rss" value="0" <?php echo( OFF == plugin_config_get( 'process_rss' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo plugin_lang_get( 'disabled' )?></label>
	</td>
</tr>

<tr <?php echo helper_alternate_class( )?>>
	<td class="category" width="60%">
		<?php echo plugin_lang_get( 'process_highlight' )?>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="process_highlight" value="1" <?php echo( ON == plugin_config_get( 'process_highlight' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo plugin_lang_get( 'enabled' )?></label>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="process_highlight" value="0" <?php echo( OFF == plugin_config_get( 'process_highlight' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo plugin_lang_get( 'disabled' )?></label>
	</td>
</tr>

<tr <?php echo helper_alternate_class( )?>>
	<td class="category" width="60%">
		<?php echo plugin_lang_get( 'process_markitup' )?>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="process_markitup" value="1" <?php echo( ON == plugin_config_get( 'process_markitup' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo plugin_lang_get( 'enabled' )?></label>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="process_markitup" value="0" <?php echo( OFF == plugin_config_get( 'process_markitup' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo plugin_lang_get( 'disabled' )?></label>
	</td>
</tr>

<tr <?php echo helper_alternate_class( )?>>
	<td class="category" width="60%">
		<?php echo plugin_lang_get( 'highlight_extralangs' )?>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="highlight_extralangs" value="1" <?php echo( ON == plugin_config_get( 'highlight_extralangs' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo plugin_lang_get( 'enabled' )?></label>
	</td>
	<td class="center" width="20%">
		<label><input type="radio" name="highlight_extralangs" value="0" <?php echo( OFF == plugin_config_get( 'highlight_extralangs' ) ) ? 'checked="checked" ' : ''?>/>
			<?php echo plugin_lang_get( 'disabled' )?></label>
	</td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
	<td class="category">
		<?php echo plugin_lang_get( 'highlight_css' ) ?>
	</td>
	<td colspan = 2 >
		<select name="highlight_css">
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
		<strong><?php echo plugin_lang_get( 'credits' ) ?></strong>
		<br /><span class="small">
		<?php echo plugin_lang_get( 'credits_line1' )?><br/>
		<?php echo plugin_lang_get( 'credits_line2' )?><br/><br/>		
		<?php echo plugin_lang_get( 'credits_line3' )?>
		</span>
	</td>
</tr>

<tr>
	<td class="center" colspan="3">
		<input type="submit" class="button" value="<?php echo lang_get( 'change_configuration' )?>" />
	</td>
</tr>


</table>
</form>

<?php
html_page_bottom( );