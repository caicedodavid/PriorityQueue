<?php
/**
 * Consume Queue file
 *
 * This file contains the Consume Queue Command class implementation
 *
 * PHP version 7
 *
 * @category AppModule
 * @package  Command
 * @author   David Caicedo <caicedodavid05@gmail.com>
 * @license  http://www.php.net/license/7_01.txt  PHP License 7.3
 * @link     http://pear.php.net/package/PackageName
 */
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Queue;

/**
 * Class Consume Queue
 *
 * @category AppModule
 * @package  Command
 * @author   David Caicedo <caicedodavid05@gmail.com>
 * @license  http://www.php.net/license/7_01.txt  PHP License 7.3
 * @link     http://pear.php.net/package/PackageName
 */
class ConsumeQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:consume';
    private $_queue;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a queue consumer';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_queue = new Queue();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        while (true) {
            $job = $this->_queue->pop();
            if (!$job) {
                sleep(1);
                continue;
            }
            $init = self::getMilliseconds();
            $job->execute();
            $finish = self::getMilliseconds();
            $this->_queue->finished($job, getmypid(), $finish - $init);
        }
    }

    /**
     * Get Milliseconds
     *
     * @return float
     */
    public static function getMilliseconds() : float
    {
        return round(microtime(true) * 1000);
    }
}
