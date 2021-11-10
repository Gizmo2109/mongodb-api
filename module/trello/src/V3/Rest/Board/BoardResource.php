<?php

declare(strict_types=1);

namespace trello\V3\Rest\Board;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use MongoDB\Client as Mongo;
use stdClass;

use function array_intersect;
use function array_push;
use function header;
use function in_array;
use function json_decode;
use function json_encode;
use function substr;

header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Origin: *");

class BoardResource extends AbstractResourceListener
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
        return new ApiProblem(405, 'The POST method has not been defined');
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
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
        $keyVor = getallheaders();

        $key = substr($keyVor["Authorization"], 7);

        $collection = $this->mongo->auth->oauth_access_tokens;

        $result = $collection->findOne(['access_token' => $key]);

        $user = json_decode(json_encode($result))->user_id;

        $collection = $this->mongo->auth->user_boards;

        $result = $collection->findOne(['user' => $user]);

        $final = json_decode(json_encode($result))->boards;

        $test  = $this->mongo->trello;
        $test2 = $test->listCollectionNames();
        $o     = [];
        foreach ($test2 as $i) {
            array_push($o, $i);
        }

        $finalFinal = array_intersect($final, $o);

        if (in_array($id, $finalFinal)) {
            $collection = $this->mongo->trello->$id;

            $res = $collection->find();

            $columns = [];

            foreach ($res as $kek) {
                $object       = new stdClass();
                $test         = $kek->jsonSerialize();
                $object->name = $test->name;
                $object->id   = $test->id;
                $idk          = $test->tasks->jsonSerialize();
                if (empty($idk)) {
                    $object->tasks = [];
                }
                foreach ($idk as $kek2) {
                    $idk2                  = new stdClass();
                    $idk2->{"name"}        = $kek2->jsonSerialize()->name;
                    $idk2->{"description"} = $kek2->jsonSerialize()->description;
                    $idk2->{"id"}          = $kek2->jsonSerialize()->id;
                    $array[]               = $idk2;
                    $object->tasks         = $array;
                }
                unset($array);
                $columns[] = $object;
            }
            $return       = new stdClass();
            $return->test = $columns;
            return $return;
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
        $collection = $this->mongo->trello->test;

        $res = $collection->find();

        $columns = [];

        foreach ($res as $kek) {
            $object       = new stdClass();
            $test         = $kek->jsonSerialize();
            $object->name = $test->name;
            $object->id   = $test->id;
            $idk          = $test->tasks->jsonSerialize();
            if (empty($idk)) {
                $object->tasks = [];
            }
            foreach ($idk as $kek2) {
                $idk2                  = new stdClass();
                $idk2->{"name"}        = $kek2->jsonSerialize()->name;
                $idk2->{"description"} = $kek2->jsonSerialize()->description;
                $idk2->{"id"}          = $kek2->jsonSerialize()->id;
                $array[]               = $idk2;
                $object->tasks         = $array;
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
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}
