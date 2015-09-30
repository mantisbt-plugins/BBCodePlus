// ----------------------------------------------------------------------------
// markItUp!
// ----------------------------------------------------------------------------
// Copyright (C) 2008 Jay Salvat
// http://markitup.jaysalvat.com/
// ----------------------------------------------------------------------------
// BBCode tags example
// http://en.wikipedia.org/wiki/Bbcode
// ----------------------------------------------------------------------------
// Feel free to add more tags
// ----------------------------------------------------------------------------
mySettings = {
	// parser determined in plugin code.
	previewParserPath: '',
	markupSet: [
		{name:'Bold', key:'B', openWith:'[b]', closeWith:'[/b]'},
		{name:'Italic', key:'I', openWith:'[i]', closeWith:'[/i]'},
		{name:'Strike', key:'S', openWith:'[s]', closeWith:'[/s]'},
		{name:'Underline', key:'U', openWith:'[u]', closeWith:'[/u]'},
		{separator:'---------------' },
		{	name:'Colors', 
			className:'colors', 
			openWith:'[color=[![Color]!]]', 
			closeWith:'[/color]', 
				dropMenu: [
					{name:'Yellow',	openWith:'[color=yellow]', 	closeWith:'[/color]', className:"col1-1" },
					{name:'Orange',	openWith:'[color=orange]', 	closeWith:'[/color]', className:"col1-2" },
					{name:'Red', 	openWith:'[color=red]', 	closeWith:'[/color]', className:"col1-3" },
					
					{name:'Blue', 	openWith:'[color=blue]', 	closeWith:'[/color]', className:"col2-1" },
					{name:'Purple', openWith:'[color=purple]', 	closeWith:'[/color]', className:"col2-2" },
					{name:'Green', 	openWith:'[color=green]', 	closeWith:'[/color]', className:"col2-3" },
					
					{name:'White', 	openWith:'[color=white]', 	closeWith:'[/color]', className:"col3-1" },
					{name:'Gray', 	openWith:'[color=gray]', 	closeWith:'[/color]', className:"col3-2" },
					{name:'Black',	openWith:'[color=black]', 	closeWith:'[/color]', className:"col3-3" }
				]
		},
		{	name:'Highlight', 
			className:'colors', 
			openWith:'[highlight=[![Color]!]]', 
			closeWith:'[/highlight]', 
				dropMenu: [
					{name:'Yellow',	openWith:'[highlight=yellow]', 	closeWith:'[/highlight]', className:"col1-1" },
					{name:'Orange',	openWith:'[highlight=orange]', 	closeWith:'[/highlight]', className:"col1-2" },
					{name:'Red', 	openWith:'[highlight=red]', 	closeWith:'[/highlight]', className:"col1-3" },
					
					{name:'Blue', 	openWith:'[highlight=blue]', 	closeWith:'[/highlight]', className:"col2-1" },
					{name:'Purple', openWith:'[highlight=purple]', 	closeWith:'[/highlight]', className:"col2-2" },
					{name:'Green', 	openWith:'[highlight=green]', 	closeWith:'[/highlight]', className:"col2-3" },
					
					{name:'White', 	openWith:'[highlight=white]', 	closeWith:'[/highlight]', className:"col3-1" },
					{name:'Gray', 	openWith:'[highlight=gray]', 	closeWith:'[/highlight]', className:"col3-2" },
					{name:'Black',	openWith:'[highlight=black]', 	closeWith:'[/highlight]', className:"col3-3" }
				]
		},		
		{name:'Size', key:'S', openWith:'[size=[![Text size]!]]', closeWith:'[/size]',
		dropMenu :[
			{name:'Big', openWith:'[size=125]', closeWith:'[/size]' },
			{name:'Normal', openWith:'[size=100]', closeWith:'[/size]' },
			{name:'Small', openWith:'[size=75]', closeWith:'[/size]' }
		]},		
		{name:'Superscript', openWith:'[sup]', closeWith:'[/sup]'},
		{name:'Subscript', openWith:'[sub]', closeWith:'[/sub]'},				
		{separator:'---------------' },
		{name:'Bulleted list', replaceWith: function(markitup)
			{
				// process the selection to dynamically convert lines into bullets.
				var tmp;
				var text;
				
				if (markitup.selection.length) {
					// get the textarea selection
					sel = markitup.selection;

					// store the lines in an array
					var lines = new Array();
					lines = sel.split("\n");
					
					// if we have more than one line, add
					// [*] to each line.
					if ( lines.length > 0 ) {
						text = '';
						for( var i=0; i<lines.length; i++ ) {
							text += "[*]" + lines[i];
							text += "\n";
						}
					}
					
					// return the formatted list
					tmp = "[list]\n";
					tmp += text;
					tmp += "[/list]";					
				} else {
					// return an empty list with one default bullet
					tmp = "[list]\n";
					tmp += "[*]\n";
					tmp += "[/list]";
				}
				
				return tmp;
			}
		},
		//{name:'Numeric list', openWith:'[list=[![Starting number]!]]\n', closeWith:'\n[/list]'}, 
		{name:'Numeric list', replaceWith: function(markitup)
			{
				// process the selection to dynamically convert lines into bullets.
				var tmp;
				var text;
				var startnum;
				
				startnum = prompt("Starting number:", 1);
				
				if (markitup.selection.length) {
					// get the textarea selection
					sel = markitup.selection;

					// store the lines in an array
					var lines = new Array();
					lines = sel.split("\n");
					
					// if we have more than one line, add
					// [*] to each line.
					if ( lines.length > 0 ) {
						text = '';
						for( var i=0; i<lines.length; i++ ) {
							text += "[*]" + lines[i];
							text += "\n";
						}
					}
					
					// return the formatted list
					tmp = "[list=" + startnum + "]\n";
					tmp += text;
					tmp += "[/list]";					
				} else {
					// return an empty list with one default bullet
					tmp = "[list=" + startnum + "]\n";
					tmp += "[*]\n";
					tmp += "[/list]";
				}
				
				return tmp;	
			}
		},
		{name:'List item', openWith:'[*]'},
		{separator:'---------------' },
		{name:'Code', openWith:'[code=[![Language]!]]', closeWith:'[/code]'},
		{name:'Quote', key:'Q', openWith:'[quote=[![Who said it?]!]]', closeWith:'[/quote]'},		
		{name:'Horizontal rule', openWith:'\n[hr]\n'},		
		{separator:'---------------' },
		{name:'Left', openWith:'[left]', closeWith:'[/left]'},		
		{name:'Center', openWith:'[center]', closeWith:'[/center]'},		
		{name:'Right', openWith:'[right]', closeWith:'[/right]'},
		{name:'Justify', openWith:'[justify]', closeWith:'[/justify]'},
		{separator:'---------------' },										
		{name:'Link', openWith:'[url=[![Url]!]]', closeWith:'[/url]', placeHolder:'Your text to link here...'},
		{name:'Email', key:'E', openWith:'[email=[![Email]!]]', closeWith:'[/email]',  placeHolder:"Your email here"},
		{name:'Picture', key:'P', replaceWith:'[img][![Url]!][/img]'},
		{separator:'---------------' },
		{name:'Clean', className:"clean", replaceWith:function(markitup) { return markitup.selection.replace(/\[(.*?)\]/g, "") } },
		{name:'Preview', className:"preview", replaceWith:function(markitup) {
				// invoke preview method.
				(function($) {
					$(markitup.textarea).markItUpPreview(); 
				})(jQuery);
				
				return; 
			}		
		}	
	]
}