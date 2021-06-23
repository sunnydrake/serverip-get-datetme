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
require __DIR__ . "/bootstrap.php";
use PHPUnit\Framework\TestCase;

class ServerGetDateTime_LocalTime_Vs_CurrentIpTimeTest extends TestCase
{
    /**
     * Checks current time for matching remote time by ip (delta 10)
     */
    public function testGetDateTime()
    {
        $currentTime=new DateTime('now');
        list ($status,$iptime)=ServerGetDateTime::getDateTime();
        $this->assertSame($status,ServerGetDateTime::OK);
        $this->assertEqualsWithDelta($currentTime->getTimestamp(),$iptime->getTimestamp(),10);
    }
}
