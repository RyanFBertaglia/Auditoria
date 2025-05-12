<?php
namespace App\Models;

class Post
{
    private $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    public function create(array $data)
    {
        $result = $this->collection->insertOne([
            'title' => $data['title'] ?? '',
            'description' => $data['description'] ?? '',
            'location' => $data['location'] ?? '',
            'image_url' => $data['image_url'] ?? '',
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);

        return $result->getInsertedId();
    }

    public function getAll()
    {
        $opcoes = ['limit' => 50, 'sort' => ['data' => -1]];
        return $this->collection->find([], $opcoes);
    }

    public function findById($id)
    {
        return $this->collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    }

    public function delete($id)
    {
        return $this->collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    }

    public function update($id, array $data)
    {
        $updateData = [];
        foreach ($data as $key => $value) {
            if (in_array($key, ['title', 'description', 'location', 'image_url'])) {
                $updateData[$key] = $value;
            }
        }

        return $this->collection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($id)],
            ['$set' => $updateData]
        );
    }
}
