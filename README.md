BBCodePlus
=============
## Description

BBCode plugin for Mantis BugTracker 2.x

Incorporates the following configurable features:

* Editor with toolbars and preview (using [jQuery MarkItUp](http://markitup.jaysalvat.com/home/)).
* BBCode processing.
* Syntax Highlighting (using [prismjs](http://prismjs.com/)).
* Mostly compatible with the Mantis Formatting plugin (this means they can both be enabled, if desired).
* NOTE: This plugin does **NOT** interact well with the **Markdown Processing** feature of the Mantis Formatting plugin. Disabling the functionality is advised.

## Repository Information

**NOTE:** BBCodePlus 2.x is now the **master** for the BBCodePlus project. Please re-fork or update your upstreams to follow the new model outlined below

| Branch                                                       | Description                                            |
| ------------------------------------------------------------ | ------------------------------------------------------ |
| [master](https://github.com/mantisbt-plugins/BBCodePlus)     | Support for MantisBT 2.x (current production version). |
| [master-1.2.x](https://github.com/mantisbt-plugins/BBCodePlus/tree/master-1.2.x) | Support for MantisBT 1.2.x (legacy).                   |
| [master-1.3.x](https://github.com/mantisbt-plugins/BBCodePlus/tree/master-1.3.x) | Support for MantisBT 1.3.x (legacy).                   |
## Change Log

###2.1.0
* Brand new BBCode/HTML parsers, from [Genert/bbcode](https://github.com/Genert/bbcode).
* Updated Prism code highlighter, now with Copy to Clipboard functionality.
* Addresses multiple outstanding issues.
* Added check for Mantis Formatting Markdown feature (warns if it is **ON**, as it will cause issues with BBCodePlus).
* Cleaned up lots of old code, which will make it easier to maintain.
###2.0.18
* Updated MarkItUp javascript dependency.
* Merged 

## Contributing to BBCodePlus

If you would like to contribute to BBCode plus, please [read this first](https://github.com/mantisbt-plugins/BBCodePlus/wiki/Contributing-to-BBCodePlus). 

## Screenshots:

![Markup editor](https://raw.githubusercontent.com/mantisbt-plugins/BBCodePlus/master/Screen1.png)

![Configuration](https://raw.githubusercontent.com/mantisbt-plugins/BBCodePlus/master-2.0.x/Screen2.png)

Considerations
-------------------------
* Requires mantis version 2.x+ or latest development build.

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
[tbbody][/tbopdy] - Table body block.
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

