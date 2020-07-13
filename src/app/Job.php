<?php
/**
 * Job
 *
 * This file contains the Job class implementation
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

/**
 * Class Job
 *
 * @category AppModule
 * @package  App
 * @author   David Caicedo <caicedodavid05@gmail.com>
 * @license  http://www.php.net/license/7_01.txt  PHP License 7.3
 * @link     http://pear.php.net/package/PackageName
 */
class Job
{
    private $_command;
    private $_jobId;
    private $_processorId;
    private $_submitterId;

    /**
     * Job constructor.
     *
     * @param array $data array containing all the values
     */
    public function __construct(array $data)
    {
        $this->_command = ArrayHelper::get($data, 'command');
        $this->_jobId = ArrayHelper::get($data, 'id');
        $this->_processorId = ArrayHelper::get($data, 'process_id');
        $this->_submitterId = ArrayHelper::get($data, 'submitter_id');
    }

    /**
     * Job to array
     *
     * @return array
     */
    public function toArray() : array
    {
        return [
            'command' => $this->_command,
            'submitter_id' => $this->_submitterId,
            'job_id' => $this->_jobId,
            'process_id' => $this->_processorId
        ];
    }

    /**
     * Job to array for queue insertion
     *
     * @return array
     */
    public function toArrayForQueue() : array
    {
        return [
            'command' => $this->_command,
            'submitter_id' => $this->_submitterId,
        ];
    }

    /**
     * Execute a job
     *
     * @return bool if command was executed
     */
    public function execute() : bool
    {
        exec($this->_command, $return, $code);

        return $code === 0;
    }

    /**
     * Get the Job id
     *
     * @return int
     */
    public function getJobId() : ?int
    {
        return $this->_jobId;
    }
}
