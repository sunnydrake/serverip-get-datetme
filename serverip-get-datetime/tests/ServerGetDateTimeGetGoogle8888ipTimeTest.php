<?php
/*
 * Author: Oleh Marychev aka SunnyDrake
 * Email: sunnydrake7@gmail.com
 * License: GPL3 or later
 */

/*
 * Author: Oleh Marychev aka SunnyDrake
 * Email: sunnydrake7@gmail.com
 * License: GPL3 or later
 */
declare(strict_types=1);
require __DIR__."/bootstrap.php";
use PHPUnit\Framework\TestCase;

class ServerGetDateTimeGetGoogle8888ipTimeTest extends TestCase
{
    /**
     * Checks 8.8.8.8 server for info retrive
     */
    public function testGetDateTime()
    {
        list ($status,$iptime)=ServerGetDateTime::getDateTime("8.8.8.8");
        $this->assertSame($status,ServerGetDateTime::OK);
        echo "Returned time for 8.8.8.8 is :".($iptime->format(ServerGetDateTime::$date_time_format))."\n";
   }
}
