<!DOCTYPE html>
<html lang="en-us">
  <head>
	<meta charset="UTF-8">
	<title>JavaScript Markdown Editor - SimpleMDE</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
  </head>
  <body>
	<section class="main-content">
	  <h1><a id="h1_demo1" class="anchor" href="#h1_demo1" aria-hidden="true"><span class="octicon octicon-link"></span></a>Demo</h1>

<textarea id="demo1"># Intro
Go ahead, play around with the editor! Be sure to check out **bold** and *italic* styling, or even [links](http://google.com). You can type the Markdown syntax, use the toolbar, or use shortcuts like `cmd-b` or `ctrl-b`.

## Lists
Unordered lists can be started using the toolbar or by typing `* `, `- `, or `+ `. Ordered lists can be started by typing `1. `.

#### Unordered
* Lists are a piece of cake
* They even auto continue as you type
* A double enter will end them
* Tabs and shift-tabs work too

#### Ordered
1. Numbered lists...
2. ...work too!

## What about images?
![Yes](http://i.imgur.com/sZlktY7.png)</textarea>


	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
	<link rel="stylesheet" href="dist/simplemde.min.css">
	<script src="dist/simplemde.min.js"></script>
	
	<script>
	new SimpleMDE({
		element: document.getElementById("demo1"),
		spellChecker: false,
        autosave: {
			enabled: true,
			unique_id: "demo1",
		},
	});
	
	</script>
	
  </body>
</html>
