BBCodePlus
=============
BBCode plugin for Mantis BugTracker 1.2

* See [BBCodePlus](https://github.com/mantisbt-plugins/BBCodePlus) for the Mantis 1.3 version.
* See [2.0.x branch](https://github.com/mantisbt-plugins/BBCodePlus/tree/master-2.0.x) for the Mantis 2.0 version.

Incorporates the following configurable features:

* Editor with toolbars and preview (using [jQuery MarkItUp](http://markitup.jaysalvat.com/home/)).
* BBCode processing.
* Syntax Highlighting (using [prismjs](http://prismjs.com/)).

Screenshots:

![Markup editor](https://raw.githubusercontent.com/mantisbt-plugins/BBCodePlus/master/Screen1.png)

![Configuration](https://raw.githubusercontent.com/mantisbt-plugins/BBCodePlus/master/Screen2.png)

Considerations
-------------------------
* Requires the use of the [jQuery plugin](https://github.com/mantisbt-plugins/jquery).

Supported BBCode Tags
---------------------
```
[img][/img] - Images.
[url][/url] - Links.
[email][/email] - Email addresses.
[color=red][/color] - Colored text.
[highlight=yellow][/highlight] - Highlighted text.
[size][/size] - Font size.
[list][/list] - Lists.
[list=1][/list] - Numbered lists (number is starting number).
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
[tr][/tr] - Table row.
[td][/td] - Table column.
[code][/code] - Code block.
[code=sql][/code] - Code block with language definition.
[code start=3][/code] - Code block with line numbers starting at number.
[quote][/quote] - Quote by *someone* (no name).
[quote=name][/quote] - Quote by *name*.
```
