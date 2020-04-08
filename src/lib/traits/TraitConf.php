<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    TraitConf.php
 * Created: 2020-04-09 01:31:44
 */
declare(strict_types=1);

namespace SFQiao\lib\traits;
use \SFQiao\lib\Conf;


/**
 * Trait TraitConf
 * @package SFQiao\lib\traits
 */
trait TraitConf
{
    protected $conf = null;

    public function initConf():void
    {
        $this->conf = new Conf();
    }

    public function setConf(Conf $conf):self
    {
        $this->conf = $conf;
        return $this;
    }

    public function conf():?Conf
    {
        return $this->conf;
    }
}