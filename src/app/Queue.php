<?php
/**
 * Queue
 *
 * This file contains the Queue class implementation
 *
 * PHP version 7
 *
 * @category AppModule
 * @package  App
 * @author   David Caicedo <caicedodavid05@gmail.com>
 * @license  http://www.php.net/license/7_01.txt  PHP License 7.3
 * @link     http://pear.php.net/package/PackageName
 */

namespace App;

use Illuminate\Support\Facades\DB;

/**
 * Class Queue
 *
 * @category AppModule
 * @package  App
 * @author   David Caicedo <caicedodavid05@gmail.com>
 * @license  http://www.php.net/license/7_01.txt  PHP License 7.3
 * @link     http://pear.php.net/package/PackageName
 */
class Queue
{
    const PROCESSING_STATUS = 'PROCESSING';
    const PROCESSED_STATUS = 'PROCESSED';
    protected $table;
    /**
     * Push a Job in the queue
     *
     * @param Job $job Job to add in queue
     *
     * @return int
     */
    public function push(Job $job)
    {
        return DB::table('queue')->insertGetId($job->toArrayForQueue());
    }

    /**
     * Pop a job from queue
     *
     * @return Job
     */
    public function pop() : ?Job
    {
        $row = DB::table('queue')
            ->whereRaw('id = (select min(id) from queue)')
            ->lockForUpdate()
            ->get()
            ->first();

        if (!$row) {
            return null;
        }
        $row = (array) $row;
        DB::table('queue')->delete($row['id']);

        return new Job($row);
    }

    /**
     * Add the job to finished table
     *
     * @param Job $job  The job to add in finished table
     * @param int $pid  the process pid that executed the job
     * @param int $time time in milliseconds it took to complete
     *
     * @return void
     */
    public function finished(Job $job, int $pid, int $time)
    {
        $data = $job->toArray();
        $data['process_time'] = $time;
        $data['process_id'] = $pid;
        echo "Processed Job Id: " . $job->getJobId() . "\n";
        DB::table('finished')->insert($data);
    }

    /**
     * Get Job status
     *
     * @param int $id id of the job to search
     *
     * @return array
     */
    public function jobStatus($id) : array
    {
        $row = DB::table('queue')->find($id);
        $status = self::PROCESSING_STATUS;
        if (!$row) {
            $row = DB::table('finished')
                ->where('job_id', '=', $id)
                ->get()
                ->first();
            $status = self::PROCESSED_STATUS;
            if (!$row) {
                return [];
            }
        }
        $job = new Job((array) $row);
        $job_array = $job->toArray();
        $job_array['status'] = $status;

        return $job_array;
    }

    /**
     * Get Average time
     *
     * @return string average spent time in commands
     */
    public function getAvgTime() : string
    {
        $data = DB::table('finished')->average('process_time');

        return $data . ' milliseconds';
    }
}
