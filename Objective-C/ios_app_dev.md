# iOS Application Development in Objective C



## Project Structure

```bash
- YourApplication
    AppDelegate.h / .m			// app launch points
    ViewController.h / .m       // view controller
	Main.storyboard		        // view
```

**Default iPhone App Flow**
`AppDelegate (Object) > View Controller (Object) > View Controller (View)`


- `AppDelegate` Creates a ViewController object when app is launched
- `ViewController` Sets up the view described in `Main.storyboard` and shows it on the screen



## The Storyboard
- The storyboard (default: `Main.storyboard`) shows all the contents of the scenes
	- set in `info.plist` "Main storyboard file base name"
	- or in settings: "Project Settings > General > Deployment Info"

**Switching the Storyboard View**
- e.g. Display code and UI layout side by side
![storyboard_view.png](./img_app_tutorial/storyboard_view.png)


**Default Scene Contains:**
- View Controller
- First Responder
- Exit

![xcode_scene_content.png](./img/xcode_scene_content.png)

**Scene Dock**
- Miniature version of the document outline
![xcode_scene_dock.png](./img/xcode_scene_dock.png)

**Example View Controller**
```cpp
@interface ViewController : UIViewController

@end
```

## View Controllers
- manages user interface and interaction between interface and data
- base class: `UIViewController`

#### View Controller Types

**Regular View Controller**

**Container View Controller**
- Example: Tab Bar
- Contains multiple sub-views



# Tutorial: Creating an Application

## 0. Terminology

**Scene**
- represents one screen of content and (typically) one view controller

**View Controller**
- Implements app's behaviour
- Manages single content view with its hierarchy of subviews
- All view controllers are of type `UIViewController` or one of its subclasses

**Storyboard**
- Visual compositor for the UI
- Connection between the defined code (view controller) and the UI is defined here

**Outlets**
- reference interface objects from the storyboard in source code files
- Storyboard UI Element <-> code link

## 1. Create a new project from an XCode Template
Project structure:

- YourApp
    - `AppDelegate.h/.m	` default application launch point, no content
    - `Main.storyboard`	 the main view/scene overview
    - `LaunchScreen.storyboard` view/scene for the launch screen
    - `info.plist`  project settings (requirements, storyboard selection, app identifier)
    - `main.m` launches the application with `AppDelegate`

## 2. Specify Storyboards

- open `info.plist` and select the storyboard files in "Main storyboard file..." and "Launch screen interface file..."
- Select the project, go the "General" tab and select the main storyboard file in the section "Deployment Info" under "Main interface"

## 3. Add Content to Storyboard

- Open `Main.storyboard`
- Select *Object Library* and drag&drop **"View Controller"** into scene
- Add additional UI elements, such as buttons, text fields etc.

![add_view_controller.png](./img_app_tutorial/add_view_controller.png)

## 4. Add View Controller Source

**ViewController.h**
```cpp
#import <UIKit/UIKit.h>
@interface ViewController : UIViewController
@end
```

**ViewController.m**
```cpp
#import "ViewController.h"

@implementation ViewController
- (void)viewDidLoad {
  [super viewDidLoad];
}

@end

```

## 5. Connecting UI Elements to Code

**Connecting View Controller**

- Switch to Storyboard and select the View Controller in the scene content
- Select identity inspector and select the controller class `ViewController` that was created in the code
![identity_inspector.png](./img_app_tutorial/identity_inspector.png)

**Select Initial View**
- Select view controller and check "Is Initial View Controller"
![initial_view_controller.png](./img_app_tutorial/initial_view_controller.png)




**Connecting UI Elements**


# UI Elements

## Switch

- Add switch to Storyboard
- **Link switch state**: Right-Click drag&drop into `@interface` section of `ViewController.m` (current scene view controller)
- **Link action**: Right-Click drag&drop into `@implementation` section
	- From the context menu, select the preferred action ()

```cpp
@interface ViewController () <ARSCNViewDelegate>
// state
@property (weak, nonatomic) IBOutlet UISwitch *awesomeSwitch;
@end

// action
@implementation ViewController
- (IBAction)switchPressed:(id)sender {
}
@end

```


## ARKit SceneKit View

- In the Storboard, add "ARKit SceneKit View" to a view
- **Link AR View**: Drag&drop view onto `@interface` section
- **Configure tracking**: In standard view controller method `(void)viewDidLoad`
- **Start tracking**: In standard view controller method `(void)viewWillAppear`
- **Pause tracking**: In standard view controller method `(void)viewWillDisappear`


```cpp
@interface ViewController () <ARSCNViewDelegate>
// the AR view
@property (strong, nonatomic) IBOutlet ARSCNView *sceneView;
@end
```


**View loaded: Configure tracking**

```cpp
- (void)viewDidLoad {
    [super viewDidLoad];
    // Set the view's delegate
    self.sceneView.delegate = self;
    // Show statistics such as fps and timing information
    self.sceneView.showsStatistics = YES;
    // Create a new scene
    SCNScene *scene = [SCNScene sceneNamed:@"art.scnassets/ship.scn"];
    // debug options
    self.sceneView.debugOptions =
    ARSCNDebugOptionShowWorldOrigin |
    ARSCNDebugOptionShowFeaturePoints;
    // Set the scene to the view
    self.sceneView.scene = scene;
}
```

**View appear: Run tracking session**
```cpp
- (void)viewWillAppear:(BOOL)animated {
    [super viewWillAppear:animated];
    // Create a session configuration
    ARWorldTrackingConfiguration *configuration = [ARWorldTrackingConfiguration new];
    // Run the view's session
    [self.sceneView.session runWithConfiguration:configuration];
}
```

**View disappear: Pause tracking session**
```cpp
- (void)viewWillDisappear:(BOOL)animated {
    [super viewWillDisappear:animated];
    // Pause the view's session
    [self.sceneView.session pause];
}
```

# ARKit Application

#### Initialization

```cpp
@interface <your view controller name>()
@property (nonatomic, strong) ARSession *session;
@end


// then somewhere in your implementation block...
// official example shows you ought to declare the session in viewWillLoad and initialize in viewWillAppear but it probably doesn't matter.

self.session = [ARSession new];

// World tracking is used for 6DOF, there are other tracking configurations as well, see 
// https://developer.apple.com/documentation/arkit/arconfiguration
ARWorldTrackingConfiguration *configuration = [ARWorldTrackingConfiguration new];

// setup horizontal plane detection - note that this is optional 
configuration.planeDetection = ARPlaneDetectionHorizontal;

// start the session
[self.session runWithConfiguration:configuration];
```






