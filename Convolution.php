<?php



class convolution {
    public $kernel = [];

    private $img;
    private $img_w;
    private $img_h;
    public $r_array = [];
    public $g_array = [];
    public $b_array = [];
    public $a_array = [];

    public $colors_array = [];

    private function getPixelColors($x, $y){
        $rgb = imagecolorat($this->img, $x,$y);
        $colors = imagecolorsforindex($this->img, $rgb);
    
        // $red = ($rgb >> 16) & 255;
        // $green = ($rgb >> 8) & 255;
        // $blue = $rgb & 255;
        return $colors;
    }
    public function getColorArray(){
        $color_array = [];
        for($x = 0; $x < $this->img_w; $x++){
            for($y = 0; $y < $this->img_h; $y++){
                $pixel = $this->getPixelColors($x, $y);
                $color_array[$x][$y] = $pixel;
                $this->r_array[$x][$y] = $pixel["red"];
                $this->g_array[$x][$y] = $pixel["green"];
                $this->b_array[$x][$y] = $pixel["blue"];
                $this->a_array[$x][$y] = $pixel["alpha"];

            }
        }
        return $color_array;
    }

    public function createImage($result,$red_arr, $g_arr, $b_arr, $a_array){
        $w = count($red_arr);
        $h = count($red_arr[0]);
        
        $img=imagecreatetruecolor($w,$h);
        imagesavealpha($img,true);
        imagealphablending($img,false);
        for($x = 0; $x<=$w; $x++){
            for($y = 0; $y<=$h; $y++){
                $r = $red_arr[$x][$y];
                if($r > 255)
                    $r = 255;
                if($r < 1)
                    $r = 0;
                $g = $g_arr[$x][$y];
                if($g > 255)
                    $g = 255;
                if($g < 1)
                    $g = 0;
                $b = $b_arr[$x][$y];
                if($b > 255)
                    $b = 255;
                if($b < 1)
                    $b = 0;
                $alpha = $a_array[$x][$y];
                
                $color = imagecolorallocatealpha($img,$r,$g,$b,$alpha);
                imagesetpixel($img,$x,$y,$color);
            }
        }
        imagepng($img,$result);
    }

    function convolution($image) {
        $imageWidth = count($image[0]);
        $imageHeight = count($image);
        
        $kernelWidth = count($this->kernel[0]);
        $kernelHeight = count($this->kernel);
        
        $output = array();
        
        for ($y = 0; $y < $imageHeight - $kernelHeight + 1; $y++) {
            for ($x = 0; $x < $imageWidth - $kernelWidth + 1; $x++) {
                $sum = 0;
                $p_count=0;
                for ($ky = 0; $ky < $kernelHeight; $ky++) {
                    for ($kx = 0; $kx < $kernelWidth; $kx++) {
                        $sum += $image[$y + $ky][$x + $kx] * $this->kernel[$ky][$kx];
                        if($image[$y + $ky][$x + $kx] * $this->kernel[$ky][$kx] != 0){
                            $p_count++;
                        }
                    }
                }
                
                $output[$y][$x] = ($sum) ? round($sum/$p_count+1) : 0;
            }
        }
        
        return $output;
    }
    public function __construct($img_path, $kernel){
        $this->kernel = $kernel;
        $img = imagecreatefrompng($img_path);
        $this->img = $img;
        $this->img_w = imagesx($this->img);
        $this->img_h = imagesy($this->img);
        $this->colors_array = $this->getColorArray();
    }
}