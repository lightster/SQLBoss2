<?php

App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel
{
    public $validate = array(
        'username' => array(
            'This username has already been taken' => array(
                'rule' => 'isUnique',
                'last' => false,
            ),
            'Only alphabets and numbers allowed' => array(
                'rule'       => 'alphaNumeric',
                'allowEmpty' => false,
                'required'   => true,
            ),
        ),
        'password' => array(
            'Your password must be at least 6 characters long' => array(
                'rule'       => array('minLength', 6),
                'allowEmpty' => false,
                'required'   => true,
            ),
        ),
        'group_id' => array(
            'You must be assigned to a group' => array(
                'rule'       => 'numeric',
                'allowEmpty' => false,
                'required'   => true,
            ),
        ),
    );

    public $belongsTo = array(
        'Group' => array(
            'className'  => 'Group',
            'foreignKey' => 'group_id',
        )
    );

    public $hasMany = array(
        'Connection' => array(
            'className'  => 'Connection',
            'foreignKey' => 'user_id',
        ),
        'Query' => array(
            'className'  => 'Query',
            'foreignKey' => 'user_id',
        )
    );

    public function beforeSave($options = array())
    {
        $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
        return true;
    }
}
