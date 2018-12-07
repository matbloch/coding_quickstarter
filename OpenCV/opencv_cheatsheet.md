#OpenCV C++ API

## Basics

**Show image**

```cpp
cv::namedWindow( "Display window", cv::WINDOW_AUTOSIZE);
cv::imshow( "Display window", img );
cv::waitKey(1);
```

**Create an image**

```cpp
Mat grHistogram(301, 260, CV_8UC3, Scalar(0, 0, 0));
```





**OpenCV Matrix return policy**

```cpp
cv::Mat do_this(const cv::Mat & mat) {
    return mat.clone();
}
void do_this(const cv::Mat & in, cv::Mat & out) {
    out = in.clone();
}
```