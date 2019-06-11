# HTML5





## Reading Local Files



### Looping through files

*The Input Element*

```javascript
<input type="file" id="input" multiple onchange="handleFiles(this.files)">
```

*Processing*

```javascript
  //this function is called when the input loads an image
	function renderImage(file){
		var reader = new FileReader();
		reader.onload = function(event){
			the_url = event.target.result
      //of course using a template library like handlebars.js is a better solution than just inserting a string
			$('#preview').html("<img src='"+the_url+"' />")
			$('#name').html(file.name)
			$('#size').html(humanFileSize(file.size, "MB"))
			$('#type').html(file.type)
		}
    
    //when the file is read it triggers the onload event above.
		reader.readAsDataURL(file);
	}

//check if browser supports file api and filereader features
if (window.File && window.FileReader && window.FileList && window.Blob) {
	var inputElement = document.getElementById("input");
    inputElement.addEventListener("change", handleFiles, false);
    function handleFiles() {
      var fileList = this.files; /* Jetzt kann die Dateiliste verarbeitet werden */
    }
} else {
    alert('The File APIs are not fully supported in this browser.');
}
```

**File Information**

- `name`
- `size`
- `type` the mime type

```javascript
for (var i = 0, numFiles = files.length; i < numFiles; i++) {
  var file = files[i];
}
```



### Opening Files

https://developer.mozilla.org/de/docs/Web/API/File/Zugriff_auf_Dateien_von_Webapplikationen

```javascript
function handleFiles(files) {
  for (var i = 0; i < files.length; i++) {
    var file = files[i];
    var imageType = /^image\//;
    
    if (!imageType.test(file.type)) {
      continue;
    }
    
    var img = document.createElement("img");
    img.classList.add("obj");
    img.file = file;
    preview.appendChild(img); // Gehen wird davon aus, dass "preview" das div-Element ist, in dem der Inhalt angezeigt wird.
    
    var reader = new FileReader();
    reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(img);
    reader.readAsDataURL(file);
  }
}
```



**Object URLs**

```javascript
var objectURL = window.URL.createObjectURL(fileObj);
```

```javascript
window.URL.revokeObjectURL(objectURL);
```





```javascript
var img = document.createElement("img");
img.src = window.URL.createObjectURL(files[i]);
img.height = 60;
img.onload = function() {
    window.URL.revokeObjectURL(this.src);
}
```

