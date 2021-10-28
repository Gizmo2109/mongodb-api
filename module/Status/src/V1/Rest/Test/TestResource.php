<?php
namespace Status\V1\Rest\Test;

use http\Header;
use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use MongoDB\Client as Mongo;
use stdClass;

header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Origin: *");

class TestResource extends AbstractResourceListener
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

        if ($data->aufgabe == "createColumn") {
            $collection->insertMany([
                $data->name,
                $data->tasks
            ]);
        } elseif ($data->aufgabe == "deleteColumn") {
            $collection->deleteOne(["name" => $data->name]);
        }
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

        print_r($res);


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
        return new ApiProblem(405, 'The DELETE method has not been defined for lists');
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

        $res = $collection->find(['name' => $id]);

        $columns = [];

        foreach ($res as $kek) {
            $object = new stdClass();
            $test = $kek->jsonSerialize();
            $object->name = $test->name;
            $idk = $test->tasks->jsonSerialize();
            foreach ($idk as $kek2) {
                $idk2 = $kek2->jsonSerialize()->name;
                $array[] = $idk2;
                $object->tasks = $array;
            }
            unset($array);
            $columns[] = $object;
        }
        return $columns;


    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $collection = $this->mongo->trello->test;

        $res = $collection->find();


        $columns = [];

        foreach ($res as $kek) {
            $object = new stdClass();
            $test = $kek->jsonSerialize();
            $object->name = $test->name;
            $idk = $test->tasks->jsonSerialize();
            foreach ($idk as $kek2) {
                $idk2 = new stdClass();
                $idk2->{"name"} = $kek2->jsonSerialize()->name;
                $idk2->{"description"} = $kek2->jsonSerialize()->description;
                $idk2->{"id"} = $kek2->jsonSerialize()->id;
                $array[] = $idk2;
                $object->tasks = $array;
            }
            unset($array);
            $columns[] = $object;
        }
        return $columns;


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

        $collection = $this->mongo->trello->test;

        $collection->updateOne(
            [ "name" => $id],
            [ '$push' => [ "tasks" => $data]]
        );
    }
}
