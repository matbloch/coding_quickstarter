# Paper.js


- Context
	- projects: [ ],
	- activeProject: {...}
	- settings: {...}
	- tools: [ ]

- activeProject
	- `layers: [ ]`
	- `activeLayer: {...}`	holds the drawing `items` (e.g. `Path`)
	- `views: [ ]`
	- `activeView: {...}`	handles drawing and the view (project coordinates, scrolling, zooming etc.)
		- canvas

		
## Globals to Local Javascript

- `paper` is reference to current active paper scope
- `paper.project` current active project

## General Drawing

- Draw the view at the end, since that is now only automatically handled when a `view.onFrame` handler is installed.

```javascript
const { project, tools, view } = paper_scope;
// Option 1
paper_scope.Path.Circle({
	center: new Point(100, 100),
	fillColor: 'black',
	radius: 30
});

// Option 2
var path = new Path();
path.strokeColor = 'black';
var start = new Point(100, 100);
path.moveTo(start);
path.lineTo(start.add([ 200, -50 ]));

view.draw();
```


- When you create new items, they are automatically added to the end of the `item.children` list of the `project.activeLayer`.

## Implementing Custom Functionality


**Freehand Drawing**
- Create new path on every `onMouseDown` and add segments on `onMouseDrag`

**Undo Last Drawing Steps**
- `Path.remove()` on paths in `layer`

**Eraser Tool**
- Add path with `blendMode` set to `source-out`

**Separately Erasable Color Drawings**
- Create separate `Layer` for each color and `activate()` it just before adding the eraser paths

**Create PNG mask from SVG**
- export layers (color & eraser) as separate SVGs
- convert SVGs to PNG (Python?)

### SVG Structure



### `Tool`


```javascript
import {Tool, Path} from 'paper/dist/paper-core'
var my_tool = new Tool();
my_tool.minDistance = 10;

var path;
my_tool.onMouseDown = function(event) {
	// Create a new path every time the mouse is clicked
	path = new Path();
	path.add(event.point);
	path.strokeColor = 'black';
	view.draw();
	console.log(this._scope);	// the paper scope
}

my_tool.onMouseDrag = function(event) {
	// Add a point to the path every time the mouse is dragged
	path.add(event.point);
	view.draw();
}

```