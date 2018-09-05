# SceneKit


### Managing Scenes

- `SCNScene`
	- `var rootNode: SCNNode`
- `SCNNode`
	- `func addChildNode(SCNNode)`
	- `var childNodes: [SCNNode]`
	- `var parent: SCNNode?`
	- `func removeFromParentNode()`


**Searching Node by Name**
- First node with name: `func childNode(withName name: String, recursively: Bool) -> SCNNode?`

**Enumerating Nodes**
```swift
self.sceneView.scene.rootNode.enumerateChildNodes{ (node, stop) in
    node.removeFromParentNode()
}
```

### Node Transformation

**Assign Transform**
```swift
transform: float4x4?
var node = SCNNode()
node.transform = SCNmatrix4(transform)
```


### View Coordinates

**Image coordinates to View coordinates**
```swift
let orientation = UIInterfaceOrientation.portrait
let viewportSize = self.sceneView.frame.size
let fromCameraToViewTransform = frame.displayTransform(for: orientation, viewportSize: viewportSize)
let my_point = CGPoint(x: 100, y: 20)
let view_coordinates = my_point.applying(fromCameraToViewTransform)
```

**View coordinates to Image coordinates**
```swift
let fromViewToCameraTransform = frame.displayTransform(for: orientation, viewportSize: viewportSize).inverted()
let tap_location = CGPoint(x: 100, y: 20)
let image_coordiantes = tap_location.applying(fromViewToCameraTransform)
```


### Geometry Primitives

**Clone Geometry**
`var geometry_copy: SCNGeometry = geometry.copy() as! SCNGeometry`


# ARKit



**ARSceneView**
- `var session: ARSession`
- `var scene: SCNScene`
- `func unprojectPoint(_ point: CGPoint, ontoPlane planeTransform: simd_float4x4) -> simd_float3?`
- `func hitTest(_ point: CGPoint, types: ARHitTestResult.ResultType) -> [ARHitTestResult]`

### Hit Testing


```swift
let results = view.hitTest(point, [.existingPlaneUsingGeometry, .estimatedHorizontalPlane])
```


**Results**
- A list of results, sorted from nearest to farthest (in distance from the camera).
- can refer to any point along a 3D line that starts at the device camera

**Target Hit Types**
- featurePoint
- estimatedHorizontalPlane
- estimatedVerticalPlane
- existingPlane
- existingPlaneUsingExtent
- existingPlaneUsingGeometry


**ARFrame vs SCNView Hittesting**
- ARFrame: in normalized frame coordinates
- view: in view coordinates

#### Examples


**First result**
```swift
let firstResult = view.hitTest(point).first
```


### Point Projections


# Core Graphis


### CGPoint

```swift
// Declare `-` operator overload function
func -(lhs: CGPoint, rhs: CGPoint) -> CGPoint {
    return CGPoint(x: lhs.x - rhs.x, y: lhs.y - rhs.y)
}
func +(lhs: CGPoint, rhs: CGPoint) -> CGPoint {
    return CGPoint(x: lhs.x + rhs.x, y: lhs.y + rhs.y)
}
```



