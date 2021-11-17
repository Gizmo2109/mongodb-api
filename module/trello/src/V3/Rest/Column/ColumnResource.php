<?php

declare(strict_types=1);

namespace trello\V3\Rest\Column;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use MongoDB\Client as Mongo;

use function header;
use function intval;
use function json_decode;
use function json_encode;
use function var_dump;

header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Origin: *");

class ColumnResource extends AbstractResourceListener
{
    private $mongo;

    public function __construct()
    {
        $this->mongo = new Mongo("mongodb://admin:password@localhost:27017");
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $collection = $this->mongo->trello->boards;

        $collection->updateOne(['name' => $data->board], ['$push' => ['columns' => $data->data]]);
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        $collection = $this->mongo->trello->boards;

        $collection->updateMany([], ['$pull' => ['columns' => ['id' => intval($id)]]]);

        return true;
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
        $collection = $this->mongo->trello->boards;

        $res = $collection->findOne(['columns.id' => intval($id)]);

        $res = json_decode(json_encode($res));

        return $res->columns;
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
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
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
        $collection = $this->mongo->trello->boards;

        var_dump($data);

        //$collection->drop();
        //$this->mongo->trello->createCollection('test');
        //$collection->insertMany(json_decode(json_encode($data)));
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
        $collection = $this->mongo->trello->test;

        $collection->updateOne(
            ["name" => $id],
            ['$push' => ["tasks" => $data]]
        );
    }
}
