<?php
    session_start();

    // 验证码图片大小
    $width = 150;
    $height = 40;

    // 创建图片
    $image = imagecreatetruecolor($width, $height);

    // 设置背景为透明
    imagealphablending($image, false);
    $transparency = imagecolorallocatealpha($image, 0, 0, 0, 127);
    imagefill($image, 0, 0, $transparency);
    imagesavealpha($image, true);

    // 生成随机字符
    $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $length = 4;
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[rand(0, strlen($characters) - 1)];
    }

    // 保存到session
    $_SESSION['session'] = $string;

    // 设置字体颜色
    $textColor = imagecolorallocate($image, 255, 255, 255);

    // 设置字体路径（使用系统默认字体）
    $font = 'C:/Windows/Fonts/Arial.ttf';  // Windows 系统字体路径
    if (!file_exists($font)) {
        $font = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf';  // Linux 系统字体路径
    }

    // 计算文本大小和位置
    $fontSize = 24;
    $angle = 0;
    $bbox = imagettfbbox($fontSize, $angle, $font, $string);
    $textWidth = $bbox[2] - $bbox[0];
    $textHeight = $bbox[1] - $bbox[7];
    $x = ($width - $textWidth) / 2;
    $y = ($height + $textHeight) / 2;

    // 添加文字
    imagettftext($image, $fontSize, $angle, $x, $y, $textColor, $font, $string);

    // 添加干扰线
    for ($i = 0; $i < 3; $i++) {
        $lineColor = imagecolorallocatealpha($image, 255, 255, 255, 100);
        $x1 = rand(0, $width);
        $y1 = rand(0, $height);
        $x2 = rand(0, $width);
        $y2 = rand(0, $height);
        imageline($image, $x1, $y1, $x2, $y2, $lineColor);
    }

    // 添加噪点
    for ($i = 0; $i < 50; $i++) {
        $pointColor = imagecolorallocatealpha($image, 255, 255, 255, rand(70, 100));
        imagesetpixel($image, rand(0, $width), rand(0, $height), $pointColor);
    }

    // 输出图片
    header('Content-Type: image/png');
    imagepng($image);
    imagedestroy($image);

?>