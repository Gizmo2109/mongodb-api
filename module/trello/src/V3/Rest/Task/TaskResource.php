<?php
namespace trello\V3\Rest\Task;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use MongoDB\Client as Mongo;
use stdClass;

header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");

class TaskResource extends AbstractResourceListener
{

    private $mongo;

    public function __construct() {
        $this->mongo = new Mongo("mongodb://admin:password@localhost:27017");;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $collection = $this->mongo->trello->test;

        $collection->updateOne(
          ["id" => $data->id],
          ['$push' => [ "tasks" => $data->task]]
        );
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        $collection = $this->mongo->trello->test;

        $res = $collection->updateMany(
            [],
            ['$pull' => ['tasks' => ['id' => $id]]]
        );

        $test = $res->getModifiedCount();
        if ($test == "0") {
            return false;
        } elseif ($test == "1") {
            return true;
        }
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        $collection = $this->mongo->trello->test;

        $res = $collection->find();

        foreach ($res as $cur) {
            $data = json_decode(json_encode($cur));
            foreach ($data->tasks as $task) {
                if ($task->id == $id) {
                    $array = json_decode(json_encode($task), true);
                    return $array;
                }
            }
        }
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return new ApiProblem(405, 'The GET method has not been defined for collections');
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        $collection = $this->mongo->trello->test;

        $collection->updateOne(
            ['tasks.id' => $id],
            ['$set' => ['tasks.$.' . $data->field => $data->val]]
        );

    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}
