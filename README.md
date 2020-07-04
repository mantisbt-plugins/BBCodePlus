BBCodePlus
=============
## Description

BBCode plugin for Mantis BugTracker 1.3 (at least 1.3.0-rc.1).

Incorporates the following configurable features:

* Editor with toolbars and preview (using [jQuery MarkItUp](http://markitup.jaysalvat.com/home/)).
* BBCode processing.
* Syntax Highlighting (using [prismjs](http://prismjs.com/)).
* Mostly compatible with the Mantis Formatting plugin (this means they can both be enabled, if desired).

## Repository Information

**NOTE:** BBCodePlus 2.x is now the **master** for the BBCodePlus project. Please **re-fork** or (carefully) **update** your fork (branch structure on upstream and origin).

| Branch                                                       | Description                                            |
| ------------------------------------------------------------ | ------------------------------------------------------ |
| [master](https://github.com/mantisbt-plugins/BBCodePlus)     | Support for MantisBT 2.x (current production version). |
| [master-1.3.x](https://github.com/mantisbt-plugins/BBCodePlus/tree/master-1.3.x) | Support for MantisBT 1.3.x (legacy).                   |
## Contributing to BBCodePlus

If you would like to contribute to BBCode plus, please [read this guide first](https://github.com/mantisbt-plugins/BBCodePlus/wiki/Contributing-to-BBCodePlus). 

## Change Log


### 1.3.17

- Fixed styling and scripting issues with issue image picker. 
- Resized markItUp editor elements.

### 1.3.16

- NEW: Added image picker modal for picking images that have been uploaded to issue.

### 1.3.15

- Now including clipboard.min.js locally, to avoid cdn interaction.

### 1.3.14

- Corrected email parsing behavior when Email Processing is turned on. MantisBT does not support HTML email natively.

### 1.3.13

- Added the following characters to work with the quotee's name in the named quote function (basically to support email-adresses here): . @ - [@FSD-Christian-ISS](https://github.com/FSD-Christian-ISS)

### 1.3.12

- Fixed display of quotes when quotee's name contains unicode characters, commas or single quotes [@FSD-Christian-ISS](https://github.com/FSD-Christian-ISS)

### 1.3.11

- Fixed issue with additional protocols in link insertion.

### 1.3.10

- Fixed rendering issue of code blocks when language parameter was left empty
- Fixed rendering issue of quote blocks when quotee parameter contained whitespaces 

### 1.3.9

- Fixed display issue of loose links (thanks to [@FSD-Christian-ISS](https://github.com/FSD-Christian-ISS) )

### 1.3.8

- Removed leftover debug call that was breaking display.

### 1.3.7

- Corrected outstanding bug with resolved bug links.

### 1.3.6

- Corrected bug in handling of mention links.

### 1.3.5

- Corrected use of `$this` inside code replace callback (causes issues with older versions of PHP).

### 1.3.4

- Corrected issues with bug links and mentions.
- Dropped support for CVS links.
- Added better code block support for HTML syntax (`<br/>` tags were getting dropped).
- Removed duplication of MantisCoreFormatting features. They will be used only when the plugin is enabled.

### 1.3.3

- Cleaned up issues with undefined variable notices from old code.

### 1.3.2

* Added MarkItUp toolbar support for custom textarea fields.
### 1.3.1
* Updated README for all languages supported by code highlighter.

* Brand new BBCode/HTML parsers, from [Genert/bbcode](https://github.com/Genert/bbcode).
* Updated Prism code highlighter, now with Copy to Clipboard functionality.
* Addresses multiple outstanding issues.
* Cleaned up lots of old code, which will make it easier to maintain.
## Screenshots:

![Markup editor](https://raw.githubusercontent.com/mantisbt-plugins/BBCodePlus/master-1.3.x/Screen1.png)

![Configuration](https://raw.githubusercontent.com/mantisbt-plugins/BBCodePlus/master-1.3.x/Screen2.png)

![Configuration](https://raw.githubusercontent.com/mantisbt-plugins/BBCodePlus/master-1.3.x/Screen3.png)

Considerations
-------------------------
* Requires version 1.3.0-rc.1 or latest development build (See mantisbt issue [#0020081](https://www.mantisbt.org/bugs/view.php?id=20081)).

Supported BBCode Tags
---------------------
```
[img][/img] - Images.
[url][/url] - Links.
[email][/email] - Email addresses.
[color=red][/color] - Colored text.
[highlight=yellow][/highlight] - Highlighted text.
[size][/size] - Font size.
[list][/list] - Unordered lists.
[list=1][/list] - Numbered lists (number is starting number).
[list=a][/list] - Alpha lists (letter is starting letter).
[*] - List items.
[b][/b] - Bold.
[u][/u] - underline
[i][/i] - Italic.
[s][/s] - Strikethrough.
[left][/left] - Left align.
[center][/center] - Center.
[right][/right] - Right align.
[justify][/justify] - Justify.
[hr] - Horizontal rule.
[sub][/sub] - Subscript.
[sup][/sup] - Superscript.
[table][/table] - Table.
[table=1][/table] - Table with border of specified width.
[thead][/thead] - Table head block.
[tbody][/tbody] - Table body block.
[tr][/tr] - Table row.
[th][/th] - Table header column.
[td][/td] - Table column.
[code][/code] - Code block.
[code=sql][/code] - Code block with language definition.
[code start=3][/code] - Code block with line numbers starting at number.
[code=sql start=3][/code] - Code block with language definition and line numbers starting at number.
[quote][/quote] - Quote by *someone* (no name).
[quote=name][/quote] - Quote by *name*.
```

## Supported Languages for Code Highlighting

The implementation of prism.js includes support for languages in 2 modes:

* default (supported on plugin install).
* Add support for extra languages (through the plugin's configuration page).

### Languages supported by default

| Keyword | Description |
|------- | ----|
| aspnet | ASP.NET |
| bash | Bash + Shell |
| basic | BASIC |
| batch | Batch |
| clike | C-like |
| cpp | C++ |
| csharp | C# |
| csp | CoffeeScript |
| css | CSS |
| c | C |
| django | Django/Jinja2 |
| docker | Docker |
| hpkp | HTTP Public-Key-Pins |
| hsts | HTTP Strict-Transport-Security |
| http | HTTP |
| ini | Ini |
| javadoclike | JavaDoc-like |
| javascript | JavaScript |
| java | Java |
| js-extras | JS Extras |
| json5 | JSON5 |
| jsonp | JSONP |
| json | JSON |
| markup-templating | Markup templating |
| markup | Markup + HTML + XML + SVG + MathML |
| nginx | nginx |
| pascal | Pascal + Object Pascal |
| perl | Perl |
| php-extras | PHP Extras |
| phpdoc | PHPDoc |
| php | PHP |
| plsql | PL/SQL |
| powershell | PowerShell |
| python | Python |
| regex | Regex |
| ruby | Ruby |
| smarty | Smarty |
| sql | SQL |
| vbnet | VB.NET |
| vim | vim |
| visual-basic | Visual Basic |
| wiki | Wiki markup |
| xquery | XQuery |
| yaml | YAML |

### Languages supported by the extra languages feature

| Keyword | Description |
|----|----|
| abap | ABAP |
| actionscript | ActionScript |
| apl | APL |
| applescript | AppleScript |
| autohotkey | AutoHotKey |
| bison | Bison |
| brainfuck | Brainfuck |
| coffeescript | CoffeeScript |
| css-extras | CSS Extras |
| dart | Dart |
| diff | Diff |
| d | D |
| eiffel | Eiffel |
| elixir | Elixir |
| erlang | Erlang |
| fortran | Fortran |
| fsharp | F# |
| gherkin | Gherkin |
| git | Git |
| glsl | GLSL |
| go | Go |
| groovy | Groovy |
| haskell | Haskell |
| inform7 | Inform 7 |
| jsx | React JSX |
| julia | Julia |
| j | J |
| keyman | Keyman |
| latex | LaTex |
| less | Less |
| lolcode | LOLCODE |
| makefile | Makefile |
| markdown | Markdown |
| matlab | MATLAB |
| mel | MEL |
| mizar | Mizar |
| monkey | Monkey |
| nasm | NASM |
| nim | Nim |
| nsis | NSIS |
| objectivec | Objective-C |
| ocaml | OCaml |
| processing | Processing |
| prolog | Prolog |
| pure | Pure |
| qore | Qore |
| q | Q |
| regex | Regex |
| rest | reST |
| rip | Rip |
| rust | Rust |
| r | R |
| sass | Sass (Sass) |
| sas | SAS |
| scala | Scala |
| scheme | Scheme |
| scss | Sass (Scss) |
| smalltalk | Smalltalk |
| swift | Swift |
| tcl | Tcl |
| twig | Twig |
| typescript | TypeScript |
| verilog | Verilog |
| vhdl | VHDL |