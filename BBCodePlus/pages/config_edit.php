<?php
/*
 * Copyright (C) 2009-2010	Kirill Krasnov
 * ICQ					82427351
 * JID					krak@jabber.ru
 * Skype				kirillkr
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

form_security_validate( 'plugin_BBCodePlus_manage_config' );
auth_reauthenticate( );
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );

$f_process_highlight = gpc_get_int( 'process_highlight', ON );
$f_process_text = gpc_get_int( 'process_text', ON );
$f_process_email = gpc_get_int( 'process_email', ON );
$f_process_rss = gpc_get_int( 'process_rss', ON );
$f_process_markitup = gpc_get_int( 'process_markitup', ON );
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

if( plugin_config_get( 'highlight_extralangs' ) != $f_highlight_extralangs ) {
	plugin_config_set( 'highlight_extralangs', $f_highlight_extralangs );
}

if( plugin_config_get( 'highlight_css' ) != $f_highlight_css ) {
	plugin_config_set( 'highlight_css', $f_highlight_css );
}

form_security_purge( 'plugin_BBCodePlus_manage_config' );
print_successful_redirect( plugin_page( 'config', true ) );