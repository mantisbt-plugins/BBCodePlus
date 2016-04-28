<?php
	class BBCodePlusPlugin extends MantisFormattingPlugin {
		
		// placeholders for MantisCoreFormatting values.
		private $t_html_make_links = OFF;
		private $t_MantisCoreFormatting_process_text = OFF;
		private $t_MantisCoreFormatting_process_urls = OFF;
		private $t_MantisCoreFormatting_process_buglinks = OFF;
		private $t_MantisCoreFormatting_process_vcslinks = OFF;
		
		/**
		 *  A method that populates the plugin information and minimum requirements.
		 *
		 * @return  void
		 */
	
		public function register() {

			$this->name        = plugin_lang_get( 'title' );
			$this->description = plugin_lang_get( 'description' );
			$this->page        = 'config';
			$this->version     = '1.0.12';
			
			$this->requires['MantisCore'] = '1.3.0';
			# this plugin can coexist with MantisCoreFormatting.
			$this->uses['MantisCoreFormatting'] = '1.3';
			
			$this->author  = 'Belman Kraul-Garcia, Kirill Krasnov';
			$this->contact = 'bkraul@yahoo.com;krasnovforum@gmail.com';
			$this->url     = 'https://github.com/mantisbt-plugins/BBCodePlus';
		}
		//-------------------------------------------------------------------
		function hooks() {

			$hooks = parent::hooks();
			
			$hooks['EVENT_LAYOUT_RESOURCES'] = 'resources';
			$hooks['EVENT_LAYOUT_PAGE_FOOTER'] = 'footer';
			
			return $hooks;			
		}
		//-------------------------------------------------------------------		
		function footer($p_event, $p_params) {

			# restore make links option.
			config_set_global("html_make_links", $this->t_html_make_links);					
		}			
		//-------------------------------------------------------------------
		function resources( $p_event ) {
			// store configuration values.
			$t_html_make_links = config_get_global("html_make_links");
			
			if( plugin_is_loaded('MantisCoreFormatting') ) {
				$this->t_MantisCoreFormatting_process_text = config_get( 'plugin_MantisCoreFormatting_process_text');
				$this->t_MantisCoreFormatting_process_urls = config_get( 'plugin_MantisCoreFormatting_process_urls');
				$this->t_MantisCoreFormatting_process_buglinks = config_get( 'plugin_MantisCoreFormatting_process_buglinks');
				if ( config_is_set( 'plugin_MantisCoreFormatting_process_vcslinks' ) ) {
					$this->t_MantisCoreFormatting_process_vcslinks = config_get( 'plugin_MantisCoreFormatting_process_vcslinks');					
				} else {
					$this->t_MantisCoreFormatting_process_vcslinks = OFF;
				}
			}
			
			# turn off formatting options.
			config_set_global("html_make_links", false);
			
			# includes.
			$resources = '<link rel="stylesheet" type="text/css" href="' . plugin_file( 'bbcodeplus.css' ) . '" />';
			$resources .= '<script type="text/javascript" src="' . plugin_file( 'bbcodeplus-init.js' ) . '"></script>';
			
			if ( ON == plugin_config_get( 'process_markitup' ) ) {
				$resources .= '<link rel="stylesheet" type="text/css" href="' . plugin_file( 'markitup/skins/' . plugin_config_get( 'markitup_skin' ) . '/style.css' ) . '" />';
				$resources .= '<link rel="stylesheet" type="text/css" href="' . plugin_file( 'markitup/sets/mantis/style.css' ) . '" />';
				$resources .= '<script type="text/javascript" src="' . plugin_file( 'jquery_migrate_min.js' ) . '"></script>';
				$resources .= '<script type="text/javascript" src="' . plugin_file( 'markitup/jquery_markitup.js' ) . '"></script>';
				$resources .= '<script type="text/javascript" src="' . plugin_file( 'markitup/sets/mantis/set.js' ) . '"></script>';
				$resources .= '<script type="text/javascript" src="' . plugin_file( 'markitup-init.js' ) . '"></script>';				
			}
			
			if ( ON == plugin_config_get( 'process_highlight' ) ) {
				$resources .= '<link rel="stylesheet" type="text/css" href="' . plugin_file( 'prism/styles/' . plugin_config_get( 'highlight_css' ) . '.css' ) . '" />';
				$resources .= '<script type="text/javascript" src="' . plugin_file( 'prism/prism.js' ) . '"></script>';	
				
				# load additional languages.
				if ( ON == plugin_config_get( 'highlight_extralangs' ) ) {
					$resources .= '<script type="text/javascript" src="' . plugin_file( 'prism/prism_additional_languages.js' ) . '"></script>';		
				}	
			}
						 
			return  $resources;
		}
		//-------------------------------------------------------------------
		public function install() {
			return TRUE;
		}
		//-------------------------------------------------------------------
		/**
		 * Default plugin configuration.
		 *
		 * @return  array default settings
		 */
		public function config() {

			return array(
				'process_text'  => ON,
				'process_email' => ON,
				'process_rss'   => ON,
				'process_highlight'   => ON,
				'process_markitup'   => ON,
				'markitup_skin'   => 'plain',
				'highlight_css'   => 'default',
				'highlight_extralangs'   => OFF,					
			);
		}
		//-------------------------------------------------------------------
		/**
		 * Plain text processing.
		 *
		 * @param  string Event name
		 * @param  string Unformatted text
		 * @param  boolean Multiline text
		 * @return multi Array with formatted text and multiline paramater
		 */
		public function text( $p_event, $p_string, $p_multiline = TRUE ) {

			if ( ON == plugin_config_get( 'process_text' ) )
				$this->string_process_bbcode( $p_string, $p_multiline );
			else
				$p_string = $this->string_strip_bbcode( $p_string, $p_multiline );

			return $p_string;
		}
		//-------------------------------------------------------------------
		/**
		 * RSS text processing.
		 *
		 * @param  string Event name
		 * @param  string Unformatted text
		 * @return string Formatted text
		 */
		public function rss( $p_event, $p_string ) {

			if ( ON == plugin_config_get( 'process_rss' ) )
				$p_string = $this->string_process_bbcode( $p_string );
			else
				$p_string = $this->string_strip_bbcode( $p_string );
			
			return $p_string;
		}
		//-------------------------------------------------------------------
		/**
		 * Email text processing.
		 *
		 * @param  string Event name
		 * @param  string Unformatted text
		 * @return string Formatted text
		 */
		public function email( $p_event, $p_string ) {

			$p_string = string_strip_hrefs( $p_string );
			$p_string = string_process_bug_link( $p_string, FALSE );
			$p_string = string_process_bugnote_link( $p_string, FALSE );
			$p_string = $this->string_process_cvs_link( $p_string, FALSE );
			
			if ( ON == plugin_config_get( 'process_email' ) )
				$p_string = $this->string_process_bbcode( $p_string );
			else
				$p_string = $this->string_strip_bbcode( $p_string );

			return $p_string;
		}		
		//-------------------------------------------------------------------
		/**
		 * Formatted text processing.
		 *
		 * @param  string Event name
		 * @param  string Unformatted text
		 * @param  boolean Multiline text
		 * @return multi Array with formatted text and multiline parameter
		 */
		public function formatted( $p_event, $p_string, $p_multiline = TRUE ) {
		
			if ( ON == plugin_config_get( 'process_text' ) )
				$p_string = $this->string_process_bbcode( $p_string );
			else
				$p_string = $this->string_strip_bbcode( $p_string );
			
			return $p_string;
		}
		//-------------------------------------------------------------------
		/**
		 * Filter string and format with bbcode
		 *
		 * @param   string $p_string
		 * @return  string $p_string
		 */
		function string_process_bbcode( $p_string, $p_multiline = TRUE ) {
			
			$t_change_quotes = FALSE;
			if ( ini_get_bool( 'magic_quotes_sybase' ) ) {
				$t_change_quotes = TRUE;
				ini_set( 'magic_quotes_sybase', FALSE );
			}
			
			# restore pre/code tags.
			$p_string = $this->restore_pre_code_tags( $p_string, $p_multiline);
			
			# remove breaks from [code] added by mantis formatting.
			if ( ON == $this->t_MantisCoreFormatting_process_text ) {
				$p_string = $this->string_code_nl2br($p_string);
				$p_string = $this->string_list_nl2br($p_string);
			} else {
				$p_string = string_html_specialchars( $p_string );
				$p_string = string_restore_valid_html_tags( $p_string, true );
			}
		
			# process bug and note links (if not already addressed.)
			if ( OFF == $this->t_MantisCoreFormatting_process_buglinks ) {
				$p_string = string_process_bug_link( $p_string, TRUE );
				$p_string = string_process_bugnote_link( $p_string, TRUE );
			}
			
			if ( OFF == $this->t_MantisCoreFormatting_process_vcslinks ) {
				$p_string = $this->string_process_cvs_link( $p_string );
			}

			# ensures that the links will be opened in a new window/tab, so as to not lose the currently displayed issue. 
			$t_extra_link_tags = 'target="_blank"';
			
			# if there are any expressed links, images convert them to bbcode.
			$p_string = preg_replace( "/^((http|https|ftp):\/\/[a-z0-9;\/\?:@=\&\$\-_\.\+!*'\(\),~%#]+)/i", "[url]$1[/url]", $p_string );
			$p_string = preg_replace( "/([^='\"(\[url\]|\[img\])])((http|https|ftp):\/\/[a-z0-9;\/\?:@=\&\$\-_\.\+!*'\(\),~%#]+)/i", "$1[url]$2[/url]", $p_string );
			
			$t_search[] = "/\[img\]((http|https|ftp):\/\/[a-z0-9;\/\?:@=\&\$\-_\.\+!*'\(\),~%# ]+?)\[\/img\]/is";
			$t_search[] = "/\[img\]([.]*[a-z0-9;\/\?:@=\&\$\-_\.\+!*'\(\),~%# ]+?)\[\/img\]/is";
			$t_search[] = "/\[url\]((http|https|ftp|mailto):\/\/([a-z0-9\.\-@:]+)[a-z0-9;\/\?:@=\&\$\-_\.\+!*'\(\),\#%~ ]*?)\[\/url\]/is";
			$t_search[] = "/\[url=((http|https|ftp|mailto):\/\/[^\]]+?)\](.+?)\[\/url\]/is";
			$t_search[] = "/\[url=([a-z0-9;\/\?:@=\&\$\-_\.\+!*'\(\),~%# ]+?)\](.+?)\[\/url\]/is";				
			$t_search[] = "/\[email\]([a-z0-9\-_\.\+]+@[a-z0-9\-]+\.[a-z0-9\-\.]+?)\[\/email\]/is";
			$t_search[] = "/\[email=([a-z0-9\-_\.\+]+@[a-z0-9\-]+\.[a-z0-9\-\.]+?)\](.+?)\[\/email\]/is";
			$t_search[] = "/\[color=([\#a-z0-9]+?)\](.+?)\[\/color\]/is";
			$t_search[] = "/\[highlight=([\#a-z0-9]+?)\](.+?)\[\/highlight\]/is";			
			$t_search[] = "/\[size=([+\-\da-z]+?)\](.+?)\[\/size\]/is";
			$t_search[] = "/\[list\](\n|\r\n|)/is";
			$t_search[] = "/\[list=(.+?)\](\n|\r\n|)/is";
			$t_search[] = "/\[\/list\](\n|\r\n|)/is";
			$t_search[] = "/\[\*\]/is";
			$t_search[] = "/\[b\](.+?)\[\/b\]/is";
			$t_search[] = "/\[u\](.+?)\[\/u\]/is";
			$t_search[] = "/\[i\](.+?)\[\/i\]/is";
			$t_search[] = "/\[s\](.+?)\[\/s\]/is";
			$t_search[] = "/\[left\](.+?)\[\/left\]/is";
			$t_search[] = "/\[center\](.+?)\[\/center\]/is";
			$t_search[] = "/\[right\](.+?)\[\/right\]/is";
			$t_search[] = "/\[justify\](.+?)\[\/justify\]/is";
			$t_search[] = "/\[hr\](\n|\r\n|)/is";
			$t_search[] = "/\[sub\](.+?)\[\/sub\]/is";
			$t_search[] = "/\[sup\](.+?)\[\/sup\]/is";
			$t_search[] = "/\[table\](\n|\r\n|)/is";
			$t_search[] = "/\[table=(.+?)\](\n|\r\n|)/is";
			$t_search[] = "/\[\/table\](\n|\r\n|)/is";
			$t_search[] = "/\[tr\](.+?)\[\/tr\]/is";					   
			$t_search[] = "/\[th\](.+?)\[\/th\]/is";
			$t_search[] = "/\[td\](.+?)\[\/td\]/is";
			$t_search[] = '/\[code\](.+)\[\/code\]/imsU';
			$t_search[] = '/\[code start=([0-9]+)\](.+)\[\/code\]/imsU';

			$t_replace[] = "<img src=\"$1\" border=\"0\" alt=\"$1\" />";
			$t_replace[] = "<img src=\"$1\" border=\"0\" alt=\"$1\" />";
			$t_replace[] = "<a $t_extra_link_tags href=\"$1\">$1</a>";
			$t_replace[] = "<a $t_extra_link_tags href=\"$1\">$3</a>";
			$t_replace[] = "<a $t_extra_link_tags href=\"$1\">$2</a>";
			$t_replace[] = "<a $t_extra_link_tags href=\"mailto:$1\">$1</a>";
			$t_replace[] = "<a $t_extra_link_tags href=\"mailto:$1\">$2</a>";
			$t_replace[] = "<span class=\"bbcolor-\$1\">$2</span>";
			$t_replace[] = "<span class=\"bbhighlight-\$1\">$2</span>";			
			$t_replace[] = "<span class=\"bbsize-\$1\">$2</span>";
			$t_replace[] = "<ol type=\"square\" class=\"bbcodeplus-list\">";
			$t_replace[] = "<ol type=\"1\" start=\"$1\" class=\"bbcodeplus-list\">";
			$t_replace[] = "</ol>";
			$t_replace[] = "<li>";
			$t_replace[] = "<strong>$1</strong>";
			$t_replace[] = "<u>$1</u>";
			$t_replace[] = "<em>$1</em>";
			$t_replace[] = "<s>$1</s>";
			$t_replace[] = "<div align=\"left\">$1</div>";
			$t_replace[] = "<div align=\"center\">$1</div>";
			$t_replace[] = "<div align=\"right\">$1</div>";
			$t_replace[] = "<div align=\"justify\">$1</div>";
			$t_replace[] = "<hr/>";
			$t_replace[] = "<sub>$1</sub>";
			$t_replace[] = "<sup>$1</sup>"; 
			$t_replace[] = "<table>";
			$t_replace[] = "<table border=\"$1\">";
			$t_replace[] = "</table>";
			$t_replace[] = "<tr>$1</tr>";
			$t_replace[] = "<th>$1</th>";
			$t_replace[] = "<td>$1</td>";
			$t_replace[] = "<pre><code class=\"language-none\">\$1</code></pre>";		
			$t_replace[] = "<pre class=\"line-numbers\" data-start=\"\$1\"><code class=\"language-none\">\$2</code></pre>";
			
			# perform the actual replacement.
			$p_string = preg_replace( $t_search, $t_replace, $p_string );
			
			# code=lang
			$p_string = preg_replace_callback('/\[code=(\w+)\](.+)\[\/code\]/imsU',
			create_function('$m', '
				return "<pre><code class=\"language-" . strtolower($m[1]) . "\">" . $m[2] . "</code></pre>";
			')
			, $p_string);
			
			# code=lang start=n
			$p_string = preg_replace_callback('/\[code=(\w+)\ start=([0-9]+)\](.+)\[\/code\]/imsU',
			create_function('$m', '
				return "<pre class=\"line-numbers\" data-start=\"" . $m[2] . "\"><code class=\"language-" . strtolower($m[1]) . "\">" . $m[3] . "</code></pre>";
			')
			, $p_string);
			
			# process quotes.	
			$p_string = $this->string_process_quote($p_string);		
			
			# add line breaks except for code blocks (only if core formatting is OFF);
			if ( OFF == $this->t_MantisCoreFormatting_process_text ) {
				$p_string = string_nl2br($p_string);				
			}
			
			if ( $t_change_quotes )
				ini_set( 'magic_quotes_sybase', TRUE );

			return $p_string;
		}
		//-------------------------------------------------------------------
		/**
		 * Filter string and remove bbcode
		 *
		 * @param   string $p_string
		 * @return  string $p_string
		 */
		 function string_strip_bbcode( $p_string, $p_multiline = TRUE ) {
			$t_change_quotes = FALSE;
			if ( ini_get_bool( 'magic_quotes_sybase' ) ) {
				$t_change_quotes = TRUE;
				ini_set( 'magic_quotes_sybase', FALSE );
			}

			# restore pre/code tags.
			$p_string = $this->restore_pre_code_tags( $p_string, $p_multiline);
			
			# ensures that the links will be opened in a new window/tab, so as to not lose the currently displayed issue. 
			$t_extra_link_tags = 'target="_blank"';
			
			# if there are any expressed links, images convert them to bbcode.
			$p_string = preg_replace( "/^((http|https|ftp):\/\/[a-z0-9;\/\?:@=\&\$\-_\.\+!*'\(\),~%#]+)/i", "[url]$1[/url]", $p_string );
			$p_string = preg_replace( "/([^='\"(\[url\]|\[img\])])((http|https|ftp):\/\/[a-z0-9;\/\?:@=\&\$\-_\.\+!*'\(\),~%#]+)/i", "$1[url]$2[/url]", $p_string );
			
			$t_search[] = "/\[img\]((http|https|ftp):\/\/[a-z0-9;\/\?:@=\&\$\-_\.\+!*'\(\),~%# ]+?)\[\/img\]/is";
			$t_search[] = "/\[img\]([.]*[a-z0-9;\/\?:@=\&\$\-_\.\+!*'\(\),~%# ]+?)\[\/img\]/is";
			$t_search[] = "/\[url\]((http|https|ftp|mailto):\/\/([a-z0-9\.\-@:]+)[a-z0-9;\/\?:@=\&\$\-_\.\+!*'\(\),\#%~ ]*?)\[\/url\]/is";
			$t_search[] = "/\[url=((http|https|ftp|mailto):\/\/[^\]]+?)\](.+?)\[\/url\]/is";
			$t_search[] = "/\[url=([a-z0-9;\/\?:@=\&\$\-_\.\+!*'\(\),~%# ]+?)\](.+?)\[\/url\]/is";				
			$t_search[] = "/\[email\]([a-z0-9\-_\.\+]+@[a-z0-9\-]+\.[a-z0-9\-\.]+?)\[\/email\]/is";
			$t_search[] = "/\[email=([a-z0-9\-_\.\+]+@[a-z0-9\-]+\.[a-z0-9\-\.]+?)\](.+?)\[\/email\]/is";
			$t_search[] = "/\[color=([\#a-z0-9]+?)\](.+?)\[\/color\]/is";
			$t_search[] = "/\[highlight=([\#a-z0-9]+?)\](.+?)\[\/highlight\]/is";			
			$t_search[] = "/\[size=([+\-\da-z]+?)\](.+?)\[\/size\]/is";
			$t_search[] = "/\[list\](\n|\r\n|)/is";
			$t_search[] = "/\[list=(.+?)\](\n|\r\n|)/is";
			$t_search[] = "/\[\/list\](\n|\r\n|)/is";
			$t_search[] = "/\[\*\]/is";
			$t_search[] = "/\[b\](.+?)\[\/b\]/is";
			$t_search[] = "/\[u\](.+?)\[\/u\]/is";
			$t_search[] = "/\[i\](.+?)\[\/i\]/is";
			$t_search[] = "/\[s\](.+?)\[\/s\]/is";
			$t_search[] = "/\[left\](.+?)\[\/left\]/is";
			$t_search[] = "/\[center\](.+?)\[\/center\]/is";
			$t_search[] = "/\[right\](.+?)\[\/right\]/is";
			$t_search[] = "/\[justify\](.+?)\[\/justify\]/is";
			$t_search[] = "/\[hr\](\n|\r\n|)/is";
			$t_search[] = "/\[sub\](.+?)\[\/sub\]/is";
			$t_search[] = "/\[sup\](.+?)\[\/sup\]/is";
			$t_search[] = "/\[table\](\n|\r\n|)/is";
			$t_search[] = "/\[table=(.+?)\](\n|\r\n|)/is";
			$t_search[] = "/\[\/table\](\n|\r\n|)/is";
			$t_search[] = "/\[tr\](.+?)\[\/tr\]/is";					   
			$t_search[] = "/\[th\](.+?)\[\/th\]/is";
			$t_search[] = "/\[td\](.+?)\[\/td\]/is";
			$t_search[] = '/\[code\](.+)\[\/code\]/imsU';
			$t_search[] = '/\[code start=([0-9]+)\](.+)\[\/code\]/imsU';

			$t_replace[] = "(Image: $1)";
			$t_replace[] = "(Image: $1)";
			$t_replace[] = "$1";
			$t_replace[] = "$1";
			$t_replace[] = "$1";
			$t_replace[] = "$1";
			$t_replace[] = "$2";
			$t_replace[] = "$2";
			$t_replace[] = "$2";			
			$t_replace[] = "$2";
			$t_replace[] = "";
			$t_replace[] = "";
			$t_replace[] = "";
			$t_replace[] = "* ";
			$t_replace[] = "$1";
			$t_replace[] = "$1";
			$t_replace[] = "$1";
			$t_replace[] = "$1";
			$t_replace[] = "\n$1";
			$t_replace[] = "\n$1";
			$t_replace[] = "\n$1";
			$t_replace[] = "\n$1";
			$t_replace[] = "--------------------------------";
			$t_replace[] = "$1";
			$t_replace[] = "$1"; 
			$t_replace[] = "";
			$t_replace[] = "";
			$t_replace[] = "";
			$t_replace[] = "\n";
			$t_replace[] = " $1 ";
			$t_replace[] = " $1 ";
			$t_replace[] = "\n$1";		
			$t_replace[] = "\n$2";
			
			# perform the actual replacement.
			$p_string = preg_replace( $t_search, $t_replace, $p_string );
		
			# code=lang
			$p_string = preg_replace_callback('/\[code=(\w+)\](.+)\[\/code\]/imsU',
			create_function('$m', '
				return $m[2];
			')
			, $p_string);
			
			# code=lang start=n
			$p_string = preg_replace_callback('/\[code=(\w+)\ start=([0-9]+)\](.+)\[\/code\]/imsU',
			create_function('$m', '
				return $m[3];
			')
			, $p_string);
			
			# process quotes.	
			$p_string = $this->string_strip_quote($p_string);
			
			if ( $t_change_quotes )
				ini_set( 'magic_quotes_sybase', TRUE );

			return $p_string;
		 }
		//-------------------------------------------------------------------
		/**
		 * restore 2 html tags: <pre> and <code>
		 * from string like &lt;pre&gt;
		 * @param string $p_string
		 * @param boolean $p_multiline
		 * @return string
		 */
		function restore_pre_code_tags( $p_string, $p_multiline = true ) {
			$t_string = $p_string;
			$tags = '';
			$t_html_pre_code_tags = "br, pre, code";

			if( is_blank( $t_html_pre_code_tags ) ) {
				return $t_string;
			}

			$tags = explode( ',', $t_html_pre_code_tags );
			foreach( $tags as $key => $value ) {
				if( !is_blank( $value ) ) {
					$tags[$key] = trim( $value );
				}
			}
			$tags = implode( '|', $tags );
		
			$t_string = preg_replace_callback('/&lt;(' . $tags . ')(.*?)&gt;/ui',
			create_function('$m', '
				return "<" . $m[1] . str_replace("&quot;", "\"", $m[2]) . ">";
			')
			, $t_string);
			
			$t_string = preg_replace( '/&lt;\/(' . $tags . ')\s*&gt;/ui', '</\\1>', $t_string );			
			$t_string = preg_replace( '/&lt;a\shref=&quot;(\S+)&quot;&gt;.+&lt;\/a&gt;\s\[&lt;a\shref=&quot;(\S+)&quot;\starget=&quot;_blank&quot;&gt;\^&lt;\/a&gt;\]/ui', '<a href="\\1">\\1</a> [<a href="\\1" target="_blank">^</a>]', $t_string );

			return $t_string;
		}
		//-------------------------------------------------------------------
		/**
		 * Process [quote] BB code
		 * @param string $p_string
		 * @return string
		 */
		function string_process_quote($p_string) {

			$pattern = '#\[quote[^\]]*\]#imsU';
			if ( !preg_match($pattern, $p_string, $matches) ) {
				return $p_string;
			}
			$pattern = '#\[quote(?:=([^\]]+))?\](.+)\[/quote\]#imsU';
			$p_string = preg_replace_callback($pattern, array($this, 'replaceQuotes'), $p_string);
			return $p_string;
		}		
		//-------------------------------------------------------------------
		/**
		 * Replace callback for [quote]
		 * @param string[] $matches
		 * @return string
		 */
		private function replaceQuotes($matches) {

			if ( !$matches[1] ) {
				$matches[1] = 'Someone';
			}
			$replacement = sprintf('<div class="bbcodeplus-quote"><i>%s wrote</i><br/><br/>%s</div>', $matches[1], $matches[2]);
			return $replacement;
		}
		//-------------------------------------------------------------------
		/**
		 * Strip [quote] BB code
		 * @param string $p_string
		 * @return string
		 */
		function string_strip_quote($p_string) {

			$pattern = '#\[quote[^\]]*\]#imsU';
			if ( !preg_match($pattern, $p_string, $matches) ) {
				return $p_string;
			}
			$pattern = '#\[quote(?:=([^\]]+))?\](.+)\[/quote\]#imsU';
			$p_string = preg_replace_callback($pattern, array($this, 'removeQuotes'), $p_string);
			return $p_string;
		}
		//-------------------------------------------------------------------
		/**
		 * Replace callback for [quote]
		 * @param string[] $matches
		 * @return string
		 */
		private function removeQuotes($matches) {

			if ( !$matches[1] ) {
				$matches[1] = 'Someone';
			}
			$replacement = sprintf('%s said: "%s"', $matches[1], $matches[2]);
			return $replacement;
		}
		//-------------------------------------------------------------------
		/**
		 * Similar to nl2br, but fixes up a problem where new lines are doubled between
		 * bbcode code tags.
		 * additionally, wrap the text an $p_wrap character intervals if the config is set
		 * @param string  $p_string String to be processed.
		 * @param integer $p_wrap   Number of characters to wrap text at.
		 * @return string
		 */
		function string_code_nl2br( $p_string, $p_wrap = 100 ) {
			$t_output = '';
			$t_pieces = preg_split( '/(\[code[^>]*\].*?\[\/code\])/is', $p_string, -1, PREG_SPLIT_DELIM_CAPTURE );
			if( isset( $t_pieces[1] ) ) {
				foreach( $t_pieces as $t_piece ) {
					if( preg_match( '/(\[code[^>]*\].*?\[\/code\])/is', $t_piece ) ) {
						$t_piece = preg_replace( '/<br[^>]*?>/', '', $t_piece );

						# @@@ thraxisp - this may want to be replaced by html_entity_decode (or equivalent)
						#     if other encoded characters are a problem
						$t_piece = preg_replace( '/&#160;/', ' ', $t_piece );
						if( ON == config_get( 'wrap_in_preformatted_text' ) ) {
							$t_output .= preg_replace( '/([^\n]{' . $p_wrap . ',}?[\s]+)(?!\[\/code\])/', "$1\n", $t_piece );
						} else {
							$t_output .= $t_piece;
						}
					} else {
						$t_output .= $t_piece;
					}
				}
				return $t_output;
			} else {
				return $p_string;
			}
		}
		//-------------------------------------------------------------------
		/**
		 * Similar to nl2br, but fixes up a problem where new lines are doubled between
		 * list bbcode tags.
		 * additionally, wrap the text an $p_wrap character intervals if the config is set
		 * @param string  $p_string String to be processed.
		 * @param integer $p_wrap   Number of characters to wrap text at.
		 * @return string
		 */
		function string_list_nl2br( $p_string, $p_wrap = 100 ) {
			$t_output = '';
			$t_pieces = preg_split( '/(\[list[^>]*\].*?\[\/list\])/is', $p_string, -1, PREG_SPLIT_DELIM_CAPTURE );
			if( isset( $t_pieces[1] ) ) {
				foreach( $t_pieces as $t_piece ) {
					if( preg_match( '/(\[list[^>]*\].*?\[\/list\])/is', $t_piece ) ) {
						$t_piece = preg_replace( '/<br[^>]*?>/', '', $t_piece );

						# @@@ thraxisp - this may want to be replaced by html_entity_decode (or equivalent)
						#     if other encoded characters are a problem
						$t_piece = preg_replace( '/&#160;/', ' ', $t_piece );
						if( ON == config_get( 'wrap_in_preformatted_text' ) ) {
							$t_output .= preg_replace( '/([^\n]{' . $p_wrap . ',}?[\s]+)(?!\[\/list\])/', "$1\n", $t_piece );
						} else {
							$t_output .= $t_piece;
						}
					} else {
						$t_output .= $t_piece;
					}
				}
				return $t_output;
			} else {
				return $p_string;
			}
		}
		//-------------------------------------------------------------------
		/**
		 * process the $p_string and convert filenames in the format
		 *  cvs:filename.ext or cvs:filename.ext:n.nn to a html link
		 * if $p_include_anchor is true, include an <a href="..."> tag,
		 *  otherwise, just insert the URL as text
		 * @param string $p_string
		 * @param bool $p_include_anchor
		 * @return string
		 */
		function string_process_cvs_link( $p_string, $p_include_anchor = true ) {
			if ( config_is_set('cvs_web') ) {
				$t_cvs_web = config_get( 'cvs_web' );				

				if( $p_include_anchor ) {
					$t_replace_with = '[CVS] <a href="' . $t_cvs_web . '\\1?rev=\\4" target="_new">\\1</a>\\5';
				} else {
					$t_replace_with = '[CVS] ' . $t_cvs_web . '\\1?rev=\\4\\5';
				}

				return preg_replace( '/cvs:([^\.\s:,\?!<]+(\.[^\.\s:,\?!<]+)*)(:)?(\d\.[\d\.]+)?([\W\s])?/i', $t_replace_with, $p_string );				
			} else {
				return $p_string;
			}
		}
		//-------------------------------------------------------------------
	}
?>