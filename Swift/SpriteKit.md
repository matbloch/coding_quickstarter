# SpriteKit

## Shapes `SKShapeNode`



### `SKNode`

- position (CGPoint)
- xScale (CGFloat): representing the horizontal scale of a node
- yScale (CGFloat): similar to xScale but it acts in the vertical direction instead
- alpha (CGFloat): representing the node's transparency
- hidden (Bool): value determining whether or not the node should be visible
- zRotation (CGFloat): representing the angle, in radians, that the node should be rotated
- zPosition (CGFloat): used to determine which nodes should be displayed on top of other nodes in the scene



### Paths
**Shapes from Path**
```swift
let path = CGMutablePath()
path.addArc(center: CGPoint.zero,
            radius: 15,
            startAngle: 0,
            endAngle: CGFloat.pi * 2,
            clockwise: true)
let ball = SKShapeNode(path: path)
ball.lineWidth = 1
ball.fillColor = .blue
ball.strokeColor = .white
ball.glowWidth = 0.5
```


### `SKShapeNode`


**from Rectangle**
```swift
let redRect = SKShapeNode(rectOf: CGSize(width: 150.0, height: 50.0))
redRect.fillColor = UIColor.red
redRect.position = CGPoint(x: frame.midX, y: frame.midY)
view.addChild(redRect)
```


**from Points**
```swift
var points = [CGPoint(x: 0, y: 0),
              CGPoint(x: 100, y: 100),
              CGPoint(x: 200, y: -50),
              CGPoint(x: 300, y: 30),
              CGPoint(x: 400, y: 20)]
let linearShapeNode = SKShapeNode(points: &points,
                                  count: points.count)
let splineShapeNode = SKShapeNode(splinePoints: &points,
                                  count: points.count)
````


