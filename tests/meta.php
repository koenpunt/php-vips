<?php

use Jcupitt\Vips;

class VipsMetaTest extends PHPUnit_Framework_TestCase 
{

    public function testVipsSetGet()
    {
        $filename = dirname(__FILE__) . "/images/img_0076.jpg";
        $image = Vips\Image::newFromFile($filename, ["shrink" => 2]);

        $image->poop = "banana";
        $value = $image->poop;

        $this->assertEquals($value, "banana");
    }

    public function testVipsGetExifData()
    {
        $filename = dirname(__FILE__) . "/images/img_0076.jpg";
        $image = Vips\Image::newFromFile($filename, ["shrink" => 2]);

        $name = "exif-data";
        $exif = $image->$name;

        # 9724 bytes of exif attached ... this should work even without libexif
        $this->assertEquals(strlen($exif), 9724);
    }

    public function testVipsGetThumbnail()
    {
        $filename = dirname(__FILE__) . "/images/img_0076.jpg";
        $image = Vips\Image::newFromFile($filename, ["shrink" => 2]);

        $thumbnail_data = $image->get("jpeg-thumbnail-data");
        $thumb = Vips\Image::newFromBuffer($thumbnail_data);

        $this->assertEquals($thumb->width, 160);
    }

    public function testVipsGetTypeof()
    {
        $filename = dirname(__FILE__) . "/images/img_0076.jpg";
        $image = Vips\Image::newFromFile($filename, ["shrink" => 2]);

        $gint = $image->typeof("width");

        // should always be the same, I think
        $this->assertEquals($gint, 24);
    }

    public function testVipsRemove()
    {
        $filename = dirname(__FILE__) . "/images/img_0076.jpg";
        $image = Vips\Image::newFromFile($filename);

        $exif = $image->get("exif-data");
        $this->assertEquals(strlen($exif), 9724);

        $image->remove("exif-data");

        $this->expectException(Vips\Exception::class);
        $exif = $image->get("exif-data");
    }

    public function testVipsEnumString()
    {
        $filename = dirname(__FILE__) . "/images/img_0076.jpg";
        $image = Vips\Image::newFromFile($filename);

        $x = $image->interpretation;
        $this->assertEquals($x, "srgb");
    }

}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: expandtab sw=4 ts=4 fdm=marker
 * vim<600: expandtab sw=4 ts=4
 */
