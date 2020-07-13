<?php
/**
 * Queue Controller
 *
 * This file contains the Queue Controller class implementation
 *
 * PHP version 7
 *
 * @category AppModule
 * @package  App
 * @author   David Caicedo <caicedodavid05@gmail.com>
 * @license  http://www.php.net/license/7_01.txt  PHP License 7.3
 * @link     http://pear.php.net/package/PackageName
 */
namespace App\Http\Controllers;

use App\Job;
use App\Queue;
use Illuminate\Http\Request;
use App\ArrayHelper;

/**
 * Class Queue
 *
 * @category AppModule
 * @package  App
 * @author   David Caicedo <caicedodavid05@gmail.com>
 * @license  http://www.php.net/license/7_01.txt  PHP License 7.3
 * @link     http://pear.php.net/package/PackageName
 */
class QueueController extends Controller
{
    const JOB_NOT_FOUND_MESSAGE = 'Job not found';
    private $_queue;

    /**
     * QueueController constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_queue = new Queue();
    }

    /**
     * Get job status
     *
     * @param int     $id      id of job
     * @param Request $request request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($id, Request $request)
    {
        $status = $this->_queue->jobStatus($id);
        if (!$status) {
            return response()->json(
                ['error' => self::JOB_NOT_FOUND_MESSAGE],
                self::NOT_FOUND_ERROR_CODE
            );
        }

        return response()->json(
            $this->_queue->jobStatus($id),
            self::OK_RESPONSE_CODE
        );
    }

    /**
     * Get Average
     *
     * @param Request $request The request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function average(Request $request)
    {
        return response()->json(
            ['average' => $this->_queue->getAvgTime()],
            self::OK_RESPONSE_CODE
        );
    }

    /**
     * Push jobs in queue
     *
     * @param Request $request The request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function push(Request $request)
    {
        $data = $request->all();
        if (!ArrayHelper::isSequentialArray($data)) {
            return response()->json(
                ['id' => $this->_pushOneJob($data)],
                self::OK_RESPONSE_CODE
            );
        }

        $response = [];
        foreach ($data as $object) {
            $response[] = ['id' => $this->_pushOneJob($object)];
        }

        return response()->json($response, self::OK_RESPONSE_CODE);
    }

    /**
     * Push one job to the queue
     *
     * @param array $data Job data to be pushed
     *
     * @return int
     */
    private function _pushOneJob(array $data) : int
    {
        $job = new Job($data);
        return $this->_queue->push($job);
    }
}
