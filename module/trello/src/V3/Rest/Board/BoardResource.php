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
        //User anhand von Auth key
        $keyVor = getallheaders();

        $key = substr($keyVor["Authorization"], 7);

        $collection = $this->mongo->auth->oauth_access_tokens;

        $result = $collection->findOne(['access_token' => $key]);

        $user = json_decode(json_encode($result))->user_id;

        //User berechtigte Boards
        $collection = $this->mongo->auth->user_boards;

        $result = $collection->findOne(['user' => $user]);

        $berBoards = json_decode(json_encode($result))->boards;

        if (! in_array($id, $berBoards) && $berBoards[0] !== "*") {
            return false;
        }

        $collection = $this->mongo->trello->boards;

        $find = $collection->find(['name' => $id])->toArray();

        $test = json_decode(json_encode($find), true);

        return $test[0];
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $keyVor = getallheaders();

        $key = substr($keyVor["Authorization"], 7);

        $collection = $this->mongo->auth->oauth_access_tokens;

        $result = $collection->findOne(['access_token' => $key]);

        $user = json_decode(json_encode($result))->user_id;

        $collection = $this->mongo->auth->user_boards;

        $result = $collection->findOne(['user' => $user]);

        $final = json_decode(json_encode($result))->boards;

        $test  = $this->mongo->trello->boards;
        $test2 = $test->find([], ['projection' => ['name' => 1, '_id' => 0]])->toArray();
        $test3 = json_decode(json_encode($test2));
        $o     = [];
        foreach ($test3 as $i) {
            array_push($o, $i->name);
        }

        if ($final[0] !== '*') {
            $finalFinal = array_intersect($final, $o);
        } else {
            $finalFinal = $o;
        }

        $m = new stdClass();

        $m->boards = $finalFinal;

        return $m;
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
