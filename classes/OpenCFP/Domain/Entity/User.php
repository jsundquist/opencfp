<?php

namespace OpenCFP\Domain\Entity;

use Spot\Entity;

class User extends Entity
{
    protected static $table = 'users';
    protected static $mapper = 'OpenCFP\Domain\Entity\Mapper\User';

    public static function fields()
    {
        return [
            'id' => ['type' => 'integer', 'autoincrement' => true, 'primary' => true],
            'email' => ['type' => 'string', 'length' => 255, 'required' => true],
            'password' => ['type' => 'string', 'length' => 255, 'required' => true],
            'permissions' => ['type' => 'text'],
            'activated' => ['type' => 'smallint', 'value' => 0],
            'activation_code' => ['type' => 'string', 'length' => 255],
            'activated_at' => ['type' => 'datetime'],
            'last_login' => ['type' => 'string', 'length' => 255],
            'persist_code' => ['type' => 'string', 'length' => 255],
            'reset_password_code' => ['type' => 'string', 'length' => 255],
            'first_name' => ['type' => 'string', 'length' => 255],
            'last_name' => ['type' => 'string', 'length' => 255],
            'created_at' => ['type' => 'datetime', 'value' => new \DateTime()],
            'updated_at' => ['type' => 'datetime', 'value' => new \DateTime()],
            'company' => ['type' => 'string', 'length' => 255],
            'twitter' => ['type' => 'string', 'length' => 255],
            'airport' => ['type' => 'string', 'length' => 5],
            'hotel' => ['type' => 'smallint', 'value' => 0],
            'transportation' => ['type' => 'smallint', 'value' => 0],
            'info' => ['type' => 'text'],
            'bio' => ['type' => 'text'],
            'photo_path' => ['type' => 'string', 'length' => 255],
            'api_token' => ['type' => 'string', 'length' => 32],
        ];
    }

    public static function relations(\Spot\MapperInterface $mapper, \Spot\EntityInterface $entity)
    {
        return [
            'talks' => $mapper->hasMany($entity, 'OpenCFP\Domain\Entity\Talk', 'user_id'),
            'groups' => $mapper->hasManyThrough($entity, '\OpenCFP\Domain\Entity\Group', '\OpenCFP\Domain\Entity\UserGroup', 'group_id', 'user_id'),
        ];
    }

    /**
     * Getter for permissions property
     * @return array
     */
    protected function getPermissions()
    {
        return json_decode($this->_data['permissions']);
    }

    /**
     * Setter for permissions property
     * @param  string|array $permissions JSON string or an array of permissions
     * @return string       JSON
     */
    protected function setPermissions($permissions)
    {
        $json = $permissions;

        if (is_string($permissions) && json_decode($permissions) === null) {
            return "{}";
        }

        if (is_array($permissions)) {
            $json = json_encode($permissions);
        }

        return $json;
    }

    public function getApiToken()
    {
        return $this->_data['api_token'];
    }

    public function getId()
    {
        return $this->_data['id'];
    }
}