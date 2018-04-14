<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Basket Entity
 *
 * @property int $id
 * @property string $cookieuser
 * @property int $item_id
 * @property float $price
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Item $item
 */
class Basket extends Entity
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
        'item_id' => true,
        'price' => true,
        'created' => true,
        'modified' => true,
        'item' => true
    ];
}
