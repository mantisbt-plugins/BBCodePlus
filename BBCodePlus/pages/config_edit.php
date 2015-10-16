<?php

form_security_validate( 'plugin_BBCodePlus_config_edit' );
auth_reauthenticate( );
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

$f_process_highlight = gpc_get_int( 'process_highlight', ON );
$f_process_text = gpc_get_int( 'process_text', ON );
$f_process_email = gpc_get_int( 'process_email', ON );
$f_process_rss = gpc_get_int( 'process_rss', ON );
$f_process_markitup = gpc_get_int( 'process_markitup', ON );
$f_markitup_skin = gpc_get_string( 'markitup_skin', 'default' );
$f_highlight_css = gpc_get_string( 'highlight_css', 'default' );
$f_highlight_extralangs = gpc_get_int( 'highlight_extralangs', ON );

if( plugin_config_get( 'process_highlight' ) != $f_process_highlight ) {
	plugin_config_set( 'process_highlight', $f_process_highlight );
}

if( plugin_config_get( 'process_text' ) != $f_process_text ) {
	plugin_config_set( 'process_text', $f_process_text );
}

if( plugin_config_get( 'process_email' ) != $f_process_email ) {
	plugin_config_set( 'process_email', $f_process_email );
}

if( plugin_config_get( 'process_rss' ) != $f_process_rss ) {
	plugin_config_set( 'process_rss', $f_process_rss );
}

if( plugin_config_get( 'process_markitup' ) != $f_process_markitup ) {
	plugin_config_set( 'process_markitup', $f_process_markitup );
}

if( plugin_config_get( 'markitup_skin' ) != $f_markitup_skin ) {
	plugin_config_set( 'markitup_skin', $f_markitup_skin );
}

if( plugin_config_get( 'highlight_extralangs' ) != $f_highlight_extralangs ) {
	plugin_config_set( 'highlight_extralangs', $f_highlight_extralangs );
}

if( plugin_config_get( 'highlight_css' ) != $f_highlight_css ) {
	plugin_config_set( 'highlight_css', $f_highlight_css );
}

form_security_purge( 'plugin_BBCodePlus_config_edit' );
print_successful_redirect( plugin_page( 'config', true ) );