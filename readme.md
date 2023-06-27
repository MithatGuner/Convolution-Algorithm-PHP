# Convolution Algorithm in PHP

## [Kernel_(image_processing) Wikipedia](https://en.wikipedia.org/wiki/Kernel_(image_processing))


| Operation  | Kernel  | Image Result g(x,y) |
| :------------ |:---------------:| -----------:|
| Identity      | [0 0 0]<br>[0 1 0]<br>[0 0 0] | ![alt text](examples/identity.png) |
| Ridge         | [0 0 0]<br>[0 1 0]<br>[0 0 0] | ![alt text](examples/ridge.png)    |
| Edge Detection| [-1 -1 -1]<br>[-1 8 -1]<br>[-1 -1 -1] | ![alt text](examples/edge.png)    |
| Sharpen       | [0 -1 0]<br>[-1 5 -1]<br>[0 -1 0] | ![alt text](examples/sharpen.png)    |

## Usage

```
public function __construct($img_path, $kernel) { }
    @param mixed $img_path
    @param mixed $kernel
    @return void

public function convolution($image) { }
    @param mixed $image
    @return array
```

### Example
```
<?php
$kernel = array(
    array(0, 0, 0),
    array(0, 1, 0),
    array(0, 0, 0),
);
$conv = new convolution("image.png", $kernel);

$conv->createImage(
    "result.png",
    $conv->convolution($conv->r_array),
    $conv->convolution($conv->g_array),
    $conv->convolution($conv->b_array),
    $conv->convolution($conv->a_array)
);
```