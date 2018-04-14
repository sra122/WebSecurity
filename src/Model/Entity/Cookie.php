<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cookie Entity
 *
 * @property int $id
 * @property string $cookieuser
 * @property int $user_id
 * @property bool $logged_in
 * @property \Cake\I18n\FrozenTime $login_expire
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 */
class Cookie extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'cookieuser' => true,
        'user_id' => true,
        'logged_in' => true,
        'login_expire' => true,
        'created' => true,
        'modified' => true,
        'user' => true
    ];
}
