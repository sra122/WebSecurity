<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cookie Model
 *
 * @property \App\Model\Table\UserTable|\Cake\ORM\Association\BelongsTo $User
 *
 * @method \App\Model\Entity\Cookie get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cookie newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Cookie[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cookie|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cookie patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Cookie[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cookie findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CookieTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('cookie');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('User', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('cookieuser')
            ->maxLength('cookieuser', 30)
            ->requirePresence('cookieuser', 'create')
            ->notEmpty('cookieuser');

        $validator
            ->boolean('logged_in')
            ->requirePresence('logged_in', 'create')
            ->notEmpty('logged_in');

        $validator
            ->dateTime('login_expire')
            ->allowEmpty('login_expire');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'User'));

        return $rules;
    }
}
