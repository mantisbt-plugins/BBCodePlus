<?php
   # import the new parsers.
   require_once( 'core/Parser.php' );
   require_once( 'core/BBCodeParser.php' );
   require_once( 'core/HTMLParser.php' );

   class BBCodePlusPlugin extends MantisFormattingPlugin {
      # placeholders for MantisCoreFormatting values.
      private $t_MantisCoreFormatting = OFF;
      private $t_MantisCoreFormatting_process_text = OFF;
      private $t_MantisCoreFormatting_process_urls = OFF;
      private $t_bbCode = null;
      private $t_HTML = null;
      //-------------------------------------------------------------------
      /**
       *  A method that populates the plugin information and minimum requirements.
       *
       * @return  void
       */
      function register() {
         $this->name        = plugin_lang_get( 'title' );
         $this->description = plugin_lang_get( 'description' );
         $this->page        = 'config';
         $this->version     = '1.3.6';

         $this->requires['MantisCore'] = '1.3.0';
         # this plugin can coexist with MantisCoreFormatting.
         $this->uses['MantisCoreFormatting'] = '1.3';

         $this->author  = 'Belman Kraul-Garcia, Kirill Krasnov';
         $this->contact = 'bkraul@yahoo.com;krasnovforum@gmail.com';
         $this->url     = 'https://github.com/mantisbt-plugins/BBCodePlus';
      }
      //-------------------------------------------------------------------
      /**
       *  A method that wires plugin events to user methods.
       *
       * @return  void
       */
      function hooks() {
         # retrieve existing hooks.
         $hooks = parent::hooks();

         # add in our plugin's hooks.
         $hooks['EVENT_LAYOUT_RESOURCES'] = 'resources';
         $hooks['EVENT_LAYOUT_PAGE_FOOTER'] = 'footer';
         $hooks['EVENT_CORE_HEADERS'] = 'csp_headers';

         return $hooks;
      }
      //-------------------------------------------------------------------
      /**
       *  Event fired on plugin intialization.
       *
       * @return  void
       */
      function init() {
         # instance BBCode parser class.
         $this->t_bbCode = new Genert\BBCode\Parser\BBCodeParser();
         # instance HTML parser class.
         $this->t_HTML = new Genert\BBCode\Parser\HTMLParser();
         # add all the tags
         $this->add_tags();
         # store original configuration values.
         if( plugin_is_loaded('MantisCoreFormatting') ) {
            $this->t_MantisCoreFormatting = ON;
            $this->t_MantisCoreFormatting_process_text = $this->t_MantisCoreFormatting && config_get( 'plugin_MantisCoreFormatting_process_text' );
            $this->t_MantisCoreFormatting_process_urls = $this->t_MantisCoreFormatting && config_get( 'plugin_MantisCoreFormatting_process_urls' );
         }
      }
      //-------------------------------------------------------------------
      /**
       *  Event fired on printing page footer.
       *
       * @return  void
       */
      function footer() {
      }
      //-------------------------------------------------------------------
      /**
       *  Event fired on header creation. Useful for handling CSP issues.
       *
       * @return  void
       */
      function csp_headers() {
         # relax csp when processing markitup.
         if ( (ON == plugin_config_get( 'process_markitup' )) && function_exists( 'http_csp_add' ) ) {
            http_csp_add( 'script-src', "'self' 'unsafe-inline' 'unsafe-eval' https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js" );
            http_csp_add( 'img-src', "*" );
            http_csp_add( 'frame-ancestors', "'self'" );
         }
      }
      //-------------------------------------------------------------------
      /**
       *  Event fired on loading of plugin resources.
       *
       * @return  void
       */
      function resources( $p_event ) {
         # includes.
         $resources = '<link rel="stylesheet" type="text/css" href="' . plugin_file( 'bbcodeplus.css' ) . '" />';
         $resources .= '<script type="text/javascript" src="' . plugin_file( 'bbcodeplus-init.js' ) . '"></script>';

         if ( ON == plugin_config_get( 'process_markitup' ) ) {
            $resources .= '<link rel="stylesheet" type="text/css" href="' . plugin_file( 'markitup/skins/' . plugin_config_get( 'markitup_skin' ) . '/style.css' ) . '" />';
            $resources .= '<link rel="stylesheet" type="text/css" href="' . plugin_file( 'markitup/sets/mantis/style.css' ) . '" />';
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
      /**
       *  Event fired on plugin installation.
       *
       * @return  void
       */
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
         #$p_string = string_strip_hrefs( $p_string );
         #$p_string = string_process_bug_link( $p_string, FALSE );
         #$p_string = string_process_bugnote_link( $p_string, FALSE );
         #$p_string = $this->string_process_cvs_link( $p_string, FALSE );

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
      function add_tags() {
         # add the BBCodePlus custom parsers and overrides.
         # check core/BBCodeParser.php for the default ones.
         # any default parser can be overriden here.
         # ensures that the links will be opened in a new window/tab, so as to not lose the currently displayed issue.
         $t_extra_link_tags = 'target="_blank"';
         # BBCode parsers.
         $this->t_bbCode->addParser('link', '/\[url\](.*?)\[\/url\]/s', '<a ' . $t_extra_link_tags . ' href="$1">$1</a>', '$1');
         $this->t_bbCode->addParser('namedlink', '/\[url\=(.*?)(\smention)?\](.*?)\[\/url\]/s', '<a ' . $t_extra_link_tags . ' href="$1">$3</a>', '$3');
         $this->t_bbCode->addParser('mention', '/\[url\=([^\s]*)\ mention\](.*?)\[\/url\]/s', '<span class="mention"><a ' . $t_extra_link_tags . ' href="$1">$2</a></span>', '$2');
         $this->t_bbCode->addParser('email', '/\[email\]([a-z0-9\-_\.\+]+@[a-z0-9\-]+\.[a-z0-9\-\.]+?)\[\/email\]/s', '<a ' . $t_extra_link_tags . ' href="mailto:$1">$1</a>', '$1');
         $this->t_bbCode->addParser('named-email', '/\[email=([a-z0-9\-_\.\+]+@[a-z0-9\-]+\.[a-z0-9\-\.]+?)\](.+?)\[\/email\]/s', '<a ' . $t_extra_link_tags . ' href="mailto:$1">$2</a>', '$2');
         $this->t_bbCode->addParser('color', '/\[color=([\#a-z0-9]+?)\](.*?)\[\/color\]/s', '<span class="bbcolor-$1">$2</span>', '$2');
         $this->t_bbCode->addParser('highlight', '/\[highlight=([\#a-z0-9]+?)\](.*?)\[\/highlight\]/s', '<span class="bbhighlight-$1">$2</span>', '$2');
         $this->t_bbCode->addParser('size', '/\[size=([+\-\da-z]+?)\](.*?)\[\/size\]/s', '<span class="bbsize-$1">$2</span>', '$2');
         $this->t_bbCode->addParser('hr', '/\[hr\]/s', '<hr/>', '$1');
         $this->t_bbCode->addParser('align-left', '/\[left\](.*?)\[\/left\]/s', '<div align="left">$1</div>', '$1');
         $this->t_bbCode->addParser('align-center', '/\[center\](.*?)\[\/center\]/s', '<div align="center">$1</div>', '$1');
         $this->t_bbCode->addParser('align-right', '/\[right\](.*?)\[\/right\]/s', '<div align="right">$1</div>', '$1');
         $this->t_bbCode->addParser('align-justify', '/\[justify\](.*?)\[\/justify\]/s', '<div align="justify">$1</div>', '$1');
         $this->t_bbCode->addParser('table', '/\[table\](.*?)\[\/table\]/s', '<table class="bbcodeplus table">$1</table>', '$1');
         $this->t_bbCode->addParser('table-bordered', '/\[table=(.*?)\](.*?)\[\/table\]/s', '<table class="bbcodeplus table table-bordered">$2</table>', '$2');
         $this->t_bbCode->addParser('table-head', '/\[thead\](.*?)\[\/thead\]/s', '<thead class="bbcodeplus">$1</thead>', '$1');
         $this->t_bbCode->addParser('table-body', '/\[tbody\](.*?)\[\/tbody\]/s', '<tbody>$1</tbody>', '$1');
         $this->t_bbCode->addParser('table-head-data', '/\[th\](.*?)\[\/th\]/s', '<th>$1</th>', '$1');
         $this->t_bbCode->addParser('code', '/\[code\](.*?)\[\/code\]/s', '<pre class="bbcodeplus pre"><code class="bbcodeplus code language-none">$1</code></pre>', '$1');
         $this->t_bbCode->addParser('code-lang', '/\[code=(\w+)\](.*?)\[\/code\]/s', '<pre class="bbcodeplus pre"><code class="bbcodeplus code language-$1">$2</code></pre>','$2');
         $this->t_bbCode->addParser('code-ln', '/\[code start=([0-9]+)\](.*?)\[\/code\]/s', '<pre class="bbcodeplus pre line-numbers" data-start="$1"><code class="language-none">$2</code></pre>', '$3');
         $this->t_bbCode->addParser('code-lang-ln', '/\[code=(\w+)\ start=([0-9]+)\](.*?)\[\/code\]/s',
                                    '<pre class="bbcodeplus pre line-numbers" data-start="$2"><code class="bbcodeplus code language-$1">$3</code></pre>', '$3');
         $this->t_bbCode->addParser('quote', '/\[quote\](.*?)\[\/quote\]/s', '<blockquote class="bbcodeplus blockquote">$1</blockquote>', '$1');
         $this->t_bbCode->addParser('named-quote', '/\[quote=(\w+)\](.*?)\[\/quote\]/s',
                                    '<blockquote class="bbcodeplus blockquote"><p class="mb-0">$2</p><footer class="bbcodeblus blockquote-footer"><cite title="$1">$1</cite></footer></blockquote>',
                                    '$1 wrote: $2');
      }
      //-------------------------------------------------------------------
      /**
       * Filter string and format with bbcode
       *
       * @param   string $p_string
       * @return  string $p_string
       */
      function string_process_bbcode( $p_string, $p_multiline = TRUE ) {
         // convert mentions and titled links to BBCode mentions (if available).
         $p_string = preg_replace( '/<span class="mention"><a .*?href="(.*?)">(.*?)<\/a><\/span>/is', '[url=$1 mention]$2[/url]', $p_string);
         $p_string = preg_replace( '/<a href="([^"]*)" title="([^"]*)">([^"]*)<\/a>/is', '[url=$1]$3[/url]', $p_string);
         # strip all the auto generated URLs by MantisCoreFormatting plugin to avoid mangling.
         if ( ON == $this->t_MantisCoreFormatting_process_urls ) {
            $p_string = string_strip_hrefs( $p_string );
         }
         # if mantis core formatting plugin process text feature is off, we need to sanitize the html,
         # for safety. this is the only functionality we will support when the MantisCoreFormatting plugin is
         # not enabled or when the text processing is disabled.
         if ( OFF == $this->t_MantisCoreFormatting_process_text ) {
            $p_string = string_html_specialchars( $p_string );
            $p_string = string_restore_valid_html_tags( $p_string, $p_multiline );
         }
         # convert all remaining major html items to bbcode for uniform processing.
         $p_string = $this->t_HTML->except('linebreak')->parse($p_string);
         # escape all html code inside <code> tags.
         $p_string = $this->string_escape_code( $p_string );
         # parse the BBCode.
         $p_string = $this->t_bbCode->parse($p_string);
         # process new lines (while respecting code blocks);
         if ( OFF == $this->t_MantisCoreFormatting_process_text && $p_multiline ) {
            # convert newlines to html breaks.
            $p_string = string_preserve_spaces_at_bol( $p_string );
            $p_string = string_nl2br($p_string);
         }

         # remove extra breaks added by use of string_nl2br.
         $p_string = preg_replace( '/(<ul.*?>)<br \/>/is', '$1', $p_string);
         $p_string = preg_replace( '/(<ol.*?>)<br \/>/is', '$1', $p_string);
         $p_string = preg_replace( '/<\/ol><br \/>/is', '</ol>', $p_string);
         $p_string = preg_replace( '/<\/ul><br \/>/is', '</ul>', $p_string);
         $p_string = preg_replace( '/<\/li><br \/>/is', '</li>', $p_string);
         $p_string = preg_replace( '/(<li>.*?)<br \/>/is', '$1', $p_string);
         $p_string = preg_replace( '/(<hr\/>.*?)<br \/>/is', '$1', $p_string);
         $p_string = preg_replace( '/(<\/h.*?>.*?)<br \/>/is', '$1', $p_string);
         $p_string = preg_replace( '/(<table.*?>)<br \/>/is', '$1', $p_string);
         $p_string = preg_replace( '/(<div.*?>)<br \/>/is', '$1', $p_string);
         $p_string = preg_replace( '/<\/div><br \/>/is', '</div>', $p_string);
         $p_string = preg_replace( '/<\/thead><br \/>/is', '</thead>', $p_string);
         $p_string = preg_replace( '/<tbody><br \/>/is', '<tbody>', $p_string);
         $p_string = preg_replace( '/<\/tbody><br \/>/is', '</tbody>', $p_string);
         $p_string = preg_replace( '/<\/table><br \/>/is', '</table>', $p_string);
         $p_string = preg_replace( '/<\/tr><br \/>/is', '</tr>', $p_string);
         $p_string = preg_replace( '/<\/th><br \/>/is', '</th>', $p_string);
         $p_string = preg_replace( '/<\/td><br \/>/is', '</td>', $p_string);
         $p_string = preg_replace( '/<\/pre><br \/>/is', '</pre>', $p_string);
         $p_string = preg_replace( '/<\/blockquote><br \/>/is', '</blockquote>', $p_string);
         # return the processed string.
         return $p_string;
      }
      //-------------------------------------------------------------------
      /**
       * Convert all HTML inside code tags to html entities.
       *
       * @param   string $p_string
       * @return  string $p_string
       */
      function string_escape_code( $p_string ) {
         # store value in var (due to issues with $this inside callbacks.)
         $mantisCoreFormatting = $this->t_MantisCoreFormatting;
         $p_string = preg_replace_callback('/\[code(.*?)\](.*?)\[\/code\]/s', function ($match)
         # use is only supported on PHP 5.3+.
         use ( $mantisCoreFormatting ) {
            # account for <br /> in code block (when using html syntax).
            $code = $match[2];
            if ( ON == $mantisCoreFormatting ) {
               # preview somehow uses \n only.
               $code = preg_replace( '/<br \/>\n/is', "\n", $code );
               # everywhere else uses \r\n.
               $code = preg_replace( '/<br \/>\r\n/is', "\r\n", $code );
            }
            # encode the remaining <br />.
            $code = str_replace("<br />",htmlentities("<br />"), $code);
            # return the code.
            return "[code" . strtolower($match[1]) . "]" . $code . "[/code]";
         }, $p_string);
         # return the formatted code.
         return $p_string;
      }
      //-------------------------------------------------------------------
      /**
       * Filter string and remove bbcode
       *
       * @param   string $p_string
       * @return  string $p_string
       */
       function string_strip_bbcode( $p_string ) {
         # perform sanitation before parsing.
         // convert mentions and titled links to BBCode mentions (if available).
         $p_string = preg_replace( '/<span class="mention"><a .*?href="(.*?)">(.*?)<\/a><\/span>/is', '$2 ($1)', $p_string);
         $p_string = preg_replace( '/<a href="([^"]*)" title="([^"]*)">([^"]*)<\/a>/is', '$3 ($1)', $p_string);
         # strip all active href so we can properly process them
         $p_string = string_strip_hrefs( $p_string );
         # escape all html code inside <code> tags.
         $p_string = $this->string_escape_code( $p_string );
         $p_string = $this->t_HTML->parse($p_string);
         # strip the BBCode
         $p_string = $this->t_bbCode->stripTags($p_string);
         # return the processed string.
         return $p_string;
       }
      //-------------------------------------------------------------------
   }
?>
