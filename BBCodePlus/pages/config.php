<?php
/**
 * Edit BBCode+ Configuration
 */

auth_reauthenticate( );
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

html_page_top( plugin_lang_get( 'title' ) );
print_manage_menu( );

?>

<div id="bbcodeplus-config-div" class="form-container">
	<form id="bbcodeplus-config-form" action="<?php echo plugin_page( 'config_edit' )?>" method="post">
		<fieldset>
			<legend><span><?php echo plugin_lang_get( 'title' ) . ': ' . plugin_lang_get( 'config' ) ?></span>
			<br /><span class="small"><?php echo plugin_lang_get( 'description' )?></span>
			</legend>
			<?php echo form_security_field( 'plugin_BBCodePlus_config_edit' ) ?>
			<div class="field-container">
				<label><span><?php echo plugin_lang_get( 'process_text' )?></span></label>
				<span class="radio">
					<label><input type="radio" name="process_text" value="1" <?php echo( ON == plugin_config_get( 'process_text' ) ) ? 'checked="checked" ' : ''?>/>
					<?php echo plugin_lang_get( 'enabled' )?></label>
					<label><input type="radio" name="process_text" value="0" <?php echo( OFF == plugin_config_get( 'process_text' ) ) ? 'checked="checked" ' : ''?>/>
					<?php echo plugin_lang_get( 'disabled' )?></label>
				</span>
				<span class="label-style"></span>
			</div>
			<div class="field-container">
				<label><span><?php echo plugin_lang_get( 'process_email' )?></span></label>
				<span class="radio">
					<label><input type="radio" name="process_email" value="1" <?php echo( ON == plugin_config_get( 'process_email' ) ) ? 'checked="checked" ' : ''?>/>
					<?php echo plugin_lang_get( 'enabled' )?></label>
					<label><input type="radio" name="process_email" value="0" <?php echo( OFF == plugin_config_get( 'process_email' ) ) ? 'checked="checked" ' : ''?>/>
					<?php echo plugin_lang_get( 'disabled' )?></label>
				</span>
				<span class="label-style"></span>
			</div>
			<div class="field-container">
				<label><span><?php echo plugin_lang_get( 'process_rss' )?></span></label>
				<span class="radio">
					<label><input type="radio" name="process_rss" value="1" <?php echo( ON == plugin_config_get( 'process_rss' ) ) ? 'checked="checked" ' : ''?>/>
					<?php echo plugin_lang_get( 'enabled' )?></label>
					<label><input type="radio" name="process_rss" value="0" <?php echo( OFF == plugin_config_get( 'process_rss' ) ) ? 'checked="checked" ' : ''?>/>
					<?php echo plugin_lang_get( 'disabled' )?></label>
				</span>
				<span class="label-style"></span>
			</div>
			<div class="field-container">
				<label><span><?php echo plugin_lang_get( 'process_highlight' )?></span></label>
				<span class="radio">
					<label><input type="radio" name="process_highlight" value="1" <?php echo( ON == plugin_config_get( 'process_highlight' ) ) ? 'checked="checked" ' : ''?>/>
					<?php echo plugin_lang_get( 'enabled' )?></label>
					<label><input type="radio" name="process_highlight" value="0" <?php echo( OFF == plugin_config_get( 'process_highlight' ) ) ? 'checked="checked" ' : ''?>/>
					<?php echo plugin_lang_get( 'disabled' )?></label>
				</span>
				<span class="label-style"></span>
			</div>
			<div class="field-container">
				<label><span><?php echo plugin_lang_get( 'process_markitup' )?></span></label>
				<span class="radio">
					<label><input type="radio" name="process_markitup" value="1" <?php echo( ON == plugin_config_get( 'process_markitup' ) ) ? 'checked="checked" ' : ''?>/>
					<?php echo plugin_lang_get( 'enabled' )?></label>
					<label><input type="radio" name="process_markitup" value="0" <?php echo( OFF == plugin_config_get( 'process_markitup' ) ) ? 'checked="checked" ' : ''?>/>
					<?php echo plugin_lang_get( 'disabled' )?></label>
				</span>
				<span class="label-style"></span>
			</div>
			<div class="field-container">
				<label><span><?php echo plugin_lang_get( 'markitup_skin' ) ?></span></label>
				<span class="radio">
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
				</span>
				<span class="label-style"></span>
			</div>
			<div class="field-container">
				<label><span><?php echo plugin_lang_get( 'highlight_extralangs' )?></span></label>
				<span class="radio">
					<label><input type="radio" name="highlight_extralangs" value="1" <?php echo( ON == plugin_config_get( 'highlight_extralangs' ) ) ? 'checked="checked" ' : ''?>/>
					<?php echo plugin_lang_get( 'enabled' )?></label>
					<label><input type="radio" name="highlight_extralangs" value="0" <?php echo( OFF == plugin_config_get( 'highlight_extralangs' ) ) ? 'checked="checked" ' : ''?>/>
					<?php echo plugin_lang_get( 'disabled' )?></label>
				</span>
				<span class="label-style"></span>
			</div>
			<div class="field-container">
				<label><span><?php echo plugin_lang_get( 'highlight_css' ) ?></span></label>
				<span class="radio">
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
				</span>
				<span class="label-style"></span>
			</div>
			<div class="field-container">
				<p><strong><?php echo plugin_lang_get( 'credits' ) ?></strong></p>
				<p class="small"><?php echo plugin_lang_get( 'credits_line1' )?><br />
				<?php echo plugin_lang_get( 'credits_line2' )?></p>	
				<p class="small"><?php echo plugin_lang_get( 'credits_line3' )?></p>
			</div>
			<span class="submit-button">
				<input type="submit" class="button" value="<?php echo lang_get( 'change_configuration' )?>" />
			</span>
		</fieldset>
	</form>
</div>

<?php
html_page_bottom( );